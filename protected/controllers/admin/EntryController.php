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
            if (isset($_POST['Entry'])) {
                
                if ($_POST['Entry']['referrel_user'] != '' && $_POST['Entry']['status'] == ''){
                    $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . $_POST['Entry']['referrel_user'], 'order'=>'id DESC')));
                }
                else if ($_POST['Entry']['referrel_user'] != '' && $_POST['Entry']['status'] != '') {
                    $dataProvider=new CActiveDataProvider('Entry', array('criteria'=>array('condition'=> 'referrel_user = ' . $_POST['Entry']['referrel_user'] . ' AND status = ' . $_POST['Entry']['status'], 'order'=>'id DESC')));
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
                        $this->redirect(array('admin/user'));
                    }
                }
            }
            
            $this->render('update', array('model'=>$model,'status'=>$status));
	}
        
        public function actionDelete($id){
            if(Yii::app()->request->isPostRequest)
            {
                $entry = Entry::model()->findByPk($id);
                if(isset($entry)){
                    if($entry->delete()){
                            echo 'Deleted';
                    }else{
                            echo 'Error while Deleting';
                    }
                }
            }else{
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            }
        }
}