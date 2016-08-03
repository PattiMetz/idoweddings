<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\color\ColorInput;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $model app\models\venue\VenueWebsite */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$this->title = 'Website Customization';
$this->params['breadcrumbs'][] = ['label' => 'Venues', 'url' => ['admin-venue/index'], 'data-pjax'=>0];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
    $('.navigation_pos li a').click(function(){
        $('#venuewebsite-navigation_pos').val($(this).attr('data-value'));
        return false;
    })
	$('.table_of_pages select').change(function() {
		setOffStyle($(this));
	});
	function setOffstyle(obj) {
		var optVal = obj.val();
		if ( optVal == 0 ) {
			obj.next('.chosen-container').find('.chosen-single').addClass('off');
		}
		else {
			obj.next('.chosen-container').find('.chosen-single').removeClass('off');
		}
	}
	$(document).on('ready pjax:end', function() {
		
		$('.table_of_pages select').each(function(){
			setOffstyle($(this));	
		})
	})
	
	
	
    ",4);
?>
<?php
    $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => ['enctype' => 'multipart/form-data'],
        'options' => [
            'class' => 'ajax-form clearfix'
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
	<div class="sett_panel clerafix">

    	<?php echo Breadcrumbs::widget([
             'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
             'homeLink' => false
          ]) ?>
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save Settings', ['class' => 'btn-primary btn']) ?>  
		
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
	<?php
		echo Alert::widget([
			'options' => [
				'class' => 'alert-success',
				'style' => ($message == '') ? 'display: none' : ''
			],
			'body' => $message,
			'closeButton' => false,
		]);

		?>	
<div class="col-lg-12 no_padding">
    <div class="venue-index">
    	<div class="venue-website-form clearfix">
            <?php echo $form->errorSummary($model); ?>
            <div class="col-lg-6">
				<div class="sett_block_wrap clearfix">
					<p>Venue Website</p>
					<div class="dis_flex">
						<span class="custom_url">http://<?php echo $model->url ?>.idoweddings.com</span>
						<div class="sett_btns_box">
							<?php echo Html::a('<i class="glyphicon glyphicon-pencil"></i> Change Address', Url::to([Yii::$app->controller->id.'/editurl','id'=>$model->id]),['class' => 'btn btn-primary modal-ajax']) ?>
							<br/>
							<?php echo Html::Button('<i class="glyphicon glyphicon-eye-open"></i> View website', ['class' => 'btn btn-cancel','onclick'=>'$(this).location.href="http://'.$model->url.'.idoweddings.com"']) ?>
						</div>
					</div>
                </div>

                
				<div class="sett_block_wrap clearfix">
					<p>Website pages</p>
					<table class="table table-condensed table-responsive table_of_pages">
						<tr>
							<td colspan="3">
								<?php echo Html::a('Add page', Url::to([Yii::$app->controller->id.'/page-update','venue_id'=>$model->venue_id]),['class' => 'btn btn-danger modal-ajax']) ?>
								<a class="btn btn-cancel"><i class="glyphicon glyphicon-eye-open"></i> Go to Website Editor</a>
							</td>
						</tr>
					   				
						<?php foreach($pages as $page):?>
							 <tr>
								<td>
								   
									<span><?php echo $page->name?></span>
								</td>
								<td>
									<?php if($page->type != 'main'):?>
										<?php echo $form->field($page, '['.$page->id.']active',['template'=>'{input}'])->dropDownList(['0'=>'Off', '1'=>'On'],['class' => ('chosen-style'.(($page->active!=1)?' Off':''))]);?>
									<?php endif;?>
								</td>
								<td>
								<?php if($page->type != 'main'):?>
										<?php echo Html::a('<i class="glyphicon glyphicon-pencil"></i> Rename', Url::to([Yii::$app->controller->id.'/page-update','id'=>$page->id]),['class' => 'btn btn-primary modal-ajax']) ?>
									<?php endif;?>
								</td>
								<td>
									<?php if($page->type == 'custom'):?>
										<?php echo Html::a('Delete', Url::to([Yii::$app->controller->id.'/page-delete','id'=>$page->id]), ['class' => 'btn btn-primary modal-ajax']) ?>
									<?php endif;?>
								</td>
							</tr>
						<?php endforeach;?>
						
					</table>
				</div>
            </div>    
            <div class="col-lg-6">

				<div class="sett_block_wrap clearfix">
					<p>Main Fonts and colors</p>
					<?php $settings = $model->settings;?>
					<table class="table table-bordered table-condensed table-responsive settings_table">
						<tr>
							<th></th>
							<th>Font name and size</th>
							<th>Color</th>
							<th>Background</th>
						</tr>
						<tr>
							<td>Titles</td>
							<td>
								<?php echo Html::dropDownList('settings[title][font]', $settings['title']['font'], $fonts,['class'  => 'form-control chosen-style','prompt' => 'Fontname']);?>
								<?php echo Html::dropDownList('settings[title][size]', $settings['title']['size'], $sizes,['class'  => 'form-control chosen-style','prompt' => 'Size']);?>
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
								<?php echo Html::dropDownList('settings[subtitle][font]', $settings['subtitle']['font'], $fonts,['class'  => 'form-control chosen-style','prompt' => 'Fontname']);?>
								<?php echo Html::dropDownList('settings[subtitle][size]', $settings['subtitle']['size'], $sizes,['class'  => 'form-control chosen-style','prompt' => 'Size']);?>
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
								<?php echo Html::dropDownList('settings[content][font]', $settings['content']['font'], $fonts,['class'  => 'form-control chosen-style','prompt' => 'Fontname']);?>
								 <?php echo Html::dropDownList('settings[content][size]', $settings['content']['size'], $sizes,['class'  => 'form-control chosen-style','prompt' => 'Size']);?>
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
								<?php echo Html::dropDownList('settings[menu][font]', $settings['menu']['font'], $fonts,['class'  => 'form-control chosen-style','prompt' => 'Fontname']);?>
								<?php echo Html::dropDownList('settings[menu][size]', $settings['menu']['size'], $sizes,['class'  => 'form-control chosen-style','prompt' => 'Size']);?>
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
								<?php echo Html::dropDownList('settings[submenu][font]', $settings['submenu']['font'], $fonts,['class'  => 'form-control chosen-style','prompt' => 'Fontname']);?>
								<?php echo Html::dropDownList('settings[submenu][size]', $settings['submenu']['size'], $sizes,['class'  => 'form-control chosen-style','prompt' => 'Size']);?>
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
								<?php echo Html::dropDownList('settings[button][font]', $settings['button']['font'], $fonts,['class'  => 'form-control chosen-style','prompt' => 'Fontname']);?>
								<?php echo Html::dropDownList('settings[button][size]', $settings['button']['size'], $sizes,['class'  => 'form-control chosen-style','prompt' => 'Size']);?>
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
								<?php echo Html::dropDownList('settings[name][font]', $settings['name']['font'], $fonts,['class'  => 'form-control chosen-style','prompt' => 'Fontname']);?>
								<?php echo Html::dropDownList('settings[name][size]', $settings['name']['size'], $sizes,['class'  => 'form-control chosen-style','prompt' => 'Size']);?>
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
                <div class="sett_block_wrap outer_nav_block clearfix">
                    <p>Main Navigation</p>

                    <?php echo $form->field($model, 'navigation_pos')->hiddenInput()->label(false) ?>
					<div class="dis_flex">
						<span>Allignment</span>
						<ul class="navigation_pos">
							<li class="active"><?php echo Html::a(Html::img(Url::to('/images/venue/menu_top.png')).'<br/>Top', '#', ['data-value'=>0]);?></li>
							<li><?php echo Html::a(Html::img(Url::to('/images/venue/menu_bottom.png')).'<br/>Bottom', '#', ['data-value'=>1]);?></li>
							<li><?php echo Html::a(Html::img(Url::to('/images/venue/menu_left.png')).'<br/>Left', '#', ['data-value'=>2]);?></li>
							<li><?php echo Html::a(Html::img(Url::to('/images/venue/menu_right.png')).'<br/>Right', '#', ['data-value'=>3]);?></li>
							<li><?php echo Html::a(Html::img(Url::to('/images/venue/menu_drop.png')).'<br/>Dropdown', '#');?></li>
						</ul>
					</div>
                </div>
				<div class="sett_block_wrap outer_sett_block clearfix">
					<p>Display venue name</p>
					<div class="radiolist">
						<?php echo $form->field($model, 'logo_type',['template'=>"{input}{hint}\n\t{error}"])->radioList(['Venue name','Featured venue name','Logo']) ?>
					</div>
					<div>
						 <?php echo $form->field($model, 'logo_file')->fileInput();?>
						 <span>Recommended image size: <span>MAX height: 110px;</span> <span>MAX width: 540px;</span></span>
						 <button class="btn btn-primary">Choose image from Media Gallery</button>
					</div>
				</div>
            </div>
		</div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
