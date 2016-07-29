<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;

class Organization extends ActiveRecord {

	public static function tableName() {
		return '{{organization}}';
	}

	public function formName() {
		return '';
	}

	public function rules() {
		return [
		];
	}

	public function attributeLabels() {
		return [
		];
	}

}
