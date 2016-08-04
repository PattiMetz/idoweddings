<?php
use yii\helpers\Html;
use yii\helpers\Url;
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
	'closeButton' => false
]);

?>

<?php echo $form->field($model, 'organization_id')->begin(); ?>

	<?php echo Html::label($model->getAttributeLabel('organization_id')); ?>

	<?php echo Html::encode($model->organization_id); ?>

<?php echo $form->field($model, 'organization_id')->end(); ?>

<?php echo $form->field($model, 'display_name')->textInput(); ?>

<?php echo $form->field($model, 'display_name')->textInput(); ?>

<?php echo $form->field($model, 'email')->textInput(); ?>

<?php if ($model->scenario == 'create'): ?>

	<?php echo $form->field($model, 'username')->textInput(); ?>

	<?php echo $form->field($model, 'password')->textInput(); ?>

<?php else: ?>

	<?php echo $form->field($model, 'username')->begin(); ?>

		<?php echo Html::label($model->getAttributeLabel('username')); ?>

		<?php echo Html::encode($model->username); ?>

	<?php echo $form->field($model, 'username')->end(); ?>

<?php endif; ?>

<?php echo $form->field($model, 'privilege_ids')->checkboxList(['All', 'Antarctic']); ?>

<?php echo $form->field($model, 'privilege_ids')->checkboxList(['All', 'Florida (FL)']); ?>

<?php echo $form->field($model, 'privilege_ids')->checkboxList(['All', 'Wilmington']); ?>

<?php echo $form->field($model, 'role_id')->checkbox(); ?>

<?php echo $form->field($model, 'role_id')->dropDownList($model->roleItems, ['class'  => 'chosen-style']); ?>

<?php

/*TODO: Find another solution */
$privileges_field = [
	'id' => Html::getInputId($model, 'privilege_ids'),
	'name' => Html::getInputName($model, 'privilege_ids')
];

?>

<?php echo $form->field($model, 'privilege_ids')->begin(); ?>

<p class="role_text">Privileges</p>

<div class="role_scrolling_table_wrap table-responsive">

<?php echo $this->render('_privilege-checkbox-list', [
	'model' => $model,
	'privilegesDataProvider' => $privilegesDataProvider,
	'is_view' => false,
	'field_name' => $privileges_field['name']
]); ?>

</div>

<?php echo Html::error($model, 'privilege_ids', ['class' => 'help-block']); ?>

<?php echo $form->field($model, 'privilege_ids')->end(); ?>

<div class="pseudo_foo">
	<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php

$this->registerJS($_privilege_checkbox_change_handler_js);

$checkbox_list_url = Url::to(['admin-user-manager/role-privilege-checkbox-list']);

$role_field_id = Html::getInputId($model, 'role_id');

$js = <<<EOT
	$('.custom-parent-privilege').change({fieldId: '{$privileges_field['id']}'}, handleCheckboxChange);

	$('#{$role_field_id}').on('change', function() {

		$('#modal .alert-danger').hide();

		$('#preloader').show();

		$.ajax({
			url: '{$checkbox_list_url}',
			type: 'GET',
			data: {
				role_id: this.value,
				field_name: '{$privileges_field['name']}'
			},
			timeout: ajaxTimeout,
			complete: function() {

				$('#preloader').hide();

			},
			error: function(jqXHR) {

				var message;

				if (jqXHR.status == 0) {

					message = ajaxTimeoutMessage;

				} else {

					message = jqXHR.responseText;

				}

				$('#modal .alert-danger').html(message).show().delay(2000).fadeOut();

				$('.role_scrolling_table_wrap').html('Data not loaded.');

				$('#modal .btn-primary').attr('disabled', true);

			},
			success: function(data) {

				$('.role_scrolling_table_wrap').html(data);

				$('#modal .btn-primary').attr('disabled', false);

				$('.custom-parent-privilege').change({fieldId: '{$privileges_field['id']}'}, handleCheckboxChange);

			}
		});

	});
EOT;

$this->registerJS($js);
