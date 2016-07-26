<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "main_company_address".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $address
 * @property string $city
 * @property string $zip
 * @property string $state
 * @property integer $country_id
 * @property integer $time_zone
 * @property string $email
 * @property string $website
 *
 * @property MainCompany $company
 */
class MainCompanyAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_company_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'country_id', 'time_zone'], 'integer'],
            [['email'], 'email'],
            [['address', 'city', 'state', 'email', 'website'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 20],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCompany::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'address' => 'Address',
            'city' => 'City',
            'zip' => 'Zip',
            'state' => 'State',
            'country_id' => 'Country ID',
            'time_zone' => 'Time Zone',
            'email' => 'Email',
            'website' => 'Website',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(MainCompany::className(), ['id' => 'company_id']);
    }
}
