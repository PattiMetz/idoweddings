<?php

namespace app\models\vendor;

use Yii;

/**
 * This is the model class for table "vendor_destination".
 *
 * @property integer $id
 * @property integer $vendor_id
 * @property string $region
 * @property string $destination
 * @property string $location
 *
 * @property Vendor $vendor
 */
class VendorDestination extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vendor_destination';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor_id'], 'required'],
            [['vendor_id'], 'integer'],
            [['region', 'destination', 'location'], 'string', 'max' => 255],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_id' => 'organization_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendor_id' => 'Vendor ID',
            'region' => 'Region',
            'destination' => 'Destination',
            'location' => 'Location',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['organization_id' => 'vendor_id']);
    }
}
