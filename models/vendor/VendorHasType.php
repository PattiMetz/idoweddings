<?php

namespace app\models\vendor;

use Yii;

/**
 * This is the model class for table "vendor_has_type".
 *
 * @property integer $vendor_id
 * @property integer $type_id
 *
 * @property VendorType $type
 * @property Vendor $vendor
 */
class VendorHasType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vendor_has_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor_id', 'type_id'], 'required'],
            [['vendor_id', 'type_id'], 'integer'],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VendorType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_id' => 'organization_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vendor_id' => 'Vendor ID',
            'type_id' => 'Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(VendorType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['organization_id' => 'vendor_id']);
    }

    /**
     * @param $vendorId
     * @param $types
     */
    public static function updateTypes($vendorId, $types){
        $countDeleted = VendorHasType::deleteAll(['vendor_id' => $vendorId]);

        foreach($types as $type){
            $typeModel = new VendorHasType();
            $typeModel->vendor_id = $vendorId;
            $typeModel->type_id = $type;
            $typeModel->save();
        }
    }
}
