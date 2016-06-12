<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "locations".
 *
 * @property integer $id
 * @property string $name
 * @property integer $region_id
 * @property integer $destination_id
 * @property integer $currency_id
 * @property integer $airport
 *
 * @property Regions $region
 * @property Destinations $destination
 * @property Currencies $currency
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'destination_id',  'airport'], 'required'],
            [['destination_id','active'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['airport'], 'string', 'max' => 20],
            [['destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destination::className(), 'targetAttribute' => ['destination_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'destination_id' => 'Destination',
            
            'airport' => 'Airport',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestination()
    {
        return $this->hasOne(Destination::className(), ['id' => 'destination_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinationName() {
        return $this->destination->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegionName() {
        return $this->destination->region->name;
    }
}
