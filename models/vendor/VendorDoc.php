<?php

namespace app\models\vendor;

use Yii;

/**
 * This is the model class for table "vendor_doc".
 *
 * @property integer $id
 * @property integer $vendor_id
 * @property string $name
 * @property string $filename
 * @property integer $status
 *
 * @property Vendor $vendor
 */
class VendorDoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vendor_doc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor_id', 'name', 'filename'], 'required'],
            [['vendor_id', 'status'], 'integer'],
            [['name', 'filename'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'filename' => 'Filename',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vendor_id']);
    }
}
