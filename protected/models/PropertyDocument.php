<?php

/**
 * This is the model class for table "property_document".
 *
 * The followings are the available columns in table 'property_document':
 * @property integer $id
 * @property integer $property
 * @property integer $category
 * @property string $caption
 * @property string $document
 * @property string $entry_date
 *
 * The followings are the available model relations:
 * @property Property $property0
 * @property DocumentCategory $category0
 */
class PropertyDocument extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PropertyDocument the static model class
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
		return 'property_document';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('property, category, caption, document, entry_date', 'required'),
			array('property, category', 'numerical', 'integerOnly'=>true),
			array('caption', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, property, category, caption, document, entry_date', 'safe', 'on'=>'search'),
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
			'property0' => array(self::BELONGS_TO, 'Property', 'property'),
			'category0' => array(self::BELONGS_TO, 'DocumentCategory', 'category'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'property' => 'Property',
			'category' => 'Category',
			'caption' => 'Caption',
			'document' => 'Document',
			'entry_date' => 'Entry Date',
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
		$criteria->compare('property',$this->property);
		$criteria->compare('category',$this->category);
		$criteria->compare('caption',$this->caption,true);
		$criteria->compare('document',$this->document,true);
		$criteria->compare('entry_date',$this->entry_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}