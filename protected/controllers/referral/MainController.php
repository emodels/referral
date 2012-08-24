<?php

class MainController extends Controller
{
	public function actionIndex()
	{
            if (isset($_POST['Entry'])) {
                
                if ($_POST['Entry']['status'] == ''){
                    $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->user->id, 'order'=>'id DESC')));
                }
                else if ($_POST['Entry']['status'] != '') {
                    $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . Yii::app()->user->id . ' AND status = ' . $_POST['Entry']['status'], 'order'=>'id DESC')));
                }
                
                if (isset($dataProvider)) {
                    $this->renderPartial('_entry_gridview', array('dataProvider'=>$dataProvider),false,true);
                }
                Yii::app()->end();
            }
            
            $this->render('index');
	}
        
	public function actionUpdate($id)
	{
            $model = Entry::model()->findByPk($id);
            $status = CHtml::listData(Status::model()->findAll('referral_user=:referral_user', array(':referral_user' => $model->referrel_user)), 'id', 'status');
            
            if (isset($_POST['Entry'])) {
                $model->attributes = $_POST['Entry'];
                $model->entry_last_updated_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
                
                if($model->validate()){
                    if ($model->save()) {
                        Yii::app()->user->setFlash('success','Entry Record Updated');
                        $this->redirect(array('referral/main'));
                    }
                }
            }
            
            $this->render('update', array('model'=>$model,'status'=>$status));
	}
}