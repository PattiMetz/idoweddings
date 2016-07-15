<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
?>
<?php

$form = ActiveForm::begin([
	'options' => [
		'class' => 'ajax-form'
	]
]);

?>

<div class="pseudo_head">
	<h4 class="modal-title"><?php echo Html::encode($this->title); ?></h4>
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

<p>You are in one step from deleting the article - <?php echo Html::encode($model->title)?>.</p>

<div class="pseudo_foo">
	<?php echo Html::submitButton('Delete', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel']) ?>
</div>

<?php ActiveForm::end(); ?>
