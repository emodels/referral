<?php

class MainController extends Controller
{
        public $allow_add_referral = false;
    
        public function init(){
            if (Yii::app()->user->isGuest){
                $this->redirect(Yii::app()->createUrl('site/login'));
            }
            else{
                if (Yii::app()->user->user_type != '1') {
                    $this->redirect(Yii::app()->baseUrl . '/mission');
                }
            }
            
            if (!Yii::app()->user->isGuest) {
                $user = User::model()->findByPk(Yii::app()->user->id);
                
                if (isset($user)) {
                    $this->allow_add_referral = $user->allow_add_referral;
                }
            }
        }
    
	public function actionIndex()
	{
            if (isset($_POST['Entry']) || Yii::app()->request->isAjaxRequest) {
                
                if (isset($_POST['Entry'])) {
                    if ($_POST['Entry']['status'] == ''){
                        unset(Yii::app()->session['status']);
                        $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->user->id, 'order'=>'id DESC')));
                    }
                    else if ($_POST['Entry']['status'] != '') {
                        Yii::app()->session['status'] = $_POST['Entry']['status'];
                        $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->user->id . ' AND status = ' . $_POST['Entry']['status'], 'order'=>'id DESC')));
                    }
                }
                
                if (Yii::app()->request->isAjaxRequest) {
                    if (isset(Yii::app()->session['status'])) {
                        $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->user->id . ' AND status = ' . Yii::app()->session['status'], 'order'=>'id DESC')));
                    }
                    else{
                        $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->user->id, 'order'=>'id DESC')));            
                    }
                }
                
                if (isset($dataProvider)) {
                    echo $this->renderPartial('_entry_gridview', array('dataProvider'=>$dataProvider),true,false);
                }
                
                Yii::app()->end();
            }
            
            $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->user->id, 'order'=>'id DESC')));            
            if (isset($dataProvider)) {
                $grid = $this->renderPartial('_entry_gridview', array('dataProvider'=>$dataProvider),true,false);
            }
            $this->render('index', array('grid'=>$grid));
	}
        
	public function actionUpdate($id)
	{
            $model = Entry::model()->findByPk($id);
            $status = CHtml::listData(Status::model()->findAll('referral_user=:referral_user', array(':referral_user' => $model->referrel_user)), 'id', 'status');
            
            if (isset($_POST['Entry'])) {

                $model->attributes = $_POST['Entry'];
                $model->entry_last_updated_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());

                if (isset($model->remind_date) && $model->remind_date !== '') {

                    $model->remind_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->remind_date);

                } else {

                    $model->remind_date = null;
                }

                if (isset($model->date_of_birth) && $model->date_of_birth !== '') {

                    $model->date_of_birth = Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->date_of_birth);

                } else {

                    $model->date_of_birth = null;
                }

                if($model->validate()){

                    if ($model->save()) {
                        
                        //--------Send Email notification to Referral---------------
                        $message = $this->renderPartial('//email/template/referral_changed_entry', array('entry_id'=>$id,'client_name'=>$model->referrelUser->first_name,'client_company'=>$model->referrelUser->company,'customer'=>$model,'link'=> Yii::app()->request->hostInfo . Yii::app()->baseUrl .  '?returnUrl=/admin/entry/update/id/' . $id), true);
                        
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
                            $mailer->FromName = 'Dwellings Group';
                            $mailer->CharSet = 'UTF-8';
                            $mailer->Subject = 'Referral Management System - Partner (' . $model->referrelUser->company . ') changed Referral Status for ID : ' . $id;
                            $mailer->IsHTML();
                            $mailer->Body = $message;

                            try{     
                                $mailer->Send();
                            }
                            catch (Exception $ex){
                                echo $ex->getMessage();
                            }
                        }
                        //----------------------------------------------------------
                        
                        Yii::app()->user->setFlash('success','Referral Updated');

                        $this->redirect(array('referral/main'));
                    }
                }
            }
            
            $this->render('update', array('model'=>$model,'status'=>$status));
	}
        
        public function actionAddReferral(){

            $model = new Entry();

            $model->referrel_user = Yii::app()->user->id;
            $model->entry_added_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
            $model->entry_last_updated_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
            $model->referral_commission_amount = 0;
            
            if (isset($_POST['Entry'])) {

                $model->attributes = $_POST['Entry'];

                if (isset($model->remind_date) && $model->remind_date !== '') {

                    $model->remind_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->remind_date);

                } else {

                    $model->remind_date = null;
                }

                if (isset($model->date_of_birth) && $model->date_of_birth !== '') {

                    $model->date_of_birth = Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->date_of_birth);

                } else {

                    $model->date_of_birth = null;
                }

                if($model->validate()){

                    if ($model->save()) {
                        
                        //--------Send Email notification to Referral---------------
                        $message = $this->renderPartial('//email/template/add_entry', array('entry_id'=>$model->id,'company'=>$model->referrelUser->company,'client_name'=>$model->referrelUser->first_name,'customer'=>$model,'link'=> Yii::app()->request->hostInfo . Yii::app()->baseUrl .  '?returnUrl=/referral/main/update/id/' . $model->id), true);
                        
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
                            $mailer->FromName = 'Dwellings Group';
                            $mailer->CharSet = 'UTF-8';
                            $mailer->Subject = 'Dwellings Group Referral Management System - New Referral Added by Partner : ' . $model->referrelUser->company;
                            $mailer->IsHTML();
                            $mailer->Body = $message;

                            try{     
                                $mailer->Send();
                            }
                            catch (Exception $ex){
                                echo $ex->getMessage();
                            }
                        }
                        //----------------------------------------------------------
                        
                        Yii::app()->user->setFlash('success','Referral Added');

                        $this->redirect(array('referral/main'));
                    }
                }
            }
            
            $this->render('add', array('model'=>$model));
        }
}