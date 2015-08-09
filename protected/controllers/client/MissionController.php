<?php
class MissionController extends Controller
{
    public  $header_title = null;
    public  $header_logo = null;
    public  $logo_width = null;
    public  $logo_height = null;

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

        if (isset($entry)) {

            $user = $entry->referrelUser;
        }

        if (isset($user)) {

            $this->header_title = ($user->header_title != null ? $user->header_title : null);
            $this->header_logo = ($user->logo != null ? $user->logo : null);
            $this->logo_width = ($user->logo_width != null ? $user->logo_width : null);
            $this->logo_height = ($user->logo_height != null ? $user->logo_height : null);
        }
    }

    public function actionIndex(){

        $dataProvider = new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'id = ' . Yii::app()->user->entry), 'pagination' => false));

        $this->render('/client/mission',array('dataProvider' => $dataProvider, 'grid_title' => 'Click on Documents icon <img src="../images/document.png" alt="Documents" style="vertical-align: middle"> for more information'));
    }
}