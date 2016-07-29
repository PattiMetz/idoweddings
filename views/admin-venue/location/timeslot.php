<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
?>
<?php
$days = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
$halfs = array('AM', 'PM');
foreach($halfs as $half) {
    for($i=0;$i<12;$i++) {
        $times[$i.' '.$half] = $i.' '.$half;
    }
}
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
if(!is_array($model->days))
	$model->days = unserialize($model->days);
?>
<div class="add_timeslot_wrapper add_time clearfix">
	<div class="col-sm-3 col-xs-6">
		<?php echo $form->field($model, 'time_from')->dropDownList($times, ['class' => 'form-control time_from'], ['prompt'=>'time from'])->label('From',['class'=>'control-label col-sm-4']) ?>
	</div>
	<div class="col-sm-3 col-xs-6">
		<?php echo $form->field($model, 'time_to')->dropDownList($times, ['class' => 'form-control time_to'], ['prompt'=>'time to'])->label('To',['class'=>'control-label col-sm-4']) ?>
	</div>
	
	<div class="col-sm-4">
		
		<ul class="timeslot_list list-inline">
			<?php echo $form->field($model, 'days',['template'=>'{input}{error}'])->checkboxList($days,[
			'tag'=>'li',
			'separator'=>'</li><li>',
			'item' =>
				function ($index, $label, $name, $checked, $value) {
					return Html::checkbox($name, $checked, [
									'id' => $label,
									'value' => $value,
									'label' => '<label for="' . $label . '">' . $label . '</label>',
									'labelOptions' => [
										'class' => 'checkbox-inline',
									],
									
								]);
				}]) ?>
		</ul>
	</div>
	<div class="col-sm-2">
		<?php echo Html::SubmitButton('Save time slot', ['class' =>'btn btn-danger add_time_slot']) ?>
	</div>
</div>
<?php ActiveForm::end(); 