<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
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
			'wrapper' => 'col-sm-8',
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

<?php #var_dump($model->privilege_ids); ?>

<?php #echo $form->field($model, 'privilege_ids')->dropDownList(range(1, 5), ['multiple' => 'multiple']); ?>

<!--tr class="child_line">
	<td>Add edit delete knowledge base</td>
	<td>
		<div class="form-inline clearfix">
			<div class="input-group">
				<span class="input-group-addon dis"></span>	
				<div class="input-group-btn">
					<button type="button" class="btn btn-default sel_btn">Off</button>
				</div>
			</div>
		</div>
	</td>
</tr-->

<?php echo $form->field($model, 'privilege_ids')->begin(); ?>

<div id="tab_wrap">
	<div class="table-responsive">
		<table class="table table-bordered table-condensed scrolling_table">
			<thead>
				<tr>
					<th>Privileges for the role</th>
					<th>Enabled</th>
				</tr>
			</thead>
			<tbody>

			<?php foreach ($model->privilegesTreeInfo['flat_tree'] as $privilege_id => $privilege): ?>

				<tr <?php if ($privilege['parent_id']): ?>class="child_line"<?php endif; ?>>
					<td>

						<?php echo Html::encode($privilege['display_name']); ?>

					</td>
					<td>

						<?php

							$options = [
								'value' => $privilege_id,
								'id' => 'privilege_ids-' . $privilege_id,
								'class' => 'custom_checkbox'
							];

							if ($privilege['parent_id']) {

								if (!in_array($privilege['parent_id'], $model->privilege_ids)) {

									$options['disabled'] = 'disabled';

								}

							} elseif (!empty($model->privilegesTreeInfo['child_ids'][$privilege_id])) {

								$options['class'].= ' custom-parent-privilege';

								$options['data-child-ids'] = json_encode($model->privilegesTreeInfo['child_ids'][$privilege_id]);

							}

						?>

						<?php echo Html::checkbox('privilege_ids[]', in_array($privilege_id, $model->privilege_ids), $options); ?>

					</td>
				</tr>

			<?php endforeach; ?>

			</tbody>
		</table>
	</div>
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
