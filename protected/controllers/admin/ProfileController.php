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

                $logo_existing = $model->logo;

                if (isset($_POST['User'])) {

                    $model->attributes = $_POST['User'];

                    $logo = CUploadedFile::getInstance($model, 'logo');

                    if (isset($logo)){

                        $tmpfile_contents = file_get_contents($logo->tempName);

                        $logo->saveAs('images/logo.jpg');

                        $model->logo = base64_encode($tmpfile_contents);

                    } else {

                        $model->logo = $logo_existing;
                    }

                    if (isset($model->logo)) {

                        if ($model->logo_width == '') {

                            $model->addError('logo_width', 'Logo Width cannot be blank.');
                        }

                        if ($model->logo_height == '') {

                            $model->addError('logo_height', 'Logo Height cannot be blank.');
                        }
                    }

                    if(!$model->hasErrors() && $model->save()){

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