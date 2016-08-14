<?php

namespace app\models\vendor;

use app\models\Organization;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "vendor".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property double $tax_rate
 * @property double $tax_service_rate
 * @property integer $comm_prices
 * @property double $comm_rate
 * @property string $comm_note
 * @property string $admin_notes
 * @property string $payment_notes
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property VendorDestination[] $vendorDestinations
 * @property VendorDoc[] $vendorDocs
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['tax_rate', 'tax_service_rate', 'comm_rate'], 'number'],
            [['comm_prices', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'slug', 'comm_note', 'admin_notes', 'payment_notes'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Vendor Name',
            'slug' => 'Slug',
            'tax_rate' => 'Tax Rate',
            'tax_service_rate' => 'Service Rate',
            'comm_prices' => 'Comm Prices',
            'comm_rate' => 'Commission Rate',
            'comm_note' => 'Note',
            'admin_notes' => 'Admin Notes',
            'payment_notes' => 'Payment Notes',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorDestinations()
    {
        return $this->hasMany(VendorDestination::className(), ['vendor_id' => 'organization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorDocs()
    {
        return $this->hasMany(VendorDoc::className(), ['vendor_id' => 'organization_id']);
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
    public function getVendorHasTypes()
    {
        return $this->hasMany(VendorHasType::className(), ['vendor_id' => 'organization_id']);
    }
}
