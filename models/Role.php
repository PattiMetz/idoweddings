<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;

class Role extends ActiveRecord {

	public $privilegesTreeInfo;

	public $privilege_ids;

	public static function tableName() {
		return '{{%role}}';
	}

	public function formName() {
		return '';
	}

	public function rules() {
		return [
			['display_name', 'required'],
			/*TODO: What's the workaround using Yii coding style? */
			['privilege_ids', 'filter', 'filter' => [$this, 'handleEmptySelection']],
			['privilege_ids', 'each', 'rule' => ['integer']],
			['privilege_ids', 'filter', 'filter' => 'array_unique'],
			/*TODO: Maybe to show an error instead of removing invalid privileges? */
			['privilege_ids', 'filter', 'filter' => [$this, 'checkPrivileges']]
		];
	}

	public function attributeLabels() {
		return [
			'display_name' => 'Name'
		];
	}

	public function handleEmptySelection($value) {
		if ($value === '') {
			$value = [];
		}
		return $value;
	}

	public function checkPrivileges($value) {
		foreach (array_keys($value) as $key) {
			if (!isset($this->privilegesTreeInfo['flat_tree'][$value[$key]])) {
				unset($value[$key]);
			}
		}
		return $value;
	}

	public function getPrivileges() {
		return $this->hasMany(Privilege::className(), ['id' => 'privilege_id'])
			->viaTable('{{%role_privilege}}', ['role_id' => 'id']);
	}

	public function getUsers() {
		return $this->hasMany(User::className(), ['id' => 'id'])
			->viaTable('{{%user}}', ['role_id' => 'id']);
	}

}
