<?php

class MainController extends Controller
{
        public function init(){
            if (Yii::app()->user->isGuest){
                $this->redirect(Yii::app()->createUrl('site/login'));
            }
            else{
                if (Yii::app()->user->user_type != '1') {
                    $this->redirect(Yii::app()->baseUrl . '/mission');
                }
            }
        }
    
	public function actionIndex()
	{
            if (isset($_POST['Entry'])) {
                
                if ($_POST['Entry']['status'] == ''){
                    $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->user->id, 'order'=>'id DESC')));
                }
                else if ($_POST['Entry']['status'] != '') {
                    $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->user->id . ' AND status = ' . $_POST['Entry']['status'], 'order'=>'id DESC')));
                }
                
                if (isset($dataProvider)) {
                    $this->renderPartial('_entry_gridview', array('dataProvider'=>$dataProvider),false,true);
                }
                Yii::app()->end();
            }
            
            $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->user->id, 'order'=>'id DESC')));            
            if (isset($dataProvider)) {
                $grid = $this->renderPartial('_entry_gridview', array('dataProvider'=>$dataProvider),true,true);
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
                
                if($model->validate()){
                    if ($model->save()) {
                        
                        //--------Send Email notification to Referral---------------
                        $message = $this->renderPartial('//email/template/referral_changed_entry', array('entry_id'=>$id,'client_name'=>$model->referrelUser->first_name,'client_company'=>$model->referrelUser->company,'customer'=>$model,'link'=> Yii::app()->request->hostInfo . Yii::app()->baseUrl .  '?returnUrl=/admin/entry/update/id/' . $id), true);
                        
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
                        //----------------------------------------------------------
                        
                        Yii::app()->user->setFlash('success','Referral Updated');
                        $this->redirect(array('referral/main'));
                    }
                }
            }
            
            $this->render('update', array('model'=>$model,'status'=>$status));
	}
}