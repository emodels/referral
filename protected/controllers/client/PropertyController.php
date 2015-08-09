<?php

class PropertyController extends Controller
{
    public  $header_title = null;
    public  $header_logo = null;
    public  $logo_width = null;
    public  $logo_height = null;

    public function init(){

        if (Yii::app()->user->isGuest){

            $this->redirect(Yii::app()->createUrl('site/login'));

        } else {

            if (Yii::app()->user->user_type == '2') {

                $this->redirect(Yii::app()->baseUrl . '/mission');
            }

            $user = User::model()->findByPk(Yii::app()->user->id);

            if (isset($user) && $user->user_type == 1) {

                $this->header_title = ($user->header_title != null ? $user->header_title : null);
                $this->header_logo = ($user->logo != null ? $user->logo : null);
                $this->logo_width = ($user->logo_width != null ? $user->logo_width : null);
                $this->logo_height = ($user->logo_height != null ? $user->logo_height : null);
            }
        }
    }

    public function actionAdd($id){

        $model = new Property();

        $model->entry = $id;
        $model->management_fee_percentage = 4.5;

        if (isset($_POST['Property'])) {

            $model->attributes = $_POST['Property'];

            $model->first_created_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
            $model->last_update_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());

            if ($model->save(false)) {

                /*----( If this is First Property then Email Client Login details )---------*/
                if (Property::model()->count('entry = ' . $id) == 1) {

                    $user = User::model()->find('entry = ' . $id);

                    $message = $this->renderPartial('//email/template/client_portal_enabled', array('user'=>$user), true);

                    if (isset($message) && $message != "") {

                        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                        $mailer->Host = Yii::app()->params['SMTP_Host'];
                        $mailer->IsSMTP();
                        $mailer->SMTPAuth = true;
                        $mailer->Username = Yii::app()->params['SMTP_Username'];
                        $mailer->Password = Yii::app()->params['SMTP_password'];
                        $mailer->From = Yii::app()->params['SMTP_Username'];
                        $mailer->AddReplyTo(Yii::app()->params['SMTP_Username']);
                        $mailer->AddAddress($model->entry0->email);
                        $mailer->AddCC(Yii::app()->params['adminEmail']);
                        $mailer->FromName = 'Dwellings Group';
                        $mailer->CharSet = 'UTF-8';
                        $mailer->Subject = 'Dwellings Group Referral Management System - Client portal enabled';
                        $mailer->IsHTML();
                        $mailer->Body = $message;

                        try{

                            $mailer->Send();
                        }
                        catch (Exception $ex){

                            echo $ex->getMessage();
                        }
                    }
                }

                Yii::app()->user->setFlash('success', "Client Property information saved");
                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }

        $this->render('/client/add_property',array('model' => $model));
    }

    public function actionUpdate($id){

        $model = Property::model()->findByPk($id);

        if (isset($_POST['btnUpdate'])) {

            $model->attributes = $_POST['Property'];
            $model->last_update_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());

            if ($model->save(false)) {

                Yii::app()->user->setFlash('success', "Client Property information saved");
                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }

        if (isset($_POST['btnDelete'])) {

            if ($model->delete()) {

                Yii::app()->user->setFlash('success', "Client Property information Deleted");
                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }

        $this->render('/client/update_property',array('model' => $model));
    }

    public function actionUpdateFieldValue(){

        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest) {

            if (isset($_POST['id']) && isset($_POST['field']) && isset($_POST['value'])) {

                $property = Property::model()->findByPk($_POST['id']);

                if (isset($property)) {

                    $property->{$_POST['field']} = $_POST['value'];

                    if ($property->save()) {

                        echo 'done';
                    }
                }
            }
        } else {

            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }
}