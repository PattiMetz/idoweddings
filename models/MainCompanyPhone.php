<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "main_company_phone".
 *
 * @property integer $id
 * @property integer $contact_id
 * @property string $type
 * @property string $phone
 *
 * @property MainCompanyContact $contact
 */
class MainCompanyPhone extends \yii\db\ActiveRecord
{
    public $phone_types = [
        'mobile' => 'Mobile',
        'fax' => 'Fax'
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_company_phone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contact_id'], 'integer'],
            [['type'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 255],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCompanyContact::className(), 'targetAttribute' => ['contact_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contact_id' => 'Contact ID',
            'type' => 'Type',
            'phone' => 'Phone',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(MainCompanyContact::className(), ['id' => 'contact_id']);
    }
}
