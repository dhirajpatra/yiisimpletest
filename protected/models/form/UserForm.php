<?php

/**
 * Created by PhpStorm.
 * User: dhiraj
 * Date: 22/7/16
 * Time: 7:51 PM
 */
class UserForm extends CFormModel
{

    public $id;
    public $salutation;
    public $title;
    public $firstname;
    public $lastname;
    public $street;
    public $streetnumber;
    public $zip;
    public $city;
    public $description;
    public $register_date;

    /**
     * Declares the validation rules.
     * title is required
     */
    public function rules()
    {
        return array(

        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'salutaion'=>'Salutation',
            'title'=>'Title',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'street' => 'Street',
            'streetnumber' => 'Street Number',
            'zip' => 'Zip',
            'city' => 'City',
            'description' => 'Description',
            'register_date' => 'Register Date'
        );
    }

}
