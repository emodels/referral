<?php

class MissionController extends Controller
{
	public function actionIndex()
	{
            if (Yii::app()->user->isGuest){
                $this->redirect('site/login');
            }
            else{
                switch (Yii::app()->user->user_type){
                    case '0':
                        $this->redirect('entry');
                        break;
                    case '1':
                        $this->redirect('entry');
                        break;
                    case '2':
                        $this->redirect('client/mission');
                        break;
                }
                
            }
	}
}