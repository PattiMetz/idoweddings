<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
?>
<?php

$form = ActiveForm::begin([
//	'layout' => 'horizontal',
	'options' => [
		'class' => 'ajax-form knowledgebase-entry-reorder-form'
	],
/*	'fieldConfig' => [
		'horizontalCssClasses' => [
			'label' => 'col-sm-4',
			'wrapper' => 'col-sm-8',
			'error' => '',
			'hint' => '',
		]
	],*/
]);

?>

<div class="pseudo_head">
	<h4 class="modal-title"><?php echo Html::encode($this->title); ?></h4>
</div>

<?php

echo Alert::widget([
	'options' => [
		'class' => 'alert-danger',
		'style' => (1) ? 'display: none' : ''
	],
	'body' => '',
	'closeButton' => false,
]);

?>

<?php echo $form->field($model, 'move_type')->radioList($model->move_types_visible, ['unselect' => NULL])->label(false); ?>

<?php echo $form->field($model, 'position')->textInput()->label(false); ?>

<div class="pseudo_foo">
	<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel']) ?>
</div>

<?php ActiveForm::end(); ?>
