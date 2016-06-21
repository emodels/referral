<?php

/**
 * This is the model class for table "mail_log".
 *
 * The followings are the available columns in table 'mail_log':
 * @property integer $id
 * @property string $from_email
 * @property string $from_name
 * @property string $to_email
 * @property string $to_name
 * @property string $subject
 * @property string $message
 * @property string $entry_date
 * @property integer $entry
 * @property integer $type
 */
class MailLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MailLog the static model class
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
		return 'mail_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_email, from_name, to_email, to_name, subject, message, entry_date, entry, type', 'required'),
			array('entry, type', 'numerical', 'integerOnly'=>true),
			array('from_email, from_name, to_email, to_name', 'length', 'max'=>100),
			array('subject', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from_email, from_name, to_email, to_name, subject, message, entry_date, entry, type', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from_email' => 'From Email',
			'from_name' => 'From Name',
			'to_email' => 'To Email',
			'to_name' => 'To Name',
			'subject' => 'Subject',
			'message' => 'Message',
			'entry_date' => 'Entry Date',
			'entry' => 'Entry',
			'type' => 'Type',
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
		$criteria->compare('from_email',$this->from_email,true);
		$criteria->compare('from_name',$this->from_name,true);
		$criteria->compare('to_email',$this->to_email,true);
		$criteria->compare('to_name',$this->to_name,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('entry_date',$this->entry_date,true);
		$criteria->compare('entry',$this->entry);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}