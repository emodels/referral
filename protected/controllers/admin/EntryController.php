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
                            $mailer->Subject = 'Dwellings Group Referral Management System - New Referral Added';
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
        $first_name = '';
        $last_name = '';

            if (isset($_POST['Entry']) || Yii::app()->request->isAjaxRequest) {
                
                if (isset($_POST['Entry'])) {
                    
                    $first_name = $_POST['Entry']['first_name'];
                    $last_name = $_POST['Entry']['last_name'];
                    
                    if ($_POST['Entry']['referrel_user'] == '' && $_POST['Entry']['status'] == ''){
                        unset(Yii::app()->session['referrel_user']);
                        unset(Yii::app()->session['status']);
                    }
                    else if ($_POST['Entry']['referrel_user'] != '' && $_POST['Entry']['status'] == ''){
                        Yii::app()->session['referrel_user'] = $_POST['Entry']['referrel_user'];
                        unset(Yii::app()->session['status']);
                        $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . $_POST['Entry']['referrel_user'], 'order'=>'id DESC'), 'pagination' => false));
                    }
                    else if ($_POST['Entry']['referrel_user'] != '' && $_POST['Entry']['status'] != '') {
                        Yii::app()->session['referrel_user'] = $_POST['Entry']['referrel_user'];
                        Yii::app()->session['status'] = $_POST['Entry']['status'];
                        $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . $_POST['Entry']['referrel_user'] . ' AND status = ' . $_POST['Entry']['status'], 'order'=>'id DESC'), 'pagination' => false));
                    }
                }
                
                if (Yii::app()->request->isAjaxRequest) {
                    if (isset(Yii::app()->session['referrel_user']) && !isset(Yii::app()->session['status'])) {
                        $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->session['referrel_user'], 'order'=>'id DESC'), 'pagination' => false));
                    }
                    if (isset(Yii::app()->session['referrel_user']) && isset(Yii::app()->session['status'])) {
                        $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->session['referrel_user'] . ' AND status = ' . Yii::app()->session['status'], 'order'=>'id DESC'), 'pagination' => false));
                    }
                }
                
                /**
                 * Filter records by First name and Last name
                 */
                if ($first_name != '' && $last_name == '') {
                    $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'first_name LIKE "' . $first_name . '%"', 'order'=>'id DESC'), 'pagination' => false));
                }
                else if ($first_name == '' && $last_name != ''){
                    $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'last_name LIKE "' . $last_name . '%"', 'order'=>'id DESC'), 'pagination' => false));
                }
                else if ($first_name != '' && $last_name != ''){
                    $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'first_name LIKE "' . $first_name . '%" OR last_name LIKE "' . $last_name . '%"', 'order'=>'id DESC'), 'pagination' => false));
                }

                
                if (isset($dataProvider)) {
                    echo $this->renderPartial('_entry_gridview', array('dataProvider'=>$dataProvider), true, false);
                }
                else{
                    $partners = User::model()->findAll('user_type = :user_type', array(':user_type'=>'1'));
                    foreach ($partners as $partner) {
                        $dataProvider_custom = new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . $partner->id, 'order'=>'id DESC'), 'pagination' => false));
                        echo $this->renderPartial('_entry_gridview', array('dataProvider'=>$dataProvider_custom,'grid_title'=>$partner->company), true, false);
                    }
                }

                Yii::app()->end();
            }
            
            $this->render('index', array('ShowAll'=>TRUE));
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
                        $message = $this->renderPartial('//email/template/update_entry', array('entry_id'=>$id,'client_name'=>$model->referrelUser->first_name,'customer'=>$model,'link'=> Yii::app()->request->hostInfo . Yii::app()->baseUrl .  '?returnUrl=/referral/main/update/id/' . $id), true);
                        
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
                            $mailer->Subject = 'Dwellings Group Referral Management System - Referral Updated';
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