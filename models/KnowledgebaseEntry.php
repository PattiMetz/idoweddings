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

	public $_old_knowledgebase_id;

	public $_old_category_id;

	public $_old_tree_path;

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
		if ($this->category_id) {
			$this->tree_path = $this->category_id;
			if (strlen($this->category['tree_path'])) {
				$this->tree_path = $this->category['tree_path'] . '|' . $this->tree_path;
			}
		} else {
			$this->tree_path = '';
		}
		if ($insert || $this->_old_knowledgebase_id != $this->knowledgebase_id || $this->_old_category_id != $this->category_id) {
			$max = KnowledgebaseEntry::getMaxOrder($this->knowledgebase_id, $this->category_id, $this->is_category);
			$this->order = $max + 5;
		}
		return parent::beforeSave($insert);
	}

	public function afterSave($insert, $changedAttributes) {
		if ($insert || isset($changedAttributes['knowledgebase_id']) || isset($changedAttributes['category_id'])) {
			// Renumber new category
			$this->renumberOrder($this->knowledgebase_id, $this->category_id, $this->is_category);
			// Renumber old category
			if (!$insert) {
				$this->renumberOrder($this->_old_knowledgebase_id, $this->_old_category_id, $this->is_category);
			}
		}
		parent::afterSave($insert, $changedAttributes);
	}

	public function afterDelete() {
		// Renumber current category
		$this->renumberOrder($this->knowledgebase_id, $this->category_id, $this->is_category);
		parent::afterDelete();
	}

	public function cacheFilesInfo() {
		$files = ArrayHelper::map(KnowledgebaseEntryFile::find()->where([
			'knowledgebase_entry_id' => $this->id
		])->all(), 'id', 'name');
		$this->count_files = count($files);
		$this->list_files = serialize($files);
		return $this->updateAttributes(['count_files', 'list_files']);
	}

	public function changeOrder($move_type, $position) {
		switch ($move_type) {
			case 'top':
				$this->order = 5;
				break;
			case 'up':
				$this->order = $this->order - 15;
				break;
			case 'position':
				$new_order = $position * 10;
				if ($new_order > $this->order) {
					$this->order = $new_order + 5;
				} elseif ($new_order < $this->order) {
					$this->order = $new_order - 5;
				}
				break;
			case 'down':
				$this->order = $this->order + 15;
				break;
			case 'bottom':
				$max = KnowledgebaseEntry::getMaxOrder($this->knowledgebase_id, $this->category_id, $this->is_category);
				$this->order = $max + 5;
				break;
		}
		return $this->updateAttributes(['order']);
	}

	public function getMaxOrder($knowledgebase_id, $category_id, $is_category) {
		return KnowledgebaseEntry::find()->where([
			'knowledgebase_id' => $knowledgebase_id,
			'category_id' => $category_id,
			'is_category' => $is_category
		])->max('`order`');
	}

	public function renumberOrder($knowledgebase_id, $category_id, $is_category) {
		Yii::$app->db->createCommand('SET @new_order = 0')->execute();
		Yii::$app->db->createCommand('
			UPDATE {{%knowledgebase_entry}}
			SET `order` = (@new_order := @new_order + 10)
			WHERE knowledgebase_id = :knowledgebase_id AND category_id = :category_id AND is_category = :is_category
			ORDER BY `order`
		')->bindValues([
			':knowledgebase_id' => $knowledgebase_id,
			':category_id' => $category_id,
			':is_category' => $is_category
		])->execute();
	}

}
