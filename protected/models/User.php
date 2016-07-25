<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $salutation
 * @property string $title
 * @property string $firstname
 * @property string $lastname
 * @property string $street
 * @property string $streetnumber
 * @property string $zip
 * @property string $city
 * @property string $description
 * @property string $register_date
 */
class User extends CActiveRecord
{
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
            array('salutation, firstname, lastname, city, zip, street, streetnumber', 'required'),
			array('salutation, title, firstname, lastname, street, city', 'length', 'max'=>30),
			array('streetnumber, zip', 'length', 'max'=>20),
			array('description, register_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, salutation, title, firstname, lastname, street, streetnumber, zip, city, description, register_date', 'safe', 'on'=>'search'),
            array('photo', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'update'),
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
		    'borrowed' => array(self::HAS_MANY, 'Lend', 'user_id'),
		    'books' => array(self::HAS_MANY, 'Book', 'book_id', 'through' => 'borrowed'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'salutation' => 'Salutation',
			'title' => 'Title',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'street' => 'Street',
			'streetnumber' => 'Streetnumber',
			'zip' => 'Zip',
			'city' => 'City',
			'description' => 'Description',
			'register_date' => 'Register Date',
            'photo' => 'Photo'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('salutation',$this->salutation,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('streetnumber',$this->streetnumber,true);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('register_date',$this->register_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
