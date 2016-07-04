<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use app\models\Region;
use app\models\Currency;
use dosamigos\ckeditor\CKEditor;
use yii\widgets\breadcrumbs;

?>
<?php $this->registerJs("CKEDITOR.plugins.addExternal('htmlbuttons', '/js/ckeditor/plugins/htmlbuttons/', 'plugin.js');", 4);?>
<?php
$this->title = $model->id?$model->name:'Add Agreement';
$this->params['breadcrumbs'][] = ['label' => 'Agreement', 'url' => ['agreement-list']];
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([
	'layout' => 'horizontal',
	'options' => [

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
<div class="top">
	<?= Breadcrumbs::widget([
             'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
          ]) ?>
	<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save']) ?>
	<?php echo Html::submitButton('Save and create new', ['class' => 'btn btn-primary', 'name' => 'create']) ?>
	<?php echo Html::submitButton('Make clone', ['class' => 'btn btn-primary', 'name' => 'clone']) ?>
</div>
<div class="pseudo_head">
	<h4 class="modal-title"><?php if ($model->id): ?>Edit<?php else: ?>Add<?php endif; ?> Agreement</h4>
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

<?php echo $form->field($model, 'agreement_for')->dropDownList(['Vendor' => 'Vendor','Venue' => 'Venue', 'Agent Travel' => 'Agent Travel', 'Customer' => 'Customer', 'Staff'=>'Staff', 'Other'=>'Other']); ?>


<?php echo $form->field($model, 'text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standart',
        'clientOptions' => [
            'extraPlugins' => 'htmlbuttons',
            'htmlbuttons' => [
				[
					'name'=>'divs',
					'icon'=>'puzzle.png',
					'title'=>'shortcodes',
					'items' => $codes
				]	
			]
        ]
    ]) ?>


<?php ActiveForm::end(); ?>
