<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>
<?php

if (!$is_view) {
	echo Html::hiddenInput($field_name, '');
}

$tableOptionsClass = 'table table-bordered table-condensed';

if (!$is_view) {
	$tableOptionsClass.= ' scrolling_table';
}

echo GridView::widget([
	'dataProvider' => $privilegesDataProvider,
	'layout' => "{items}",
	'tableOptions' => [
		'class' => $tableOptionsClass
	],
	'rowOptions' => function($privilege) {
		if ($privilege->parent_id) {
			return ['class' => 'child_line'];
		}
	},
	'columns' => [
		[
			'label' => 'Name',
			'attribute' => 'display_name'
		],
		[
			'label' => 'Enabled',
			'format' => 'raw',
			'value' => function ($data) use ($model, $is_view, $field_name) {
				$checked = in_array($data->id, $model->privilege_ids);
				if (!$is_view) {
					$options = [
						'value' => $data->id,
						'class' => 'custom_checkbox'
					];
					if ($data['parent_id']) {
						if (!in_array($data['parent_id'], $model->privilege_ids)) {
							$options['disabled'] = 'disabled';
						}
					} elseif (!empty($model->privilegesTreeInfo['child_ids'][$data->id])) {
						$options['class'].= ' custom-parent-privilege';
						$options['data-child-ids'] = json_encode($model->privilegesTreeInfo['child_ids'][$data->id]);
					}
				} else {
					$options = [
						'class' => 'custom_checkbox',
						'disabled' => 'disabled'
					];
					if ($checked) {
						$options['class'].= ' on';
					}
				}
				return Html::checkbox("{$field_name}[]", $checked, $options);
			}
		],
	],
]);
