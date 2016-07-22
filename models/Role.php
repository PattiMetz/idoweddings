<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;

class Role extends ActiveRecord {

	public $privilegesTreeInfo;

	public $privilege_ids;

	public static function tableName() {
		return '{{role}}';
	}

	public function formName() {
		return '';
	}

	public function rules() {
		return [
			['display_name', 'required'],
			['privilege_ids', 'each', 'rule' => ['integer']],
			['privilege_ids', 'filter', 'filter' => 'array_unique'],
		];
	}

	public function attributeLabels() {
		return [
			'display_name' => 'Name'
		];
	}

	public function getPrivileges() {
		return $this->hasMany(Privilege::className(), ['id' => 'privilege_id'])
			->viaTable('role_privilege', ['role_id' => 'id']);
	}

}
