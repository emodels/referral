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

    public function actionAdd($id) {

        $property = Property::model()->findByPk($id);

        if (isset($property)) {

            $receipt = new Receipt();

            $receipt->property_id = $id;

            $default_logo_contents = file_get_contents(Yii::getPathOfAlias('webroot.images') . '/dwg_state_agents.jpg');

            $receipt->company_logo = base64_encode($default_logo_contents);
            $receipt->company_name = 'Dwellings Estate Agent PTY LTD';
            $receipt->company_address = 'ACN 605 162 847' . PHP_EOL . 'Suite 9 North, 215 Bell Street,' . PHP_EOL . 'Preston, VIC 3072' . PHP_EOL . 'Tel: 03 9863 6963';
            $receipt->partner_name = ucfirst($property->owner0->first_name) . ' ' . ucfirst($property->owner0->last_name);
            $receipt->partner_telephone = 'Tel: 0487 854 881';
            $receipt->partner_email = $property->owner0->email;
            $receipt->landlord_name = ucfirst($property->entry0->first_name) . ' ' . ucfirst($property->entry0->last_name);
            $receipt->property_address = $property->address;
            $receipt->tenant_name = '';

            $this->render('/receipts/add_receipt', array('property' => $property, 'model' => $receipt));
        }
    }
}