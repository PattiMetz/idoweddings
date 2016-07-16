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
	<h4 class="modal-title">Change venue url address</h4>
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

<?php echo $form->errorSummary($model); ?>

<p>Please indicate your preferred website address for the venue</p>
<div class="form-group">
	<input type="hidden" id="validate" name='validate'/>
	<div class="col-sm-8">
		<?php echo $form->field($model, 'url',['template'=>'http://{input}.idoweddings.com'])->textInput(['class'=>'form-control webaddress_input']); ?>
	</div>
	<div class="col-sm-3">
		<?php echo Html::submitButton('Validate Address', ['class' => 'btn btn-primary','name'=>'validate', 'onclick'=>'$("#validate").val(1)']) ?>
	</div>
</div>
<div class="pseudo_foo">
	<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel','name'=>'save', 'onclick'=>'$("#validate").val(0)']) ?>
</div>

<?php ActiveForm::end(); ?>

