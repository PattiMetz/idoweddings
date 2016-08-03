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

	public function getAvailableRoles() {
		return Role::find()
			->where([
				'organization_id' => 0,
				'organization_type_id' => $this->type_id
			])
			->orWhere(['organization_id' => $this->id])
			->orderBy([new \yii\db\Expression('! organization_id DESC, id')]);
	}

}
