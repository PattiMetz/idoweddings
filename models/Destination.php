<?php

namespace app\models;

use Yii;
use Yii\helpers\ArrayHelper;
/**
 * This is the model class for table "destinations".
 *
 * @property integer $id
 * @property string $name
 * @property integer $region_id
 * @property integer $currency_id
 * @property integer $active
 *
 * @property Regions $region
 * @property Currencies $currency
 * @property Locations[] $locations
 */
class Destination extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'destination';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'region_id', 'currency_id', 'active'], 'required'],
            [['region_id', 'currency_id', 'active'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegionName()
    {
        return $this->region->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyName()
    {
        return $this->currency->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(Location::className(), ['destination_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getList($region_id) { 
        $models = $this->find()->orderby('name')->where(['region_id' => $region_id])->asArray()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }

    /**
     * @return array
     */
    public static function getStatList($region_id) {
        $models = self::find()->orderby('name')->where(['region_id' => $region_id])->asArray()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Destination Name',
            'region_id' => 'Region',
            'currency_id' => 'Main currency in this destination',
            'active' => 'Active',
        ];
    }


}
