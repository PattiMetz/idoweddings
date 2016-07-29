<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\grid\GridView;
?>
<?php

$form = ActiveForm::begin([
	'layout' => 'horizontal',
	'options' => [
		'class' => 'ajax-form'
	],
	'fieldConfig' => [
		'horizontalCssClasses' => [
			'label' => 'col-sm-4',
			'wrapper' => 'col-sm-6',
			'error' => '',
			'hint' => '',
		]
	],
]);

?>

<div class="pseudo_head">
	<h4 class="modal-title"><?php echo Html::encode($this->title); ?></h4>
</div>

<?php

echo Alert::widget([
	'options' => [
		'class' => 'alert-danger',
		'style' => 'display: none'
	],
	'body' => '',
	'closeButton' => false,                                 
]);

?>

<?php echo $form->field($model, 'display_name')->textInput(); ?>

<?php echo $form->field($model, 'privilege_ids')->begin(); ?>

<p class="role_text">Privileges</p>

<div class="role_scrolling_table_wrap table-responsive">

<?php
	echo GridView::widget([
		'dataProvider' => $privilegesDataProvider,
		'layout' => "{items}",
		'tableOptions' => [
			'class' => 'table table-bordered table-condensed scrolling_table'
		],
		'rowOptions' => function($model) {
			if ($model->parent_id) {
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
				'value' => function ($data) use ($model) {
					$options = [
						'value' => $data->id,
						'id' => 'privilege_ids-' . $data->id,
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
					return Html::checkbox('privilege_ids[]', in_array($data->id, $model->privilege_ids), $options);
				}
			],
		],
	]);
?>

</div>

<?php echo Html::error($model, 'privilege_ids', ['class' => 'help-block']); ?>

<?php echo $form->field($model, 'privilege_ids')->end(); ?>

<div class="pseudo_foo">
	<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php

$js = <<<EOT
	$('.custom-parent-privilege').on('change', function() {
		var checked = this.checked;
		var childIds = $(this).data('child-ids');
		$.each(childIds, function(index, value) {
			$('#privilege_ids-' + value).prop('checked', checked);
			$('#privilege_ids-' + value).prop('disabled', !checked);
			$('#privilege_ids-' + value).trigger('refresh');
		});
	});
EOT;

$this->registerJS($js);
