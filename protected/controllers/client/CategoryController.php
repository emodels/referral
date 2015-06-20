<?php
class CategoryController extends Controller
{
    public function init(){
        if (Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
        else{
            if (Yii::app()->user->user_type == '2') {
                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }
    }

    public function actionIndex($id){

        $model = Entry::model()->findByPk($id);

        if (isset($_POST['btnSave'])) {

            EntryDocumentCategory::model()->deleteAll('entry = ' . $id);

            if (isset($_POST['entry_category_list'])) {

                foreach($_POST['entry_category_list'] as $category) {

                    $entryCategory = new EntryDocumentCategory();

                    $entryCategory->entry = $id;
                    $entryCategory->category = $category;

                    $entryCategory->save();
                }
            }

            Yii::app()->user->setFlash('success', "Client Category information saved");
            $this->redirect(Yii::app()->baseUrl . (Yii::app()->user->user_type == 0 ? '/admin/entry' : '/referral/main'));
        }

        $this->render('/client/category', array('model' => $model));
    }
}