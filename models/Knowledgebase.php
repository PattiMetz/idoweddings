<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;

class Knowledgebase extends ActiveRecord {

	public static function tableName() {
		return Yii::$app->db->tablePrefix . 'knowledgebases';
	}

	public function formName() {
		return '';
	}

	public function rules() {
		return [
			['name', 'required'],
			['name', 'unique']
		];
	}

	public function attributeLabels() {
		return [
			'name' => 'Name'
		];
	}

}
