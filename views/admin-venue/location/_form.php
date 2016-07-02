<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\venue\VenueLocation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="venue-location-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'clearfix']]); ?>

    <?= $form->field($model, 'group_id',['template'=>'{input}'])->hiddenInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php if($model->time):?>


	<?php endif;?>
	
	<div class="add_time">
		<?= $form->field($time, 'time_from')->textInput(['maxlength' => true]) ?>
	</div>
    
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php if(isset($images) && count($images)>0) {?> 
        <ul class="docs">
            <?php foreach ($images as $image) {?>
            <li>
                <?=Html::a($image->image,["/uploads/venue/".$model->id."/location/".$image->image],['target'=>'_blank','data-pjax'=>0])?>
                <?=Html::a('delete',[Url::to([Yii::$app->controller->id."/delete-doc", 'id'=>$image->id])],['class'=>'modal-ajax'])?>
            </li>
            <?php }?>
        </ul>
    <?php }?>
    <div class="attach_block">
        <span>Upload Files:</span>
    </div>
  

    <?=$form->field($doc, 'files[]')->fileInput(['multiple' => 'multiple']);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
