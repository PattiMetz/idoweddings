<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property integer $organization_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $skype
 * @property integer $type
 * @property integer $status
 * @property string $notes
 *
 * @property Organization $organization
 * @property ContactPhone[] $contactPhones
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id'], 'required'],
            [['email'], 'email'],
            [['organization_id', 'type', 'status'], 'integer'],
            [['first_name', 'last_name', 'email', 'skype', 'notes'], 'string', 'max' => 255],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'skype' => 'Skype',
            'type' => 'Type',
            'status' => 'Status',
            'notes' => 'Notes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactPhones()
    {
        return $this->hasMany(ContactPhone::className(), ['contact_id' => 'id']);
    }
}