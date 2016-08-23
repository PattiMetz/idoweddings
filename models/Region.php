<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class Region extends ActiveRecord {

	public static function tableName() {
		return Yii::$app->db->tablePrefix . 'region';
	}

	public function formName() {
		return '';
	}

	public function rules() {
		return [
			[['name', 'currency_id'], 'required'],
			['name', 'unique'],
            ['currency_id', 'integer']
		];
	}

	public function attributeLabels() {
		return [
			'name' => 'Name',
            'currency_id' => 'Main currency in this region'
		];
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
    public function getCurrencyName() {
       return $this->currency->name;
    }

    /**
     * @return array
     */
    public function getList() { // could be a static func as well
        $models = $this->find()->orderby('name')->asArray()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }

	/**
	 * @return array
	 */
	public static function getStatList() {
		$models = self::find()->orderby('name')->asArray()->all();
		return ArrayHelper::map($models, 'id', 'name');
	}

	public function getDestinations()
	{
		return $this->hasMany(Destination::className(), ['region_id' => 'id']);
	}

}
