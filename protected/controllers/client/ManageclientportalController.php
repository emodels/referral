<?php

class ManageclientportalController extends Controller
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

        $entry = Entry::model()->findByPk($id);
        $model = User::model()->findByAttributes(array('entry' => $id));

        if (!isset($model)) {

            $model = new User();

            $model->first_name = $entry->first_name;
            $model->last_name = $entry->last_name;
            $model->email = empty($entry->email) ? '-' : $entry->email;
            $model->company = $entry->first_name . ' ' . $entry->last_name;
            $model->user_type = 2;
            $model->allow_add_referral = 0;
            $model->entry = $id;
            $model->allow_portal_management = 0;

            $isAddEntryDocumentCategories = true;
        }

        if (isset($_POST['User'])) {

            $model->attributes = $_POST['User'];

            if (empty($model->id) && User::model()->findByAttributes(array('username'=>$model->username))) {

                $model->addError('user_name', 'User name already used, try else');
                Yii::app()->user->setFlash('notice', "User name already used, try else");
            }
            else{

                if($model->save()){

                    $entry->client_portal_status = 1;

                    /*----( Save Entry Document Categories )--------*/
                    if (isset($isAddEntryDocumentCategories)) {

                        $categories = DocumentCategory::model()->findAll();

                        foreach ($categories as $category) {

                            $entryDocumentCategory = new EntryDocumentCategory();

                            $entryDocumentCategory->entry = $entry->id;
                            $entryDocumentCategory->category = $category->id;

                            $entryDocumentCategory->save();
                        }
                    }

                    if ($entry->save()) {

                        Yii::app()->user->setFlash('success', "Client portal information saved");
                        $this->redirect(Yii::app()->baseUrl . '/mission');
                    }

                } else {

                    var_dump($model->getErrors());
                    Yii::app()->user->setFlash('notice', 'Error saving record');
                }
            }
        }

        $this->render('/client/manage_client_portal',array('model' => $model));
    }
}