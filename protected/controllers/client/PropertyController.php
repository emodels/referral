<?php

class PropertyController extends Controller
{
    public function init(){
        if (Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
        else{
            if (Yii::app()->user->user_type == '2') {
                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }
    }

    public function actionAdd($id){

        $model = new Property();

        $model->entry = $id;

        if (isset($_POST['Property'])) {

            $model->attributes = $_POST['Property'];

            $model->first_created_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
            $model->last_update_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());

            if ($model->save(false)) {

                Yii::app()->user->setFlash('success', "Client Property information saved");
                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }

        $this->render('/client/add_property',array('model' => $model));
    }

    public function actionUpdate($id){

        $model = Property::model()->findByPk($id);

        if (isset($_POST['btnUpdate'])) {

            $model->attributes = $_POST['Property'];
            $model->last_update_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());

            if ($model->save(false)) {

                Yii::app()->user->setFlash('success', "Client Property information saved");
                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }

        if (isset($_POST['btnDelete'])) {

            if ($model->delete()) {

                Yii::app()->user->setFlash('success', "Client Property information Deleted");
                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }

        $this->render('/client/update_property',array('model' => $model));
    }

    public function actionUpdateFieldValue(){

        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest) {

            if (isset($_POST['id']) && isset($_POST['field']) && isset($_POST['value'])) {

                $property = Property::model()->findByPk($_POST['id']);

                if (isset($property)) {

                    $property->{$_POST['field']} = $_POST['value'];

                    if ($property->save()) {

                        echo 'done';
                    }
                }
            }
        } else {

            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }
}