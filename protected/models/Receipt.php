<?php

/**
 * This is the model class for table "receipt".
 *
 * The followings are the available columns in table 'receipt':
 * @property integer $id
 * @property integer $receipt_number
 * @property string $company_logo
 * @property string $company_name
 * @property string $company_address
 * @property string $partner_name
 * @property string $partner_telephone
 * @property string $partner_email
 * @property string $landlord_name
 * @property integer $property_id
 * @property string $property_address
 * @property string $tenant_name
 * @property double $rent
 * @property double $paid
 * @property string $from_date
 * @property string $to_date
 * @property double $management_fees
 * @property double $gst
 * @property string $receipt_date
 * @property string $signature
 * @property integer $status
 * @property string $pdf
 *
 * The followings are the available model relations:
 * @property Property $property
 */
class Receipt extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Receipt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'receipt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('receipt_number, company_logo, company_name, company_address, partner_name, partner_telephone, partner_email, landlord_name, property_id, property_address, tenant_name, rent, paid, from_date, to_date, management_fees, gst, receipt_date, signature, status', 'required'),
			array('receipt_number, property_id, status', 'numerical', 'integerOnly'=>true),
			array('rent, paid, management_fees, gst', 'numerical'),
			array('company_name, partner_name, landlord_name, tenant_name', 'length', 'max'=>100),
			array('company_address, property_address', 'length', 'max'=>500),
			array('partner_telephone, partner_email', 'length', 'max'=>50),
			array('pdf', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, receipt_number, company_logo, company_name, company_address, partner_name, partner_telephone, partner_email, landlord_name, property_id, property_address, tenant_name, rent, paid, from_date, to_date, management_fees, gst, receipt_date, signature, status, pdf', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'property' => array(self::BELONGS_TO, 'Property', 'property_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'receipt_number' => 'Receipt Number',
			'company_logo' => 'Company Logo',
			'company_name' => 'Company Name',
			'company_address' => 'Company Address',
			'partner_name' => 'Partner Name',
			'partner_telephone' => 'Partner Telephone',
			'partner_email' => 'Partner Email',
			'landlord_name' => 'Landlord Name',
			'property_id' => 'Property',
			'property_address' => 'Property Address',
			'tenant_name' => 'Tenant Name',
			'rent' => 'Rent',
			'paid' => 'Paid',
			'from_date' => 'From Date',
			'to_date' => 'To Date',
			'management_fees' => 'Management Fees',
			'gst' => 'Gst',
			'receipt_date' => 'Receipt Date',
			'signature' => 'Signature',
			'status' => 'Status',
			'pdf' => 'Pdf',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('receipt_number',$this->receipt_number);
		$criteria->compare('company_logo',$this->company_logo,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('company_address',$this->company_address,true);
		$criteria->compare('partner_name',$this->partner_name,true);
		$criteria->compare('partner_telephone',$this->partner_telephone,true);
		$criteria->compare('partner_email',$this->partner_email,true);
		$criteria->compare('landlord_name',$this->landlord_name,true);
		$criteria->compare('property_id',$this->property_id);
		$criteria->compare('property_address',$this->property_address,true);
		$criteria->compare('tenant_name',$this->tenant_name,true);
		$criteria->compare('rent',$this->rent);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('from_date',$this->from_date,true);
		$criteria->compare('to_date',$this->to_date,true);
		$criteria->compare('management_fees',$this->management_fees);
		$criteria->compare('gst',$this->gst);
		$criteria->compare('receipt_date',$this->receipt_date,true);
		$criteria->compare('signature',$this->signature,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('pdf',$this->pdf,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}