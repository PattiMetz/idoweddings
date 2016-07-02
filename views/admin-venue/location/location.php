<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\venue\VenueLocation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="venue-location-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
           
        ]); ?>

    <?= $form->field($model, 'group_id',['template'=>'{input}'])->hiddenInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guest_capacity')->textInput(['maxlength' => true]) ?>

    
    <?php if($model->times):?>
    	<p><strong>Available Time slots</strong></p>
		<div class="times" style="border:solid 1px #ccc;float:left;width:100%">

			<?php foreach($model->times as $k=>$stime):?>
				<div class="col-sm-12 time">
					<div class="col-sm-3">
						<?= $stime->time_from?>
					</div>
					<div class="col-sm-3">
						<?= $stime->time_to?>
					</div>
					<div class="col-sm-4">
						<?= $form->field($stime, 'days_array')->checkboxList($days,['disabled'=>'disabled']) ?>
					</div>
					<div class="col-sm-2">
						<?= Html::Button('Edit', ['class' =>'btn btn-primary add_time_slot']) ?>
						<?= Html::Button('Remove', ['class' =>'btn btn-primary add_time_slot']) ?>
					</div>
				</div>

			<?php endforeach;?>

		</div>

	<?php endif;?>

	<div class="col-sm-12 add_time">

		<div class="col-sm-3">
			<?= $form->field($time, 'time_from')->dropDownList($times, ['prompt'=>'time from']) ?>
		</div>
		<div class="col-sm-3">
			<?= $form->field($time, 'time_to')->dropDownList($times, ['prompt'=>'time to']) ?>
		</div>
		<div class="col-sm-4">
			<?= $form->field($time, 'days')->checkboxList($days) ?>
		</div>
		<div class="col-sm-2">
			<?= Html::SubmitButton('Add time slot', ['class' =>'btn btn-primary add_time_slot']) ?>
		</div>
	</div>
    
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php if(isset($images) && count($images)>0) {?> 
        <ul class="docs">
            <?php foreach ($images as $image) {?>
            <li>
                <?=Html::img("/uploads/venue/".$model->group->venue_id."/location/thumb/".$image->image)?>
                <?=Html::a('delete',[Url::to([Yii::$app->controller->id."/delete-image", 'id'=>$image->id])],['class'=>'modal-ajax'])?>
            </li>
            <?php }?>
        </ul>
    <?php }?>
    <div class="attach_block">
        <span>Upload Files:</span>
    </div>
  

    <?=$form->field($model, 'files[]')->fileInput(['multiple' => 'multiple']);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
