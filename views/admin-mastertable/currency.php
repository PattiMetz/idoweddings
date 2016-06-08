<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use app\models\Region;
use app\models\Currency;
?>
<?php
$this->registerJs("$('.calculate_currency').on('keyup', function(){
	var rate = parseFloat($('#currency-rate').val());
	var buffer = parseFloat($('#currency-buffer').val());
	var control_amount = parseFloat($('#currency-control_amount').val());
	if(rate && buffer && control_amount) {
		$('.usd_amount').html(eval(rate*control_amount).toFixed(2));
		$('.usd_buffer_amount').html(eval(rate*control_amount*buffer).toFixed(2));
	}
})");
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
	<h4 class="modal-title"><?php if ($model->id): ?>Edit<?php else: ?>Add<?php endif; ?> Currency</h4>
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



<?php echo $form->field($model, 'name')->textInput(); ?>

<?php echo $form->field($model, 'short')->textInput(); ?>
<?php echo $form->field($model, 'main')->checkbox(); ?>
<hr/>
<div class="half-float">
	<?php echo $form->field($model, 'rate')->textInput(['class'=>'calculate_currency form-control']); ?>
	<?php echo $form->field($model, 'buffer')->textInput(['class'=>'calculate_currency form-control']); ?>
</div>
<div class="half-float">
	<?php echo $form->field($model, 'control_amount')->textInput(['class'=>'calculate_currency form-control']); ?>
	<p>USD Amount = <span class="usd_amount"><?php echo (($model->id)?(round(($model->control_amount*$model->rate), 2)):'')?></span></p>
	<p>USD Amount = <span class="usd_buffer_amount"><?php echo (($model->id)?(round(($model->control_amount*$model->rate*$model->buffer), 2)):'')?></span></p>
</div>
<div class="pseudo_foo">
	<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel']) ?>
</div>

<?php ActiveForm::end(); ?>
