<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;

class KnowledgebaseEntry extends ActiveRecord {

	public static function tableName() {
		return Yii::$app->db->tablePrefix . 'knowledgebases_entries';
	}

	public function formName() {
		return '';
	}

	public function rules() {
		return [
			['title', 'required'],
			['title', 'unique']
		];
	}

	public function attributeLabels() {
		return [
			'order' => 'Order',
			'title' => 'Title'
		];
	}

}
