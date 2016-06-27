<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;

class KnowledgebaseEntryFile extends ActiveRecord {

	public $file;

	public $fileSaved;

	public static function tableName() {
		return Yii::$app->db->tablePrefix . 'knowledgebase_entry_file';
	}

	public function formName() {
		return '';
	}

	public function rules() {
		return [
			['knowledgebase_entry_id', 'safe'],
			['name', 'safe']
		];
	}

	public function afterSave($insert, $changedAttributes) {
		if ($insert) {
			$path = explode('/', number_format($this->id, 0, '', '/'));
			array_pop($path);
			$dir = 'uploads/knowledgebase-entry';
			$dir_ok = true;
			foreach ($path as $subdir) {
				$dir.= '/' . $subdir;
				if (is_dir($dir) || @mkdir($dir)) continue;
				$dir_ok = false;
				break;
			}
			if ($dir_ok) {
				$this->fileSaved = $this->file->saveAs($dir . '/' . $this->id);
			}
//		} else {
//			$dir = 'files/knowledgebases-entries/' . $this->knowledgebase_entry_id;
//			if (!is_dir($dir)) {
//				$dir_ok = @mkdir($dir);
//			} else {
//				$dir_ok = true;
//			}
//			$old_path = 'files/knowledgebases-entries/0/' . $this->id;
//			$new_path = 'files/knowledgebases-entries/' . $this->knowledgebase_entry_id. '/' . $this->id;
//			if ($dir_ok && @copy($old_path, $new_path)) {
//				$this->fileSaved = true;
//				@unlink($old_path);
//			} else {
//				$this->fileSaved = false;
//			}
		}
		parent::afterSave($insert, $changedAttributes);
	}

	public function afterDelete() {
		@unlink('files/knowledgebases-entries/' . $this->knowledgebase_entry_id . '/' . $this->id);
		parent::afterDelete();
	}

}
