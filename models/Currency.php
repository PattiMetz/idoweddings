<?php

namespace app\models;

use Yii;
use Yii\helpers\ArrayHelper;

/**
 * This is the model class for table "currencies".
 *
 * @property integer $id
 * @property string $name
 * @property double $rate
 * @property double $buffer
 * @property string $short
 * @property string $main
 *
 * @property Destinations[] $destinations
 * @property Locations[] $locations
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rate', 'buffer', 'short', 'main'], 'required'],
            [['rate', 'buffer', 'control_amount'], 'number'],
            [['main'], 'string'],
            [['updated_by'], 'integer'],
            [['name', 'updated_at'], 'string', 'max' => 20],
            [['short'], 'string', 'max' => 10],
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
            'rate' => 'Exchange rate',
            'buffer' => 'Buffer',
            'short' => 'Short name',
            'main' => 'Main currency in system',
            'control_amount' => 'Control Amount',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
     
            $this->updated_at = date("Y/m/d h:i:s");
     
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinations()
    {
        return $this->hasMany(Destinations::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(Locations::className(), ['currency_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getList() { 
        $models = $this->find()->asArray()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }
}
