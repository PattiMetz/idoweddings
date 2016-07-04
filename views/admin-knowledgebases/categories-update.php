<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
?>
<?php

$form = ActiveForm::begin([
	'layout' => 'horizontal',
	'id' => 'categories-update',
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
		'style' => ($alert == '') ? 'display: none' : ''
	],
	'body' => $alert,
	'closeButton' => false,
]);

?>

<?php echo $form->field($model, 'knowledgebase_id')->dropDownList($model->knowledgebases, ['class'  => 'form-control chosen-style']); ?>

<?php echo $form->field($model, 'category_id')->textInput(); ?>

<?php echo $form->field($model, 'title')->textInput(); ?>

<div class="pseudo_foo">
	<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php

$categories_tree_url = Url::to(['admin-knowledgebases/categories-tree']);

$js = <<<EOT
	$('#category_id').combotree({
		animate: true,
		data: {$model->categories_tree_json}
	});

	$('#knowledgebase_id').on('change', function() {
		$('#category_id').combotree({
			url: '{$categories_tree_url}' + '?knowledgebase_id=' + $(this).val()
		});
		$('#category_id').combotree('setValue', '0');
	});
EOT;

$this->registerJS($js);
