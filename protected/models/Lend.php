<?php

/**
 * Created by PhpStorm.
 * User: dhiraj
 * Date: 21/7/16
 * Time: 7:13 PM
 *
 * This is the model for lending_details
 *
 * The following are the available columns:
 * @property integer id
 * @property integer user_id
 * @property integer book_id
 * @property datetime taken_at
 */
class Lend extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lending_details';
    }

    public function relations()
    {
        return array(
            'book' => array(self::HAS_ONE, 'Book', 'book_id'),
            //'user' => array(self::HAS_ONE, 'User', 'user_id'),
        );
    }

    /**
     * @param $user_id
     * @return array|mixed|null
     */
    public function howManyBooksBorrowedByUser($user_id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'id';
        $criteria->addCondition('user_id = '.$user_id);

        $data = $this->findAll($criteria);
        //print_r($data); exit;
        return count($data);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Lend the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}