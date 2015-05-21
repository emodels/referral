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

        $model = array();

        $this->render('/client/add_property',array('model' => $model));
    }
}