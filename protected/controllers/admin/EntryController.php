<?php

class EntryController extends Controller
{
	public function actionAdd()
	{
            $model = new Entry();

            $model->entry_added_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
            $model->entry_last_updated_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
            $model->referral_commission_amount = 0;
            
            if (isset($_POST['Entry'])) {
                $model->attributes = $_POST['Entry'];
                
                if($model->validate()){
                    if ($model->save()) {
                        Yii::app()->user->setFlash('success','Entry Record Added');
                        $this->redirect(array('admin/user'));
                    }
                }
            }
            
            $this->render('add', array('model'=>$model));
	}

        public function actionListStatus(){
            $data = Status::model()->findAll('referral_user=:id',array(':id'=>$_POST['Entry']['referrel_user']));
            $data=CHtml::listData($data,'id','status');

            echo CHtml::tag('option',array('value'=>''),'Select Status',true);
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
            }
        }
        
	public function actionIndex()
	{
            $this->render('index');
	}

	public function actionUpdate()
	{
            $this->render('update');
	}
}