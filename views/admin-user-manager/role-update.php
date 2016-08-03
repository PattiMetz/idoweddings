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

$js = <<<EOT
	$('.custom-parent-privilege').change({fieldId: '{$privileges_field['id']}'}, handleCheckboxChange);
EOT;

$this->registerJS($js);
