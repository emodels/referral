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

                $this->menu = array('label'=>'Back to View Referrals', 'url'=>Yii::app()->request->baseUrl . '/entry', 'visible'=>!Yii::app()->user->isGuest);
            }

            if (isset($_POST['PropertyDocument'])) {

                $model->attributes = $_POST['PropertyDocument'];

                $model->property = $id;
                $model->entry_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());

                if ($model->save()) {

                    //--------Send Email notification to Client ---------------
                    $message = $this->renderPartial('//email/template/notify_document_added', array('document'=>$model), true);

                    if (isset($message) && $message != "") {

                        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                        $mailer->Host = Yii::app()->params['SMTP_Host'];
                        $mailer->IsSMTP();
                        $mailer->SMTPAuth = true;
                        $mailer->Username = Yii::app()->params['SMTP_Username'];
                        $mailer->Password = Yii::app()->params['SMTP_password'];
                        $mailer->From = Yii::app()->params['SMTP_Username'];
                        $mailer->AddReplyTo(Yii::app()->params['SMTP_Username']);
                        $mailer->AddAddress($model->property0->entry0->email);
                        $mailer->AddCC(Yii::app()->params['adminEmail']);
                        $mailer->FromName = 'Dwellings Group';
                        $mailer->CharSet = 'UTF-8';
                        $mailer->Subject = 'Dwellings Group Referral Management System - New Document Added';
                        $mailer->IsHTML();
                        $mailer->Body = $message;

                        try{

                            $mailer->Send();
                        }
                        catch (Exception $ex){

                            echo $ex->getMessage();
                        }
                    }
                    //----------------------------------------------------------

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