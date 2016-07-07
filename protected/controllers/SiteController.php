<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'

                $returnUrl = Yii::app()->request->getQuery('returnUrl');

                if (isset($returnUrl)) {
                    Yii::app()->user->setReturnUrl(Yii::app()->request->getQuery('returnUrl'));
                    $this->redirect(array('site/login'));
                }
            
                $this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
                            if (Yii::app()->user->returnUrl == Yii::app()->baseUrl . '/index.php') {
                                $this->redirect(Yii::app()->baseUrl . '/mission');
                            }
                            else{
                                $this->redirect(Yii::app()->baseUrl . Yii::app()->user->returnUrl);
                            }
                        }        
		}

        if (isset($_POST['reset'])) {

            $username = $_POST['LoginForm']['username'];

            $user = User::model()->find("username = '" . $username . "'");

            if (isset($user)) {

                $settingsArray = array();

                $admin = User::model()->find('user_type = 0');

                if (isset($admin)) {

                    $settingsArray['logo'] = $admin->logo;
                    $settingsArray['logo_width'] = $admin->logo_width;
                    $settingsArray['logo_height'] = $admin->logo_height;
                    $settingsArray['site_name'] = $admin->company;
                    $settingsArray['site_address'] = $admin->header_title;
                }

                $message = $this->renderPartial('//email/template/password_request', array('user'=>$user, 'settingsArray'=>$settingsArray), true);

                if (isset($message) && $message != "") {

                    $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                    $mailer->Host = Yii::app()->params['SMTP_Host'];
                    $mailer->IsSMTP();
                    $mailer->SMTPAuth = true;
                    $mailer->Username = Yii::app()->params['SMTP_Username'];
                    $mailer->Password = Yii::app()->params['SMTP_password'];
                    $mailer->From = Yii::app()->params['SMTP_Username'];
                    $mailer->AddReplyTo(Yii::app()->params['SMTP_Username']);
                    $mailer->AddAddress($user->email);
                    $mailer->AddCC(Yii::app()->params['adminEmail']);
                    $mailer->FromName = $admin->company;
                    $mailer->CharSet = 'UTF-8';
                    $mailer->Subject = $admin->company . ' - Password request';
                    $mailer->IsHTML();
                    $mailer->Body = $message;

                    try{

                        $mailer->Send();
                    }
                    catch (Exception $ex){

                        echo $ex->getMessage();
                    }

                    /*-----( Add to Mail Log )------*/

                    Utility::addMailLog(
                        Yii::app()->params['SMTP_Username'],
                        $admin->company,
                        $user->email,
                        $user->first_name . ' ' . $user->last_name,
                        $admin->company . ' - Password request',
                        $message,
                        $user->id,
                        1);
                }

                Yii::app()->user->setFlash('success', 'Password has been sent to your email : "' . $user->email . '"');

            } else {

                Yii::app()->user->setFlash('error', 'Unable to find any account with given user name : "' . $username . '"');
            }
        }

		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    public function actionChangePassword() {

        $model = User::model()->findByPk(Yii::app()->user->id);

        if (isset($_POST['User'])) {

            $model->attributes = $_POST['User'];

            if ($model->save()) {

                Yii::app()->user->setFlash('success', 'Password Changed Successfully');
                Yii::app()->clientScript->registerMetaTag('2; url=' . Yii::app()->baseUrl . '/mission', null, 'refresh');
            }
        }

        $this->render('changepassword', array('model'=>$model));
    }

    public function actionCronjob(){

        $criteria = new CDbCriteria;
        $criteria->join='LEFT JOIN status ON status.id = t.status';
        $criteria->addCondition('date_add(t.entry_last_updated_date, INTERVAL status.remind_days DAY) <= "'. Yii::app()->dateFormatter->format('yyyy-MM-dd hh:mm:ss',  time()) . '"');
        $criteria->addCondition('status.remind_days > 0', 'AND');

        $entryCollec = Entry::model()->findAll($criteria);

        foreach ($entryCollec as $model) {

            //--------Send Email notification to Referral---------------
            $message = $this->renderPartial('//email/template/notify_reminder', array('entry_id'=>$model->id,'client_name'=>$model->referrelUser->first_name,'customer'=>$model,'link'=> Yii::app()->request->hostInfo . Yii::app()->baseUrl .  '?returnUrl=/referral/main/update/id/' . $model->id), true);

            if (isset($message) && $message != "") {

                $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                $mailer->Host = Yii::app()->params['SMTP_Host'];
                $mailer->IsSMTP();
                $mailer->SMTPAuth = true;
                $mailer->Username = Yii::app()->params['SMTP_Username'];
                $mailer->Password = Yii::app()->params['SMTP_password'];
                $mailer->From = Yii::app()->params['SMTP_Username'];
                $mailer->AddReplyTo(Yii::app()->params['SMTP_Username']);
                $mailer->AddAddress($model->referrelUser->email);
                $mailer->AddCC(Yii::app()->params['adminEmail']);
                $mailer->FromName = Yii::app()->user->site_name;
                $mailer->CharSet = 'UTF-8';
                $mailer->Subject = 'Pending Action : Reminder for Referral ID : ' . $model->id;
                $mailer->IsHTML();
                $mailer->Body = $message;

                try{
                    $mailer->Send();
                }
                catch (Exception $ex){
                    echo $ex->getMessage();
                }

                /*-----( Add to Mail Log )------*/

                Utility::addMailLog(
                    Yii::app()->params['SMTP_Username'],
                    Yii::app()->user->site_name,
                    $model->referrelUser->email,
                    $model->referrelUser->first_name . ' ' . $model->referrelUser->last_name,
                    'Pending Action : Reminder for Referral ID : ' . $model->id,
                    $message,
                    $model->referrel_user,
                    1);
            }
            //----------------------------------------------------------
        }

        echo 'Sent reminder emails to ' . count($entryCollec) . ' number of Referrals <br><br>';
        echo 'Cron Job completed.';
    }

    public function actionCronjobReminder(){

        $entryCollec = Entry::model()->findAll('remind = 1 AND remind_date = CURDATE()');

        foreach ($entryCollec as $model) {

            //--------Send Email notification to Referral---------------
            $message = $this->renderPartial('//email/template/notify_on_reminder_date', array('entry_id'=>$model->id,'client_name'=>$model->referrelUser->first_name,'customer'=>$model,'link'=> Yii::app()->request->hostInfo . Yii::app()->baseUrl .  '?returnUrl=/referral/main/update/id/' . $model->id), true);

            if (isset($message) && $message != "") {

                $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                $mailer->Host = Yii::app()->params['SMTP_Host'];
                $mailer->IsSMTP();
                $mailer->SMTPAuth = true;
                $mailer->Username = Yii::app()->params['SMTP_Username'];
                $mailer->Password = Yii::app()->params['SMTP_password'];
                $mailer->From = Yii::app()->params['SMTP_Username'];
                $mailer->AddReplyTo(Yii::app()->params['SMTP_Username']);
                $mailer->AddAddress($model->referrelUser->email);
                $mailer->AddCC(Yii::app()->params['adminEmail']);
                $mailer->FromName = Yii::app()->user->site_name;
                $mailer->CharSet = 'UTF-8';
                $mailer->Subject = 'Pending Action : Reminder for Referral ID : ' . $model->id;
                $mailer->IsHTML();
                $mailer->Body = $message;

                try{
                    $mailer->Send();
                }
                catch (Exception $ex){
                    echo $ex->getMessage();
                }

                /*-----( Add to Mail Log )------*/

                Utility::addMailLog(
                    Yii::app()->params['SMTP_Username'],
                    Yii::app()->user->site_name,
                    $model->referrelUser->email,
                    $model->referrelUser->first_name . ' ' . $model->referrelUser->last_name,
                    'Pending Action : Reminder for Referral ID : ' . $model->id,
                    $message,
                    $model->referrel_user,
                    1);
            }
            //----------------------------------------------------------
        }

        echo 'Sent reminder emails to ' . count($entryCollec) . ' number of Referrals <br><br>';
        echo 'Cron Job completed.';
    }

    public function actionCronjobSettlementDate(){

        $propertyCollec = Property::model()->findAll('send_reminder >= 1 AND expected_settlement_date = CURDATE() + INTERVAL send_reminder WEEK');

        foreach ($propertyCollec as $property) {

            //--------Send Email notification to Referral---------------
            $message = $this->renderPartial('//email/template/notify_on_settlement_date', array('property'=>$property, 'customer'=> $property->entry0), true);

            if (isset($message) && $message != "") {

                $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                $mailer->Host = Yii::app()->params['SMTP_Host'];
                $mailer->IsSMTP();
                $mailer->SMTPAuth = true;
                $mailer->Username = Yii::app()->params['SMTP_Username'];
                $mailer->Password = Yii::app()->params['SMTP_password'];
                $mailer->From = Yii::app()->params['SMTP_Username'];
                $mailer->AddReplyTo(Yii::app()->params['SMTP_Username']);
                $mailer->AddAddress(Yii::app()->params['adminEmail']);
                $mailer->FromName = Yii::app()->user->site_name;
                $mailer->CharSet = 'UTF-8';
                $mailer->Subject = 'Reminder based on Settlement Date set for Property : ' . $property->address;
                $mailer->IsHTML();
                $mailer->Body = $message;

                try{
                    $mailer->Send();
                }
                catch (Exception $ex){
                    echo $ex->getMessage();
                }

                /*-----( Add to Mail Log )------*/

                Utility::addMailLog(
                    Yii::app()->params['SMTP_Username'],
                    Yii::app()->user->site_name,
                    Yii::app()->params['adminEmail'],
                    'Admin User',
                    'Reminder based on Settlement Date set for Property : ' . $property->address,
                    $message,
                    1,
                    1);
            }
            //----------------------------------------------------------
        }

        echo 'Sent reminder emails to ' . count($propertyCollec) . ' number of Properties <br><br>';
        echo 'Cron Job completed.';
    }

    public function actionCronjobBirthday(){

        $entryCollec = Entry::model()->findAll('date_of_birth IS NOT NULL AND MONTH(date_of_birth) = MONTH(CURDATE()) AND DAY(date_of_birth) = DAY(CURDATE())');

        foreach ($entryCollec as $model) {

            /*---( Check if email already sent today )---*/

            if (MailLog::model()->count("entry = " . $model->id . " AND DATE(entry_date) = CURDATE() AND subject = '" . ucwords($model->first_name) . ", Wish you a very happy birthday !!!" . "'") > 0) {

                echo 'Birthday email already sent to ' . $model->first_name . ' and therefore skipped <br><br>';
                continue;
            }

            //--------Send birthday notification to Referral---------------

            $message = $this->renderPartial('//email/template/notify_on_birthday', array('model'=>$model), true);

            if (isset($message) && $message != "") {

                $mailer = Yii::createComponent('application.extensions.mailer.EMailer');

                //$mailer->AddEmbeddedImage('images/happy_birthday_background.jpg', 'birthday');

                $mailer->Host = Yii::app()->params['SMTP_Host'];
                $mailer->IsSMTP();
                $mailer->SMTPAuth = true;
                $mailer->Username = Yii::app()->params['SMTP_Username'];
                $mailer->Password = Yii::app()->params['SMTP_password'];
                $mailer->From = Yii::app()->params['SMTP_Username'];
                $mailer->AddReplyTo(Yii::app()->params['SMTP_Username']);
                $mailer->AddAddress($model->email);
                $mailer->AddCC(Yii::app()->params['adminEmail']);
                $mailer->FromName = 'Dwellings Group';
                $mailer->CharSet = 'UTF-8';
                $mailer->Subject = ucwords($model->first_name) . ', Wish you a very happy birthday !!!';
                $mailer->IsHTML();
                $mailer->Body = $message;

                try{
                    $mailer->Send();
                }
                catch (Exception $ex){
                    echo $ex->getMessage();
                }

                /*-----( Add to Mail Log )------*/

                Utility::addMailLog(
                    Yii::app()->params['SMTP_Username'],
                    'Dwellings Group',
                    $model->email,
                    $model->first_name . ' ' . $model->last_name,
                    ucwords($model->first_name) . ', Wish you a very happy birthday !!!',
                    $message,
                    $model->id,
                    0);
            }
            //----------------------------------------------------------
        }

        echo 'Sent birthday emails to ' . count($entryCollec) . ' number of Referrals <br><br>';
        echo 'Cron Job completed.';
    }

    public function actionMailLog($entry, $type){

        if ($type == 0) {

            $user = Entry::model()->findByPk($entry);

        } else {

            $user = User::model()->findByPk($entry);
        }

        $dataProvider = new CActiveDataProvider('MailLog', array('criteria'=>array('condition'=> 'entry = ' . $entry . ' AND type = ' . $type, 'order'=>'id DESC'), 'pagination' => false));

        $this->render('mail_log', array('dataProvider'=>$dataProvider, 'user'=>$user));
    }
}