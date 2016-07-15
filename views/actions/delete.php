<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
?>
<?php
$this->render('/admin-mastertable/lang.php');
$form = ActiveForm::begin([
	'options' => [
		'class' => 'ajax-form'
	]
]);

?>
<div class="pseudo_head">
	<h4 class="modal-title">Delete <?php echo isset($languages[$exampleName]['single'])?$languages[$exampleName]['single']:'item'?>?</h4>
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

<p>You are one step from deleting the item</p>

<div class="pseudo_foo">
	<?php echo Html::submitButton('Delete', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel']) ?>
</div>

<?php ActiveForm::end(); ?>
