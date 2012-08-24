<?php

class EntryController extends Controller
{
        public function init(){
            if (Yii::app()->user->isGuest){
                $this->redirect(Yii::app()->createUrl('site/login'));
            }
            else{
                if (Yii::app()->user->user_type != '0') {
                    $this->redirect(Yii::app()->baseUrl . '/mission');
                }
            }
        }
    
	public function actionAdd()
	{
            $model = new Entry();

            $model->entry_added_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
            $model->entry_last_updated_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
            $model->referral_commission_amount = 0;
            
            if (isset($_POST['Entry'])) {
                $model->attributes = $_POST['Entry'];
                
                if($model->validate()){
                    if ($model->save()) {
                        
                        //--------Send Email notification to Referral---------------
                        $message = $this->renderPartial('//email/template/update_entry', array('entry_id'=>$model->id,'client_name'=>$model->referrelUser->first_name,'link'=> Yii::app()->request->hostInfo . Yii::app()->baseUrl .  '?returnUrl=/referral/main/update/id/' . $id), true);
                        
                        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                        $mailer->Host = Yii::app()->params['SMTP_Host'];
                        $mailer->IsSMTP();
                        $mailer->SMTPAuth = true;
                        $mailer->Username = Yii::app()->params['SMTP_Username'];
                        $mailer->Password = Yii::app()->params['SMTP_password'];
                        $mailer->From = Yii::app()->params['SMTP_Username'];
                        $mailer->AddReplyTo(Yii::app()->params['SMTP_Username']);
                        $mailer->AddAddress('danesh@dwellingsgroup.com.au');
                        $mailer->FromName = 'Dwellings Group';
                        $mailer->CharSet = 'UTF-8';
                        $mailer->Subject = 'Dwellings Group Referral Management System - New Entry Added';
                        $mailer->IsHTML();
                        $mailer->Body = $message;
                        
                        try{     
                            $mailer->Send();
                        }
                        catch (Exception $ex){
                            echo $ex->getMessage();
                        }
                        //----------------------------------------------------------
                        
                        Yii::app()->user->setFlash('success','Entry Record Added');
                        $this->redirect(array('admin/user'));
                    }
                }
            }
            
            $this->render('add', array('model'=>$model));
	}

        public function actionListStatus(){
            $data = Status::model()->findAll('referral_user=:id',array(':id'=>$_POST['Entry']['referrel_user']));
            $data=CHtml::listData($data,'id','status');

            echo CHtml::tag('option',array('value'=>''),'Select Status',true);
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
            }
        }
        
	public function actionIndex()
	{
            if (isset($_POST['Entry'])) {
                
                if ($_POST['Entry']['referrel_user'] != '' && $_POST['Entry']['status'] == ''){
                    $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . $_POST['Entry']['referrel_user'], 'order'=>'id DESC')));
                }
                else if ($_POST['Entry']['referrel_user'] != '' && $_POST['Entry']['status'] != '') {
                    $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . $_POST['Entry']['referrel_user'] . ' AND status = ' . $_POST['Entry']['status'], 'order'=>'id DESC')));
                }
                
                if (isset($dataProvider)) {
                    $this->renderPartial('_entry_gridview', array('dataProvider'=>$dataProvider),false,true);
                }
                Yii::app()->end();
            }
            
            $this->render('index');
	}

	public function actionUpdate($id)
	{
            $model = Entry::model()->findByPk($id);
            $status = CHtml::listData(Status::model()->findAll('referral_user=:referral_user', array(':referral_user' => $model->referrel_user)), 'id', 'status');
            
            if (isset($_POST['Entry'])) {
                $model->attributes = $_POST['Entry'];
                $model->entry_last_updated_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
                
                if($model->validate()){
                    if ($model->save()) {
                        
                        //--------Send Email notification to Referral---------------
                        $message = $this->renderPartial('//email/template/update_entry', array('entry_id'=>$id,'client_name'=>$model->referrelUser->first_name,'link'=> Yii::app()->request->hostInfo . Yii::app()->baseUrl .  '?returnUrl=/referral/main/update/id/' . $id), true);
                        
                        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                        $mailer->Host = Yii::app()->params['SMTP_Host'];
                        
                        $mailer->SMTPDebug = FALSE;
                        $mailer->Mailer='smtp';
                        $mailer->SMTPSecure='ssl';
                        
                        $mailer->IsSMTP();
                        $mailer->SMTPAuth = true;
                        $mailer->Username = Yii::app()->params['SMTP_Username'];
                        $mailer->Password = Yii::app()->params['SMTP_password'];
                        $mailer->From = Yii::app()->params['SMTP_Username'];
                        $mailer->AddReplyTo(Yii::app()->params['SMTP_Username']);
                        $mailer->AddAddress('danesh@dwellingsgroup.com.au');
                        $mailer->FromName = 'Dwellings Group';
                        $mailer->CharSet = 'UTF-8';
                        $mailer->Subject = 'Dwellings Group Referral Management System - Entry Updated';
                        $mailer->IsHTML();
                        $mailer->Body = $message;
                        
                        try{     
                            $mailer->Send();
                        }
                        catch (Exception $ex){
                            echo $ex->getMessage();
                        }
                        //----------------------------------------------------------
                        
                        Yii::app()->user->setFlash('success','Entry Record Updated');
                        $this->redirect(array('admin/user'));
                    }
                }
            }
            
            $this->render('update', array('model'=>$model,'status'=>$status));
	}
        
        public function actionDelete($id){
            if(Yii::app()->request->isPostRequest)
            {
                $entry = Entry::model()->findByPk($id);
                if(isset($entry)){
                    if($entry->delete()){
                            echo 'Deleted';
                    }else{
                            echo 'Error while Deleting';
                    }
                }
            }else{
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            }
        }
}