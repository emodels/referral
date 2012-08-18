<?php

class StatusController extends Controller
{
	public function actionIndex($id)
	{
            $dataProvider=new CActiveDataProvider('Status', array('criteria'=>array('condition'=> 'referral_user = ' . $id, 'order'=>'id DESC')));
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
            ));            
	}
}