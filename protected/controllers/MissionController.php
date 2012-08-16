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
                        $this->redirect('admin/user');
                        break;
                    case '1':
                        $this->redirect('referral/main');
                        break;
                }
                
            }
	}
}