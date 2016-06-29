<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\color\ColorInput;
/* @var $this yii\web\View */
/* @var $model app\models\venue\VenueWebsite */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$this->registerJs("
    $('.navigation_pos li a').click(function(){
        $('#venuewebsite-navigation_pos').val($(this).attr('data-value'));
        return false;
    }
        )
    ",4);
?>
<div class="col-sm-12">
    <div class="venue-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <div class="venue-website-form">

            <?php
            $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'options' => ['enctype' => 'multipart/form-data'],
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
            <?php echo $form->errorSummary($model); ?>
            <div class="col-sm-6">
                <div>Venue Website</div>
                <div class="block">
                    <div class="col-sm-9">http://<?= $model->url ?>.idoweddings.com</div>
                    <div class="col-sm-3">
                        <?php echo Html::a('Change Address', Url::to([Yii::$app->controller->id.'/editurl','id'=>$model->id]),['class' => 'btn btn-primary modal-ajax']) ?>
                        <br/>
                        <?php echo Html::Button('View website', ['class' => 'btn btn-cancel','onclick'=>'$(this).location.href="http://'.$model->url.'.idoweddings.com"']) ?>
                    </div>
                </div>
                

                
                <div class="title">Website pages</div>
                <div class="block">
                    <table>
                        <tr>
                            <td colspan="3">
                                <?php echo Html::a('Add page', Url::to([Yii::$app->controller->id.'/page-update','venue_id'=>$model->venue_id]),['class' => 'btn btn-primary modal-ajax']) ?>
                            </td>
                        </tr>
                       

                    
                        <?php foreach($pages as $page):?>
                             <tr>
                                <td>
                                   
                                    <span><?=$page->name?></span>
                                </td>
                                <td>
                                    <?php if($page->type!='main'):?>
                                        <?php echo $form->field($page, '['.$page->id.']active',['template'=>'{input}'])->dropDownList(['0'=>'Off', '1'=>'On'],['style'=>'width:80px']);?>
                                    <?endif;?>
                                </td>
                                <td>
                                <?php if($page->type!='main'):?>
                                        <?php echo Html::a('Rename', Url::to([Yii::$app->controller->id.'/page-update','id'=>$page->id]),['class' => 'btn btn-primary modal-ajax']) ?>
                                    <?endif;?>
                                </td>
                                <td>
                                    <?php if($page->type=='custom'):?>
                                        <?php echo Html::a('Delete', Url::to([Yii::$app->controller->id.'/page-delete','id'=>$page->id]), ['class' => 'btn btn-primary modal-ajax']) ?>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div>    
            <div class="col-sm-6">
                <div class="title">Main Fonts and colors</div>
                <div class="block">
                    <?php $settings = $model->settings;?>
                    <table class="settings_table">
                        <tr>
                            <th width="25%"></th>
                            <th width="35%">Font name and size</th>
                            <th width="20%">Color</th>
                            <th width="20%">Background</th>
                        </tr>
                        <tr>
                            <td>Titles</td>
                            <td>
                                <?php echo Html::dropDownList('settings[title][font]', $settings['title']['font'], $fonts,['class'  => 'form-control','prompt' => 'fontname']);?>
                                <?php echo Html::dropDownList('settings[title][size]', $settings['title']['size'], $sizes,['class'  => 'form-control','prompt' => 'size']);?>
                            </td>
                            <td>
                                <?php 
                                echo ColorInput::widget([
                                    'name' => 'settings[title][color]',
                                    'value' => $settings['title']['color'],
                                ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Subtitles</label>
                            <td>
                                <?php echo Html::dropDownList('settings[subtitle][font]', $settings['subtitle']['font'], $fonts,['class'  => 'form-control','prompt' => 'fontname']);?>
                                <?php echo Html::dropDownList('settings[subtitle][size]', $settings['subtitle']['size'], $sizes,['class'  => 'form-control','prompt' => 'size']);?>
                            </td>
                            <td>
                                <?php 
                                echo ColorInput::widget([
                                    'name' => 'settings[subtitle][color]',
                                    'value' => $settings['subtitle']['color'],
                                ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Main Content</td>
                            <td>
                                <?php echo Html::dropDownList('settings[content][font]', $settings['content']['font'], $fonts,['class'  => 'form-control','prompt' => 'fontname']);?>
                                 <?php echo Html::dropDownList('settings[content][size]', $settings['content']['size'], $sizes,['class'  => 'form-control','prompt' => 'size']);?>
                            </td>
                            <td>
                                <?php 
                                echo ColorInput::widget([
                                    'name' => 'settings[content][color]',
                                    'value' => $settings['content']['color'],
                                ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Main navigation</td>
                            <td>
                                <?php echo Html::dropDownList('settings[menu][font]', $settings['menu']['font'], $fonts,['class'  => 'form-control','prompt' => 'fontname']);?>
                                <?php echo Html::dropDownList('settings[menu][size]', $settings['menu']['size'], $sizes,['class'  => 'form-control','prompt' => 'size']);?>
                            </td>
                            <td>
                                <?php 
                                echo ColorInput::widget([
                                    'name' => 'settings[menu][color]',
                                    'value' => $settings['menu']['color'],
                                ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Submenu</td>
                            <td>
                                <?php echo Html::dropDownList('settings[submenu][font]', $settings['submenu']['font'], $fonts,['class'  => 'form-control','prompt' => 'fontname']);?>
                                <?php echo Html::dropDownList('settings[submenu][size]', $settings['submenu']['size'], $sizes,['class'  => 'form-control','prompt' => 'size']);?>
                            </td>
                            <td>
                                <?php 
                                echo ColorInput::widget([
                                    'name' => 'settings[submenu][color]',
                                    'value' => $settings['submenu']['color'],
                                ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Button "Let's say IDO here"</td>
                            <td>
                                <?php echo Html::dropDownList('settings[button][font]', $settings['button']['font'], $fonts,['class'  => 'form-control','prompt' => 'fontname']);?>
                                <?php echo Html::dropDownList('settings[button][size]', $settings['button']['size'], $sizes,['class'  => 'form-control','prompt' => 'size']);?>
                            </td>
                            <td>
                                <?php 
                                echo ColorInput::widget([
                                    'name' => 'settings[button][color]',
                                    'value' => $settings['button']['color'],
                                ]);
                                ?>
                            </td>
                            <td>
                                <?php 
                                echo ColorInput::widget([
                                    'name' => 'settings[button][background]',
                                    'value' => $settings['button']['background'],
                                ]);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Venue name</td>
                            <td>
                                <?php echo Html::dropDownList('settings[name][font]', $settings['name']['font'], $fonts,['class'  => 'form-control','prompt' => 'fontname']);?>
                                <?php echo Html::dropDownList('settings[name][size]', $settings['name']['size'], $sizes,['class'  => 'form-control','prompt' => 'size']);?>
                            </td>
                            <td>
                                <?php 
                                echo ColorInput::widget([
                                    'name' => 'settings[name][color]',
                                    'value' => $settings['name']['color'],
                                ]);
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div class="title">Display venue name</div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'logo_type',['template'=>"{input}{hint}\n\t{error}"])->radioList(['Venue name','Featured venue name','Logo']) ?>
                </div>
                <div class="col-sm-6">
                     <?=$form->field($model, 'logo_file')->fileInput();?>
                </div>
                <hr/>
                <div style="float:left;width:100%">
                    <div class="title">Main Navigation</div>

                    <?= $form->field($model, 'navigation_pos')->hiddenInput()->label(false) ?>
                    <div class="title">Allignment</div>
                    <ul class="navigation_pos">
                        <li><?php echo Html::a(Html::img(Url::to('/images/m_bottom.png')).'<br/>top', '#', ['data-value'=>0]);?></li>
                        <li><?php echo Html::a(Html::img(Url::to('/images/m_bottom.png')).'<br/>bottom', '#', ['data-value'=>1]);?></li>
                        <li><?php echo Html::a(Html::img(Url::to('/images/m_bottom.png')).'<br/>left', '#', ['data-value'=>2]);?></li>
                        <li><?php echo Html::a(Html::img(Url::to('/images/m_bottom.png')).'<br/>right', '#', ['data-value'=>3]);?></li>
                    </ul>
                </div>
            </div>
    </div>
    
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn-danger btn']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
