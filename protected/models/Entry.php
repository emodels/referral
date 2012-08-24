<?php

/**
 * This is the model class for table "entry".
 *
 * The followings are the available columns in table 'entry':
 * @property integer $id
 * @property integer $referrel_user
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $state
 * @property string $zip
 * @property string $country
 * @property string $telephone
 * @property string $mobile
 * @property string $description
 * @property string $entry_added_date
 * @property string $entry_last_updated_date
 * @property double $referral_commission_amount
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $referrelUser
 * @property Status $status0
 */
class Entry extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Entry the static model class
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
		return 'entry';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('referrel_user, first_name, last_name, address, state, zip, country, telephone, mobile, description, entry_added_date, entry_last_updated_date, referral_commission_amount, status', 'required'),
			array('referrel_user, status', 'numerical', 'integerOnly'=>true),
			array('referral_commission_amount', 'numerical'),
			array('first_name, last_name, state, telephone, mobile', 'length', 'max'=>50),
			array('address', 'length', 'max'=>200),
			array('zip', 'length', 'max'=>10),
			array('country', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, referrel_user, first_name, last_name, address, state, zip, country, telephone, mobile, description, entry_added_date, entry_last_updated_date, referral_commission_amount, status', 'safe', 'on'=>'search'),
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
			'referrelUser' => array(self::BELONGS_TO, 'User', 'referrel_user'),
			'status0' => array(self::BELONGS_TO, 'Status', 'status'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'referrel_user' => 'Referrel User',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'address' => 'Address',
			'state' => 'State',
			'zip' => 'Zip',
			'country' => 'Country',
			'telephone' => 'Telephone',
			'mobile' => 'Mobile',
			'description' => 'Description',
			'entry_added_date' => 'Entry Added Date',
			'entry_last_updated_date' => 'Entry Last Updated Date',
			'referral_commission_amount' => 'Referral Commission Amount',
			'status' => 'Status',
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
		$criteria->compare('referrel_user',$this->referrel_user);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('entry_added_date',$this->entry_added_date,true);
		$criteria->compare('entry_last_updated_date',$this->entry_last_updated_date,true);
		$criteria->compare('referral_commission_amount',$this->referral_commission_amount);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}