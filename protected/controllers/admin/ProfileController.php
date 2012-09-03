<?php

class ProfileController extends Controller
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
                $model = User::model()->find('user_type = :user_type', array(':user_type'=>'0'));
                
                if (isset($_POST['User'])) {
                    $model->attributes = $_POST['User'];
                    
                    if($model->save()){
                        Yii::app()->user->setFlash('success', "Admin Profile Updated.");
                        $this->redirect(Yii::app()->baseUrl . '/admin/user');
                    }
                    else{
                        Yii::app()->user->setFlash('notice', 'Error saving record');
                    }
                }
                
		$this->render('index',array('model' => $model));
	}
}