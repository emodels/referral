<?php
class MissionController extends Controller
{
    public function init(){
        if (Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
        else{
            if (Yii::app()->user->user_type !== '2') {
                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }
    }

    public function actionIndex(){

        $dataProvider = new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'id = ' . Yii::app()->user->entry), 'pagination' => false));

        $this->render('/client/mission',array('dataProvider' => $dataProvider, 'grid_title' => 'Click on Documents icon for more information'));
    }
}