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
        
        public function actionCronjob(){
            $criteria = new CDbCriteria;
            $criteria->addCondition('entry_last_updated_date <= "'. Yii::app()->dateFormatter->format('yyyy-MM-dd hh:mm:ss',  strtotime("-7 days",time())) . '"');       
            
            $entryCollec = Entry::model()->findAll($criteria);
            
            foreach ($entryCollec as $model) {
                //--------Send Email notification to Referral---------------
                $message = $this->renderPartial('//email/template/notify_reminder', array('entry_id'=>$model->id,'client_name'=>$model->referrelUser->first_name,'link'=> Yii::app()->request->hostInfo . Yii::app()->baseUrl .  '?returnUrl=/referral/main/update/id/' . $model->id), true);

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
                $mailer->FromName = 'Dwellings Group';
                $mailer->CharSet = 'UTF-8';
                $mailer->Subject = 'Dwellings Group Referral Management System - Reminder for Entry ID : ' . $model->id;
                $mailer->IsHTML();
                $mailer->Body = $message;

                try{     
                    $mailer->Send();
                }
                catch (Exception $ex){
                    echo $ex->getMessage();
                }
                //----------------------------------------------------------
            }
            
            echo 'Sent reminder emails to ' . count($entryCollec) . 'number of Referrals <br><br>';
            echo 'Cron Job completed.';
        }
}