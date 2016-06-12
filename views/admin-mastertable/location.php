<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use app\models\Region;
use app\models\Destination;
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
	<h4 class="modal-title"><?php if ($model->id): ?>Edit<?php else: ?>Add<?php endif; ?> Location</h4>
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
<?php $region = new Region();?>
<?php $destination = $model->destination;?>
<?php $destination_list = ($destination)?$destination->getList($destination->region_id):array();?>
<?php $region_id = ($destination)?$destination->region_id:'';?>


<div class="form-group field-location-name required">
	<?php echo Html::label('Region','region_id',array('class'=>'control-label col-sm-4'));?>
	<div class="col-sm-8">
		<?php echo Html::dropDownList('region_id', $region_id, $region->getList(),
					[
						'class'  => 'form-control',
					 	'prompt' => 'Select a region', 
					 	'onchange'=>'
					 		var id = $(this).val();
					 		$.ajax({
					 		url:"'.Yii::$app->urlManager->createUrl(["admin-mastertable/dynamicdestinations"]).'",
					 		method:"POST",
					 		data:{"region_id":id},
					 		success:function(data){
		                    	$("#location-destination_id").html( data );
		                    }
						})'
					]);
		?>
	</div>
</div>
<?php echo $form->field($model, 'destination_id')->dropDownList($destination_list);?>

<?php echo $form->field($model, 'name')->textInput(); ?>
<?php echo $form->field($model, 'airport')->textInput(); ?>
<?php echo $form->field($model, 'active',  [
        'horizontalCssClasses' => [
            'offset' => 'col-sm-offset-4',
        ]
    ])->checkbox(); ?>
<div class="pseudo_foo">
	<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel']) ?>
</div>

<?php ActiveForm::end(); ?>
