<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class KnowledgebaseEntry extends ActiveRecord {

	public $knowledgebases;

	public $statuses;

	public $category;

	public $files;

	public $file_ids;

	public $categories_tree_json;

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
			['knowledgebase_id', 'inKnowledgebases'],
			['category_id', 'required'],
			['category_id', 'integer'],
			['category_id', 'checkCategory'],
			['title', 'required'],
//			['title', 'unique'],
			['content', 'safe'],
			['status', 'required', 'when' => function($model) {
				return $model->is_category == 0;
			}],
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
		if ($this->is_category) return;
		if (!isset($this->statuses[$this->status])) {
			$this->addError('status', 'Wrong status');
		}
	}

	public function inKnowledgebases() {
		if (!isset($this->knowledgebases[$this->knowledgebase_id])) {
			$this->addError('knowledgebase_id', 'Knowledgebase doesn\'t exist');
		}
	}

	public function checkCategory() {
		if ($this->hasErrors('knowledgebase_id')) return;
		if (!$this->category_id) return;
		$this->category = KnowledgebaseEntry::find()->where([
			'knowledgebase_id' => $this->knowledgebase_id,
			'id' => $this->category_id,
			'is_category' => 1
		])->asArray()->one();
		if (!$this->category) {
			$this->addError('category_id', 'Category doesn\'t exist');
			return;
		}
		if ($this->is_category && $this->id) {
			if ($this->id == $this->category_id || substr($this->category['tree_path'], 0, strlen($this->tree_path) + 1) == $this->tree_path . '|') {
				$this->addError('category_id', 'Category isn\'t allowed');
				return;
			}
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

	public function cacheFilesInfo() {
		$files = ArrayHelper::map(KnowledgebaseEntryFile::find()->where([
			'knowledgebase_entry_id' => $this->id
		])->all(), 'id', 'name');
		$this->count_files = count($files);
		$this->list_files = serialize($files);
		return $this->updateAttributes(['count_files', 'list_files']);
	}

}
