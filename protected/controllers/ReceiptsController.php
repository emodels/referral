<?php
class ReceiptsController extends Controller
{
    public function init(){

        $isDownload = false;

        if (Yii::app()->user->isGuest){

            if (strpos(Yii::app()->request->pathInfo, 'download') !== false) {

                $isDownload = true;

            } else {

                $this->redirect(Yii::app()->createUrl('site/login'));
            }
        }

        if ($isDownload == false) {

            if (Yii::app()->user->user_type == '2') {

                $this->menu = array('label' => 'Back to Home', 'url' => Yii::app()->request->baseUrl . '/client/mission', 'visible' => !Yii::app()->user->isGuest);

            } else {

                $this->menu = array('label' => 'Back to View Referrals', 'url' => Yii::app()->request->baseUrl . '/entry', 'visible' => !Yii::app()->user->isGuest);
            }
        }
    }

    public function actionIndex($id) {

        $date_range = array();

        $date_range['start_date'] = null;
        $date_range['end_date'] = null;

        $property = Property::model()->findByPk($id);

        if (isset($property)) {

            if (isset($_POST['start_date']) && isset($_POST['end_date'])) {

                $dataProvider = new CActiveDataProvider('Receipt', array('criteria'=>array('condition'=> "property_id = " . $property->id . " AND from_date BETWEEN '" . $_POST['start_date'] . "' AND '" . $_POST['end_date'] . "'", 'order'=>'id DESC'), 'pagination' => false));

                $date_range['start_date'] = $_POST['start_date'];
                $date_range['end_date'] = $_POST['end_date'];

                if (isset($_POST['btn_pdf'])) {

                    $html_content = $this->renderPartial('/receipts/summary_view', array('property' => $property, 'dataProvider' => $dataProvider, 'date_range' => $date_range), true);

                    $url = 'http://freehtmltopdf.com';
                    $data = array('convert' => '',
                        'html' => $html_content,
                        'orientation' => 'landscape',
                        'baseurl' => Yii::app()->request->baseUrl);

                    $options = array(
                        'http' => array(
                            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                            'method'  => 'POST',
                            'content' => http_build_query($data),
                        ),
                    );

                    $context  = stream_context_create($options);
                    $pdf_result = file_get_contents($url, false, $context);

                    header('Content-type: application/pdf');
                    header('Content-Disposition: attachment; filename="Receipt_Summary.pdf"');
                    var_dump($pdf_result);
                }

            } else {

                $dataProvider = new CActiveDataProvider('Receipt', array('criteria'=>array('condition'=> 'property_id = ' . $property->id, 'order'=>'id DESC'), 'pagination' => false));
            }

            $this->render('/receipts/index', array('property' => $property, 'dataProvider' => $dataProvider, 'date_range' => $date_range));
        }
    }

    public function actionAdd($prop_id, $receipt_id = null) {

        $property = Property::model()->findByPk($prop_id);

        if (isset($property)) {

            $default_logo_contents = file_get_contents(Yii::getPathOfAlias('webroot.images') . '/dwg_state_agents.jpg');
            $default_signature_contents = file_get_contents(Yii::getPathOfAlias('webroot.images') . '/dwg_signature.png');

            if ($receipt_id !== null) {

                $receipt = Receipt::model()->findByPk($receipt_id);
            }

            if (!isset($receipt)) {

                $receipt = new Receipt();

                $receipt->property_id = $prop_id;
                $receipt->company_logo = base64_encode($default_logo_contents);
                $receipt->company_name = 'Dwellings Estate Agent PTY LTD';
                $receipt->company_address = 'ACN 605 162 847' . PHP_EOL . 'Suite 9 North, 215 Bell Street,' . PHP_EOL . 'Preston, VIC 3072' . PHP_EOL . 'Tel: 03 9863 6963';
                $receipt->partner_name = ucfirst($property->owner0->first_name) . ' ' . ucfirst($property->owner0->last_name);
                $receipt->partner_telephone = 'Tel: 0487 854 881';
                $receipt->partner_email = $property->owner0->email;
                $receipt->landlord_name = ucfirst($property->entry0->first_name) . ' ' . ucfirst($property->entry0->last_name);
                $receipt->property_address = $property->address;
                $receipt->tenant_name = '';
                $receipt->receipt_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
                $receipt->signature = base64_encode($default_signature_contents);
                $receipt->status = 0;

                $receipt_auto_increment = Yii::app()->params['Receipts_auto_increment'];
                $receipt_count = Receipt::model()->count();

                $receipt->receipt_number = $receipt_count + $receipt_auto_increment;
            }

            if (isset($_POST['Receipt'])) {

                $receipt->attributes = $_POST['Receipt'];

                /*-----( Company Logo )------*/
                $logo = CUploadedFile::getInstance($receipt, 'company_logo');

                if (isset($logo)){

                    $receipt->company_logo = base64_encode(file_get_contents($logo->tempName));

                } else {

                    $receipt->company_logo = base64_encode($default_logo_contents);
                }
                /*-----( // End of Company Logo )------*/

                /*-----( Signature )------*/
                $signature = CUploadedFile::getInstance($receipt, 'signature');

                if (isset($signature)){

                    $receipt->signature = base64_encode(file_get_contents($signature->tempName));

                } else {

                    $receipt->signature = base64_encode($default_signature_contents);
                }
                /*-----( // End of Signature )------*/

                /*----( Save Costs )----------------------*/
                if (isset($_POST['Costs'])) {

                    $costArray = array();

                    foreach ($_POST['Costs']['name'] as $element) {

                        $costArray[] = array('index' => count($costArray), 'name' => $element, 'value' => $_POST['Costs']['value'][count($costArray)]);
                    }

                    $receipt->costs = json_encode($costArray);

                } else {

                    $receipt->costs = '{}';
                }

                if ($receipt->save()) {

                    /*----( Generate PDF )---------------*/
                    $html_content = $this->renderPartial('/receipts/receipt_view', array('model' => $receipt), true);

                    $url = 'http://freehtmltopdf.com';
                    $data = array('convert' => '',
                        'html' => $html_content,
                        'baseurl' => Yii::app()->request->baseUrl);

                    // use key 'http' even if you send the request to https://...
                    $options = array(
                        'http' => array(
                            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                            'method'  => 'POST',
                            'content' => http_build_query($data),
                        ),
                    );

                    $context  = stream_context_create($options);
                    $pdf_result = file_get_contents($url, false, $context);
                    /*----( //End of Generate PDF )------*/

                    /*----( Publish to Categories )-----*/
                    if (isset($_POST['category_list'])) {

                        foreach($_POST['category_list'] as $category) {

                            $document = new PropertyDocument();

                            $document->property = $prop_id;
                            $document->category = $category;
                            $document->caption = 'Receipt - ' . $receipt->receipt_number;
                            $document->document = Yii::app()->request->baseUrl . '/receipts/download/id/' . base64_encode($receipt->id);
                            $document->entry_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());

                            $document->save();

                            /*-----( Send Email to Client )-------------*/
                            $message = $this->renderPartial('//email/template/notify_document_added', array('document'=>$document), true);

                            if (isset($message) && $message != "") {

                                $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                                $mailer->Host = Yii::app()->params['SMTP_Host'];
                                $mailer->IsSMTP();
                                $mailer->SMTPAuth = true;
                                $mailer->Username = Yii::app()->params['SMTP_Username'];
                                $mailer->Password = Yii::app()->params['SMTP_password'];
                                $mailer->From = Yii::app()->params['SMTP_Username'];
                                $mailer->AddReplyTo(Yii::app()->params['SMTP_Username']);
                                $mailer->AddAddress($document->property0->entry0->email);
                                $mailer->AddCC(Yii::app()->params['adminEmail']);
                                $mailer->FromName = 'Dwellings Group';
                                $mailer->CharSet = 'UTF-8';
                                $mailer->Subject = 'Dwellings Group Referral Management System - New Receipt Added';
                                $mailer->IsHTML();
                                $mailer->Body = $message;

                                try{

                                    $mailer->Send();
                                }
                                catch (Exception $ex){

                                    echo $ex->getMessage();
                                }
                            }
                            /*-----( //End of Send Email to Client )----*/
                        }

                        $receipt->status = 1;
                    }
                    /*----( // End of Publish to Categories )-----*/

                    if (isset($pdf_result)) {

                        $receipt->pdf = $pdf_result;
                    }

                    $receipt->save();

                    Yii::app()->user->setFlash('success','Receipt information Saved');

                    $this->redirect(Yii::app()->baseUrl . '/receipts/index/id/' . $prop_id);

                } else {

                    print_r($receipt->getErrors());
                }
            }

            $this->render('/receipts/add_receipt', array('property' => $property, 'model' => $receipt));
        }
    }

    public function actionDelete($id) {

        if (Yii::app()->request->isAjaxRequest) {

            Receipt::model()->deleteByPk($id);
        }
    }

    public function actionView($id) {

        $receipt = Receipt::model()->findByPk($id);

        if (isset($receipt)) {

            echo $this->renderPartial('/receipts/receipt_view', array('model' => $receipt, true));
        }
    }

    public function actionDownload($id) {

        $receipt = Receipt::model()->findByPk(base64_decode($id));

        if (isset($receipt)) {

            header('Content-type: application/pdf');
            header('Content-Disposition: attachment; filename="Receipt_'. $receipt->receipt_number . '.pdf"');
            var_dump($receipt->pdf);
        }
    }
}