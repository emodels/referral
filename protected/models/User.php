<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $company
 * @property integer $user_type
 * @property string $username
 * @property string $password
 * @property string $confirm_password
 * @property integer $allow_add_referral
 * @property integer $entry
 * @property integer $allow_portal_management
 * @property string $logo
 * @property integer $logo_width
 * @property integer $logo_height
 * @property string $header_title
 *
 * The followings are the available model relations:
 * @property Entry[] $entries
 * @property Property[] $properties
 * @property Status[] $statuses
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, email, company, user_type, username, password, confirm_password, allow_add_referral, entry, allow_portal_management', 'required'),
			array('user_type, allow_add_referral, entry, allow_portal_management, logo_width, logo_height', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, email, username, password, confirm_password', 'length', 'max'=>50),
			array('company', 'length', 'max'=>100),
			array('logo, header_title', 'safe'),
            array('password', 'compare', 'compareAttribute'=>'confirm_password', 'message'=>'Passwords not similar'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_name, last_name, email, company, user_type, username, password, confirm_password, allow_add_referral, entry, allow_portal_management, logo, logo_width, logo_height, header_title', 'safe', 'on'=>'search'),
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
			'entries' => array(self::HAS_MANY, 'Entry', 'referrel_user'),
			'properties' => array(self::HAS_MANY, 'Property', 'owner'),
			'statuses' => array(self::HAS_MANY, 'Status', 'referral_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'company' => 'Company',
			'user_type' => 'User Type',
			'username' => 'Username',
			'password' => 'Password',
			'confirm_password' => 'Confirm Password',
			'allow_add_referral' => 'Allow Add Referral',
			'entry' => 'Entry',
			'allow_portal_management' => 'Allow Portal Management',
			'logo' => 'Logo',
			'logo_width' => 'Logo Width',
			'logo_height' => 'Logo Height',
			'header_title' => 'Header Title',
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
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('user_type',$this->user_type);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('confirm_password',$this->confirm_password,true);
		$criteria->compare('allow_add_referral',$this->allow_add_referral);
		$criteria->compare('entry',$this->entry);
		$criteria->compare('allow_portal_management',$this->allow_portal_management);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('logo_width',$this->logo_width);
		$criteria->compare('logo_height',$this->logo_height);
		$criteria->compare('header_title',$this->header_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}