<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\breadcrumbs;

$this->registerJsFile("/js/customization.js",['depends'=>'yii\web\JqueryAsset']);

$this->title = 'Website Editor '.$page->name. ' page';
$this->params['breadcrumbs'][] = ['label' => 'Venues', 'url' => ['admin/venue/index']];
$this->params['breadcrumbs'][] = ['label' => 'Web site Customization', 'url' => ['admin/venue/settings', 'id' => $venue->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
    $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => ['enctype' => 'multipart/form-data'],
        'options' => [
            'class' => 'clearfix'
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
	<div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php echo $form->errorSummary($settings); ?>
<div class="col-sm-12">
	<div class="col-sm-2">
		<?php echo Html::dropDownList('page', $page->id, $pages,['class'  => 'form-control chosen-style','id'=>'page']);?>
		<div class="list_wrap">
			<p>Venue Sunscape the Beach Customization </p>
			<?php echo $form->field($settings,'top_type',['template'=>'{input}'])->radioList(['image'=>'image','slideshow'=>'slideshow','video'=>'video','none'=>'none'],['id'=>'top']);?>
		</div>
		<div class="image_block top_block">
			<?php if(isset($images) && count($images)>0) {?> 
				<ul class="images">
					<?php foreach ($images as $simage) {?>
					<li>
						<?=Html::img("/uploads/venue/".$venue->id."/website/".$page->type."/thumb/".$simage->image)?>
						<?=Html::a('delete',[Url::to([Yii::$app->controller->id."/delete-image", 'id'=>$simage->id])],['class'=>'modal-ajax'])?>
					</li>
					<?php break;?>
					<?php }?>
				</ul>
			<?php } else {?>
				<img src="/images/noimage.png"/>
			<?php }?>
		</div>
		<div class="slideshow_block top_block">
			<?php if(isset($images) && count($images)>0) {?> 
				<ul class="images">
					<?php $k=1;?>
					<?php foreach ($images as $simage) {?>
					<li>
						<span>Slide <?php echo $k++?></span><?php echo Html::a('delete',[Url::to([Yii::$app->controller->id."/delete-image", 'id'=>$simage->id])],['class'=>'modal-ajax'])?>
						<?php echo Html::img("/uploads/venue/".$venue->id."/website/".$page->type."/thumb/".$simage->image)?>
						
					</li>
					<?php }?>
				</ul>
			<?php } else {?>
				<img src="/images/noimage.png"/>
			<?php }?>
			<!--h3>Upload Files.</h3-->
			
		</div>
		<div class="upload_block top_block">
			<div class="attach_block">
				<span>Upload Files:</span>
			</div>
			<?php echo $form->field($image, 'file')->fileInput();?>
			 <span>Recommended image size: <span>Height: <?php echo Yii::$app->params['slide']['height']?>px;</span> <span>Width: <?php echo Yii::$app->params['slide']['width']?>px;</span>
		</div>
		<div class="video_block top_block">
			<?php echo $form->field($settings, 'video')->textInput();?>
		</div>
	</div>
	<div class="col-sm-10">
		<iframe width="100%" height="800px" src="/template.html"></iframe>
	</div>
</div>
<?php ActiveForm::end(); ?>