<?php

class CategoryController extends Controller
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
                $model = new DocumentCategory();
               
                if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                    echo CActiveForm::validate( array( $model)); 
                    Yii::app()->end(); 
                }
                
                if (isset($_POST['DocumentCategory'])) {

                    $model->attributes = $_POST['DocumentCategory'];

                    if (DocumentCategory::model()->findByAttributes(array('name'=>$model->name))) {

                        $model->addError('name', 'Name already used, try else');
                        Yii::app()->user->setFlash('notice', "Name already used, try else");

                    } else{

                        if($model->save()){
                            Yii::app()->user->setFlash('success', "New Category Added.");
                            $this->redirect(Yii::app()->baseUrl . '/admin/category');
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
                        $category = DocumentCategory::model()->findByPk($id);

                        if(isset($category)){

                            try{
                                if($category->delete()){

                                    echo 'Category Deleted';

                                }else{

                                    echo 'Error while Deleting';
                                }

                            } catch(Exception $ex){

                                echo 'Can not delete this Category since it is used for Referral Records';
                            }
                                
                        }
                }else{

                    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
                }
	}

	public function actionIndex()
	{
        $model = new DocumentCategory('search');
        $model->unsetAttributes();

        if(isset($_GET['DocumentCategory'])){
            $model->attributes=$_GET['DocumentCategory'];
        }

        $this->render('index',array(
            'dataProvider'=>$model,
        ));
    }

	public function actionUpdate($id)
	{
        $model = DocumentCategory::model()->findByPk($id);

        if (isset($_POST['DocumentCategory'])) {

            $model->attributes = $_POST['DocumentCategory'];

            if($model->save()){

                Yii::app()->user->setFlash('success', "Category Updated.");
                $this->redirect(Yii::app()->baseUrl . '/admin/category');
            }
            else{

                Yii::app()->user->setFlash('notice', 'Error saving record');
            }
        }
                
		$this->render('update',array('model' => $model));
	}
}