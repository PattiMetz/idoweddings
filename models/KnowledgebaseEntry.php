<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;

class KnowledgebaseEntry extends ActiveRecord {

	public $statuses;

	public $category;

	public static function tableName() {
		return Yii::$app->db->tablePrefix . 'knowledgebase_entry';
	}

	public function formName() {
		return '';
	}

	public function rules() {
		return [
			['knowledgebase_id', 'required'],
			['knowledgebase_id', 'integer'],
			['knowledgebase_id', 'knowledgebaseExists'],
			['category_id', 'required'],
			['category_id', 'integer'],
			['category_id', 'categoryExists'],
			['title', 'required'],
//			['title', 'unique'],
			['status', 'required'],
			['status', 'inStatuses']
		];
	}

	public function attributeLabels() {
		return [
			'order' => 'Order',
			'title' => 'Title'
		];
	}

	public function inStatuses() {
		if (!isset($this->statuses[$this->status])) {
			$this->addError('status', 'Wrong status');
		}
	}

	public function knowledgebaseExists() {
		$exists = Knowledgebase::find()->where(['id' => $this->knowledgebase_id])->exists();
		if (!$exists) {
			$this->addError('knowledgebase_id', 'Knowledgebase doesn\'t exist');
		}
	}

	public function categoryExists() {
		if ($this->hasErrors('knowledgebase_id')) return;
		if (!$this->category_id) return;
		$this->category = KnowledgebaseEntry::find()->where([
			'knowledgebase_id' => $this->knowledgebase_id,
			'id' => $this->category_id,
			'is_category' => 1
		])->asArray()->one();
		if (!$this->category) {
			$this->addError('category_id', 'Category doesn\'t exist');
		}
	}

	public function beforeSave($insert) {
		if (parent::beforeSave($insert)) {
			if ($this->category_id) {
				$this->tree_path = $this->category_id;
				if (strlen($this->category['tree_path'])) {
					$this->tree_path = $this->category['tree_path'] . '|' . $this->tree_path;
				}
			} else {
				$this->tree_path = '';
			}
			return true;
		}
		return false;
	}

}
