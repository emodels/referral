<?php

/**
 * This is the model class for table "property".
 *
 * The followings are the available columns in table 'property':
 * @property integer $id
 * @property integer $entry
 * @property string $builder
 * @property string $address
 * @property string $status
 * @property integer $owner
 * @property integer $initial_deposit
 * @property integer $contracts_signed
 * @property integer $five_ten_deposit
 * @property integer $firb_approval
 * @property integer $finance_approval
 * @property integer $property_completion
 * @property integer $rented_out
 * @property integer $insurance_in_place
 * @property string $first_created_date
 * @property string $last_update_date
 * @property double $management_fee_percentage
 * @property integer $send_reminder
 * @property string $expected_settlement_date
 * @property integer $tenant
 *
 * The followings are the available model relations:
 * @property Entry $entry0
 * @property User $owner0
 * @property PropertyDocument[] $propertyDocuments
 * @property Receipt[] $receipts
 */
class Property extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Property the static model class
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
		return 'property';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entry, builder, address, status, owner, initial_deposit, contracts_signed, five_ten_deposit, firb_approval, finance_approval, property_completion, rented_out, insurance_in_place, first_created_date, last_update_date, management_fee_percentage, tenant', 'required'),
			array('entry, owner, initial_deposit, contracts_signed, five_ten_deposit, firb_approval, finance_approval, property_completion, rented_out, insurance_in_place, send_reminder, tenant', 'numerical', 'integerOnly'=>true),
			array('management_fee_percentage', 'numerical'),
			array('builder', 'length', 'max'=>200),
			array('address', 'length', 'max'=>500),
			array('status', 'length', 'max'=>50),
			array('expected_settlement_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, entry, builder, address, status, owner, initial_deposit, contracts_signed, five_ten_deposit, firb_approval, finance_approval, property_completion, rented_out, insurance_in_place, first_created_date, last_update_date, management_fee_percentage, send_reminder, expected_settlement_date, tenant', 'safe', 'on'=>'search'),
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
			'entry0' => array(self::BELONGS_TO, 'Entry', 'entry'),
			'owner0' => array(self::BELONGS_TO, 'User', 'owner'),
			'propertyDocuments' => array(self::HAS_MANY, 'PropertyDocument', 'property'),
			'receipts' => array(self::HAS_MANY, 'Receipt', 'property_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'entry' => 'Entry',
			'builder' => 'Builder',
			'address' => 'Address',
			'status' => 'Status',
			'owner' => 'Owner',
			'initial_deposit' => 'Initial Deposit',
			'contracts_signed' => 'Contracts Signed',
			'five_ten_deposit' => 'Five Ten Deposit',
			'firb_approval' => 'Firb Approval',
			'finance_approval' => 'Finance Approval',
			'property_completion' => 'Property Completion',
			'rented_out' => 'Rented Out',
			'insurance_in_place' => 'Insurance In Place',
			'first_created_date' => 'First Created Date',
			'last_update_date' => 'Last Update Date',
			'management_fee_percentage' => 'Management Fee Percentage',
			'send_reminder' => 'Send Reminder',
			'expected_settlement_date' => 'Expected Settlement Date',
			'tenant' => 'Tenant',
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
		$criteria->compare('entry',$this->entry);
		$criteria->compare('builder',$this->builder,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('owner',$this->owner);
		$criteria->compare('initial_deposit',$this->initial_deposit);
		$criteria->compare('contracts_signed',$this->contracts_signed);
		$criteria->compare('five_ten_deposit',$this->five_ten_deposit);
		$criteria->compare('firb_approval',$this->firb_approval);
		$criteria->compare('finance_approval',$this->finance_approval);
		$criteria->compare('property_completion',$this->property_completion);
		$criteria->compare('rented_out',$this->rented_out);
		$criteria->compare('insurance_in_place',$this->insurance_in_place);
		$criteria->compare('first_created_date',$this->first_created_date,true);
		$criteria->compare('last_update_date',$this->last_update_date,true);
		$criteria->compare('management_fee_percentage',$this->management_fee_percentage);
		$criteria->compare('send_reminder',$this->send_reminder);
		$criteria->compare('expected_settlement_date',$this->expected_settlement_date,true);
		$criteria->compare('tenant',$this->tenant);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}