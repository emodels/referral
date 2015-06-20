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
                $this->redirect(Yii::app()->baseUrl . (Yii::app()->user->user_type == 0 ? '/admin/entry' : '/referral/main'));
            }
        }

        $this->render('/client/add_property',array('model' => $model));
    }
}