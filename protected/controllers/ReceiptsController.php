<?php
class ReceiptsController extends Controller
{
    public function init(){

        if (Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->createUrl('site/login'));
        }

        if (Yii::app()->user->user_type == '2') {

            $this->menu = array('label'=>'Back to Home', 'url'=>Yii::app()->request->baseUrl . '/client/mission', 'visible'=>!Yii::app()->user->isGuest);

        } else {

            $this->menu = array('label'=>'Back to View Referrals', 'url'=>Yii::app()->request->baseUrl . '/entry', 'visible'=>!Yii::app()->user->isGuest);
        }
    }

    public function actionIndex($id) {

        $property = Property::model()->findByPk($id);

        if (isset($property)) {

            $this->render('/receipts/index', array('property' => $property));
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

                if ($receipt->save()) {

                    /*----( Publish to Categories )-----*/
                    if (isset($_POST['category_list'])) {

                        foreach($_POST['category_list'] as $category) {

                            $document = new PropertyDocument();

                            $document->property = $prop_id;
                            $document->category = $category;
                            $document->caption = 'Receipt - ' . $receipt->receipt_number;
                            $document->document = 'http://www';
                            $document->entry_date = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());

                            $document->save();
                        }
                    }
                    /*----( // End of Publish to Categories )-----*/

                    $receipt->status = 1;
                    $receipt->save();

                    Yii::app()->user->setFlash('success','Receipt information Saved');

                    $this->redirect(Yii::app()->baseUrl . '/receipts/index/id/' . $prop_id);
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
}