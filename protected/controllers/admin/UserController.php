<?php

class UserController extends Controller
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
                $model = new User;
               
                if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                    echo CActiveForm::validate( array( $model)); 
                    Yii::app()->end(); 
                }
                
                if (isset($_POST['User'])) {
                    $model->attributes = $_POST['User'];
                    $model->user_type = 1;
                    
                    if (User::model()->findByAttributes(array('username'=>$model->username))) {
                        $model->addError('user_name', 'User name already used, try else');
                        Yii::app()->user->setFlash('notice', "User name already used, try else");
                    }
                    else{
                        if($model->save()){
                            Yii::app()->user->setFlash('success', "New Referral Added.");
                            $this->refresh();
                        }
                        else{
                            Yii::app()->user->setFlash('notice', 'Error saving record');
                        }
                    }
                }
                
		$this->render('add',array('model' => $model));
	}

	public function actionDelete($id)
	{
                if(Yii::app()->request->isPostRequest)
                {
                        $user = User::model()->findByPk($id);
                        if(isset($user)){
                            try{
                                if($user->delete()){
                                    echo 'Referral Deleted';
                                }else{
                                    echo 'Error while Deleting';
                                }
                            }
                            catch(Exception $ex){
                                echo 'Can not delete this Referral since it is used for Entry Records';
                            }
                                
                        }
                }else{
                        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
                }
	}

	public function actionIndex()
	{
            $dataProvider=new CActiveDataProvider('User', array('criteria'=>array('condition'=> 'user_type = 1', 'order'=>'id DESC')));
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
            ));            
	}

	public function actionUpdate($id)
	{
                $model = User::model()->findByPk($id);
                
                if (isset($_POST['User'])) {
                    $model->attributes = $_POST['User'];
                    
                    if($model->save()){
                        Yii::app()->user->setFlash('success', "Referral Updated.");
                        $this->redirect(Yii::app()->baseUrl . '/admin/user');
                    }
                    else{
                        Yii::app()->user->setFlash('notice', 'Error saving record');
                    }
                }
                
		$this->render('update',array('model' => $model));
	}
}