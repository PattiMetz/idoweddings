<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use app\models\Region;
use app\models\Currency;
use dosamigos\ckeditor\CKEditor;
use yii\widgets\breadcrumbs;

?>
<?php //$this->registerJs("CKEDITOR.plugins.addExternal('htmlbuttons', '/js/ckeditor/plugins/htmlbuttons/', 'plugin.js');", 4);?>
<?php //$this->registerJs("CKEDITOR.plugins.addExternal('timestamp', '/js/ckeditor/plugins/timestamp/', 'plugin.js');", 4);?>
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


<?php echo $form->field($model, 'text')->textarea();/*widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'standart',
        'clientOptions' => [
        	'preset' => 'full',
            'extraPlugins' => 'timestamp',
            'htmlbuttons' => [
				[
					'name'=>'basicstyles',
					'icon'=>'puzzle.png',
					'title'=>'shortcodes',
					'toolbar'=>'basicstyles',
					'items' => $codes
				]	
			],
			'customConfig' => '/js/ckeditor/config.js',
			

        ]
    ])*/ ?>
<?php $this->registerJsFile("/ckeditor/ckeditor.js",['depends'=>'yii\web\JqueryAsset']);?>

<?php $this->registerJs("
$('document').ready(function(){
CKEDITOR.plugins.addExternal('htmlbuttons', '/ckeditor/plugins/htmlbuttons/', 'plugin.js');

//CKEDITOR.config.customConfig = '/js/ckeditor/config.js'
//CKEDITOR.config.extraPlugins='htmlbuttons'; 
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	
	//config.extraPlugins = 'htmlbuttons';
	config.htmlbuttons =	[
		{
			name:'button1',
			icon:'icon1.png',
			html:'<a> test</a>',
			title:'A link to Google',
			toolbar:'insert'
		},
	];
	config.toolbar = [
	    { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },
	    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	    '/',
	    { name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
	    { name: 'inset', items: [ 'Table','button1' ] }
	];
	// config.uiColor = '#AADC6E';
};
CKEDITOR.replace( 'agreement-text');
})
", 4);?>
<?php ActiveForm::end(); ?>
