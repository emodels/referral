<?php

class StatusController extends Controller
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
    
	public function actionIndex()
	{
            $model = User::model()->findByPk($_GET['id']);
            
            $dataProvider=new CActiveDataProvider('Status', array('criteria'=>array('condition'=> 'referral_user = ' . $_GET['id'], 'order'=>'id DESC')));
            $this->render('index',array(
                'dataProvider'=>$dataProvider,'referral_user_name'=> $model->company
            ));            
	}
        
        public function actionAdd($id){
            $model = new Status();
            $model->referral_user = $id;
            
            if (isset($_POST['Status'])) {
                $model->attributes = $_POST['Status'];
                
                if ($model->save()) {
                    Yii::app()->user->setFlash('success','Status Added');
                    $this->redirect(array('admin/status/' . $id));
                }
                else{
                    print_r($model->getErrors());
                }
            }
            
            $this->render('add',array('model'=>$model));
        }
        
        public function actionUpdate($id){
            $model = Status::model()->findByPk($id);
            
            if (isset($_POST['Status'])) {
                $model->attributes = $_POST['Status'];
                
                if ($model->save()) {
                    Yii::app()->user->setFlash('success','Status Updated');
                    $this->redirect(array('admin/status/' . $model->referral_user));
                }
                else{
                    print_r($model->getErrors());
                }
            }
            
            $this->render('update',array('model'=>$model));
        }
        
        public function actionDelete($id){
            if(Yii::app()->request->isPostRequest)
            {
                $status = Status::model()->findByPk($id);
                if(isset($status)){
                    if($status->delete()){
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