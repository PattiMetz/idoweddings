<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;

class Privilege extends ActiveRecord {

	public static function tableName() {
		return '{{privilege}}';
	}

	public function formName() {
		return '';
	}

	public function rules() {
		return [
			['disply_name', 'required'],
			['display_name', 'unique']
		];
	}

	public function attributeLabels() {
		return [
			'display_name' => 'Name'
		];
	}

	public function getTreeInfo() {
		$all = $this::find()
			->orderBy([new \yii\db\Expression('! parent_id, ord')])
			->indexBy('id')
			->all();
		$flat_tree = [];
		$child_ids = [];
		foreach ($all as $id => $row) {
			if ($row['parent_id']) {
				if (!isset($child_ids[$row['parent_id']])) {
					$child_ids[$row['parent_id']] = [];
				}
				$child_ids[$row['parent_id']][] = $id;
			} else {
				$flat_tree[$id] = $row;
				if (isset($child_ids[$id])) {
					foreach ($child_ids[$id] as $child_id) {
						$flat_tree[$child_id] = $all[$child_id];
					}
				}
			}
		}
		return compact('flat_tree', 'child_ids');
	}

}
