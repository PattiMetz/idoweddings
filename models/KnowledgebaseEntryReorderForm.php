<?php

namespace app\models;

use Yii;
use yii\base\Model;

class KnowledgebaseEntryReorderForm extends Model {

	public $move_type;

	public $position;

	public $move_types;

	public $move_types_visible;

	public function formName() {
		return '';
	}

	public function rules() {
		return [
			['move_type', 'required'],
			['move_type', 'inMoveTypes'],
			['position', 'required', 'when' => function($model) {
				return $model->move_type == 'position';
			}],
		];
	}

	public function inMoveTypes() {
		if (!isset($this->move_types[$this->move_type])) {
			$this->addError('move_type', 'Wrong move type');
		}
	}

}
