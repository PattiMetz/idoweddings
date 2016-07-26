<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "main_company_contact".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $email
 * @property string $skype
 *
 * @property MainCompany $company
 * @property MainCompanyPhone[] $mainCompanyPhones
 */
class MainCompanyContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_company_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [['email'], 'email'],
            [['name', 'email', 'skype'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'email' => 'Email',
            'skype' => 'Skype',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(MainCompany::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainCompanyPhones()
    {
        return $this->hasMany(MainCompanyPhone::className(), ['contact_id' => 'id']);
    }
}
