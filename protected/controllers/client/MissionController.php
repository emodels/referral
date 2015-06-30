<?php
class MissionController extends Controller
{
    public  $header_title = null;
    public  $header_logo = null;

    public function init(){

        if (Yii::app()->user->isGuest){

            $this->redirect(Yii::app()->createUrl('site/login'));
        }
        else{

            if (Yii::app()->user->user_type !== '2') {

                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }

        $entry = Entry::model()->findByPk(Yii::app()->user->entry);

        if (isset($entry) && $entry->property_holder == 'Rental_Client') {

            $this->header_title = ($entry->header_title != null ? $entry->header_title : 'Dwellings State Agents');
            $this->header_logo = ($entry->logo != null ? $entry->logo : null);
        }
    }

    public function actionIndex(){

        $dataProvider = new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'id = ' . Yii::app()->user->entry), 'pagination' => false));

        $this->render('/client/mission',array('dataProvider' => $dataProvider, 'grid_title' => 'Click on Documents icon for more information'));
    }
}