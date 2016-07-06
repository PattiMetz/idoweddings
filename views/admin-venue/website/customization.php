<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\venue\VenueWebsite */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$this->title = 'Website Customization';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile("/js/customization.js",['depends'=>'yii\web\JqueryAsset']);?>
<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'clearfix'],
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-md-4',
            'wrapper' => 'col-md-8',
            'error' => '',
            'hint' => '',
        ]
    ],
]); ?>
    <div class="col-sm-12">
        <div class="col-sm-2">

            <?php echo  Html::dropDownList('page','', $pages,['class'=>'choosen']);?>

            <div class="">
                <div class="list_wrap top_type">
                    <p>Top background </p>
                    <?php echo  Html::radioList('top','slideshow', ['image'=>'image', 'slideshow'=>'slideshow','video'=>'video','none'=>'none'],['id'=>'top']);?>
                </div>
            </div>
            <div class="image_block top_block">
                 <?php if(isset($images) && count($images)>0) {?> 
                    <ul class="docs">
                        <?php foreach ($images as $img) {?>
                        <li>
                            <?php echo Html::img("/uploads/venue/".$venue->id."/website/main/".$img->image)?>
                            <?php echo Html::a('delete',[Url::to([Yii::$app->controller->id."/delete-image", 'id'=>$img->id])],['class'=>'modal-ajax'])?>
                        </li>
                        <?php }?>
                    </ul>
                <?php } else {?>
                    <img src="/images/noimage.png"/>
                <?php }?>
                <!--h3>Upload Files.</h3-->
                <div class="attach_block">
                    <span>Upload Files:</span>
                </div>
                <div>
                    <p>Recommended image size:</p>
                    <p><?php echo Yii::$app->params['slides']['width']?> px Х <?php echo Yii::$app->params['slides']['height']?> px</p>
                </div>
                
                <?php echo $form->field($image, 'file')->fileInput();?>
            </div>
            <div class="slideshow_block top_block">
                <?php if(isset($images) && count($images)>0) {?> 
                    <ul class="docs">
                        <?php foreach ($images as $img) {?>
                         <li>
                            <?php echo Html::img("/uploads/venue/".$venue->id."/website/main/".$img->image)?>
                            <?php echo Html::a('delete',[Url::to([Yii::$app->controller->id."/delete-image", 'id'=>$img->id])],['class'=>'modal-ajax'])?>
                        </li>
                        <?php }?>
                    </ul>
                <?php } else {?>
                    <img src="/images/noimage.png"/>
                <?php }?>
                <!--h3>Upload Files.</h3-->
                <div class="attach_block">
                    <span>Upload Files:</span>
                </div>
                <div>
                    <p>Recommended image size:</p>
                    <p><?php echo Yii::$app->params['slides']['width']?> px Х <?php echo Yii::$app->params['slides']['height']?> px</p>
                </div>
                
                <?php echo $form->field($image, 'file')->fileInput();?>
            </div>
            <div class="video_block top_block">
            </div>
        </div>
        <div class="col-sm-10">
            <iframe width="100%" height="800px" border="0" src="/template.html"></iframe>
        </div>
    </div>
<?php ActiveForm::end(); ?>