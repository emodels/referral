<?php
class CategoryController extends Controller
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
            if (Yii::app()->user->user_type == '2') {
                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        if (isset($user) && $user->user_type == 1) {

            $this->header_title = ($user->header_title != null ? $user->header_title : null);
            $this->header_logo = ($user->logo != null ? $user->logo : null);
            $this->logo_width = ($user->logo_width != null ? $user->logo_width : null);
            $this->logo_height = ($user->logo_height != null ? $user->logo_height : null);
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
            $this->redirect(Yii::app()->baseUrl . '/mission');
        }

        $this->render('/client/category', array('model' => $model));
    }
}