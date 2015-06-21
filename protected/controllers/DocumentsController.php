<?php
class DocumentsController extends Controller
{
    public function init(){
        if (Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
    }

    public function actionIndex($id) {

        $property = Property::model()->findByPk($id);

        $model = new PropertyDocument();

        if (isset($property)) {

            if (Yii::app()->user->user_type == '2') {

                $this->menu = array('label'=>'Back to Home', 'url'=>Yii::app()->request->baseUrl . '/client/mission', 'visible'=>!Yii::app()->user->isGuest);

            } else {

                $this->menu = array('label'=>'Back to View Referrals', 'url'=>'javascript:window.history.back();', 'visible'=>!Yii::app()->user->isGuest);
            }

            if (isset($_POST['PropertyDocument'])) {

                $model->attributes = $_POST['PropertyDocument'];

                $model->property = $id;
                $model->entry_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());

                if ($model->save()) {

                    Yii::app()->user->setFlash('success', 'Document Added');
                    $this->refresh();
                }
            }

            $this->render('/documents/index', array('property' => $property, 'model' => $model));
        }
    }

    public function actionDelete($id) {

        PropertyDocument::model()->deleteByPk($id);
    }
}