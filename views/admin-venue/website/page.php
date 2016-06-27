<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use app\models\Currency;
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
	<h4 class="modal-title"><?php if ($model->id): ?>Edit<?php else: ?>Add<?php endif; ?> <?php echo \yii\helpers\StringHelper::basename(get_class($model))?></h4>
</div>

<?php

echo Alert::widget([
	'options' => [
		'class' => 'alert-danger',
		'style' => ($alert == '') ? 'display: none' : ''
	],
	'body' => $alert,
	'closeButton' => false,
]);

?>

<?php
	if(!($model->venue_id>0)) {
		$model->type = 'custom';

		$model->venue_id = Yii::$app->request->get('venue_id');
	}
?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->field($model, 'venue_id',['template'=>'{input}'])->hiddenInput(); ?>
<?php echo $form->field($model, 'order',['template'=>'{input}'])->hiddenInput(); ?>
<?php echo $form->field($model, 'type',['template'=>'{input}'])->hiddenInput(); ?>
<?php echo $form->field($model, 'name')->textInput(); ?>
<div class="pseudo_foo">
	<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel']) ?>
</div>

<?php ActiveForm::end(); ?>

