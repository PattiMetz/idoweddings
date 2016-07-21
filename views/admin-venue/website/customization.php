<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\breadcrumbs;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
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
            'class' => 'clearfix ajax-form cust_form'
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
	<?php echo Breadcrumbs::widget([
         'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      ]) ?>
	<div class="form-group">
        <?php echo Html::submitButton('Update', ['class' => 'btn btn-success cust_submit']) ?>
    </div>
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
<?php

	echo Alert::widget([
		'options' => [
			'class' => 'alert-info',
			'style' => 'display: none'
		],
		'body' => '',
		'closeButton' => false,
	]);

	?>
<?php echo $form->errorSummary($settings); ?>
<?php echo $form->field($settings, 'slogan', ['template' => '{input}'])->hiddenInput();?>
<?php echo $form->field($settings, 'venue_name', ['template' => '{input}'])->hiddenInput();?>
<?php echo $form->field($settings, 'h1', ['template'=>'{input}'])->hiddenInput();?>
<?php echo $form->field($settings, 'h2', ['template'=>'{input}'])->hiddenInput();?>
<?php echo $form->field($settings, 'text1', ['template'=>'{input}'])->hiddenInput();?>
<?php echo $form->field($settings, 'text2', ['template'=>'{input}'])->hiddenInput();?>
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
						<?php echo Html::img(Yii::getAlias('@web')."/uploads/venue/".$venue->id."/website/".$page->type."/thumb/".$simage->id.'.'.end(explode('.', $simage->image)))?>
						
						<?php echo Html::button('Choose image from Media Gallery', ['class'=>'btn btn-primary']);?>
					</li>
					<?php break;?>
					<?php }?>
				</ul>
			<?php } else {?>
				<img src="/images/noimage.png"/>
			<?php }?>
		</div>

		<div class="slideshow_block top_block">
			<div><?php echo Html::button('Add slide', ['class'=>'add_slide']);?></div>
			<ul class="images">
			<?php $k = 1;?>	
			<?php if(isset($images) && count($images)>0) {?> 
					<?php foreach ($images as $simage) {?>
					<li>
						<span>Slide <?php echo $k++?></span><?php echo Html::a('delete',[Url::to([Yii::$app->controller->id."/delete-image", 'id'=>$simage->id])],['class'=>'modal-ajax'])?>
						<?php echo Html::img(Yii::getAlias('@web')."/uploads/venue/".$venue->id."/website/".$page->type."/thumb/".$simage->id.'.'.end(explode('.', $simage->image)))?>
						<?php echo Html::button('Choose image from Media Gallery', ['class'=>'btn btn-primary']);?>
					</li>
					<?php }?>
				
			<?php }?>
			<?php //Default slideshow images
				$c = explode(',', $settings->default_slideshow);
				if(count($c) > 0) {
					foreach($c as $i) {?>
					<li data-id="<?php echo $i?>">
						<span>Slide <?php echo $k++?></span><?php echo Html::a('delete','#', ['class' => 'delete-default'])?>
						<?php echo Html::img(Yii::getAlias('@web')."/images/venue/default/thumb/venue_top".$i.".jpg")?>
						<?php echo Html::button('Choose image from Media Gallery', ['class'=>'btn btn-primary']);?>
					</li>
				<?php }
			}?>
			<!--h3>Upload Files.</h3-->
			</ul>
		</div>

		<?php /*** Временный блок для загрузки файлов. Уберется, когда будет готова media gallery****/?>
		<div class="upload_block top_block">
			<span>Recommended image size: <span>Height: <?php echo Yii::$app->params['slide']['height']?>px;</span> <span>Width: <?php echo Yii::$app->params['slide']['width']?>px;</span>
			<div class="attach_block" style="width:250px;float:left">
				<a class="btn btn-danger" href="#">Attach file</a>
				<input type="file" id="files-select" name="files[]" size="20" multiple />
			</div>
		</div>

		<div class="video_block top_block">
			<?php echo $form->field($settings, 'video')->textInput();?>
		</div>
		<div class="locations">
			<?php foreach($venue->locationgroups as $group) {
				echo Html::checkbox('location_group', ['label' => $group->name]);
				echo $form->field($page, 'locations_array', ['template'=>"{input}{hint}\n\t{error}"])->checkBoxList(ArrayHelper::map($group->locations, 'id', 'name'));
			}?>
			
		</div>
	</div>
	<div class="col-sm-10">

		<iframe id="contentBlock" width="100%" height="1020px" style="border:none" src="<?php echo Url::to(['admin-venue-customization/preview-template', 'page_id' => $page->id])?>"></iframe>
	</div>
</div>
<?php ActiveForm::end(); ?>
<?php
$upload_dir = Yii::getAlias('@web').'/uploads/venue/'.$page->venue_id.'/website/'.$page->type.'/';
$upload_url = Url::to(['admin-venue-customization/files-upload', 'page_id' => $page->id]);
$delete_url = Url::to(['admin-venue-customization/files-delete']);

$js = <<<EOT
	var xhr;

	$('#files-select').on('change', function() {

		// Disable browse files button
		$('#files-select').attr('disabled', true);

		// Hide alert
		$('.alert-danger').hide();

		// Display uploading status
		$('.alert-info').html('Uploading... <a id="files-abort" href="#">Abort</a>').show();
		$('body,html').animate({scrollTop: 0}, 400);
		// Handle upload abort
		$('#files-abort').on('click', function(e) {
			// Prevent default action
			e.preventDefault();

			// Abort the request
			xhr.abort();
		});

		// Create a new FormData object
		var data = new FormData();

		// Loop through each of the selected files
		jQuery.each(jQuery('#files-select')[0].files, function(i, file) {
			// Add the file to the request
			data.append('files[]', file);
		});

		xhr = jQuery.ajax({
			url: '{$upload_url}',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			complete: function() {
				// Hide uploading status
				$('.alert-info').hide();

				// Clear file input
				$('#files-select').val('');

				// Enable file browse button
				$('#files-select').attr('disabled', false);
			},
			error: function(jqXHR) {
				var message;
				if (jqXHR.status == 0) {
					message = 'The request is aborted';
				} else {
					message = jqXHR.responseText;
				}
				$('.alert-danger').html(message).show();
			},
			success: function(data) {
				if (data.list !== undefined && !$.isEmptyObject(data.list)) {
					$.each(data.list, function(key, val) {
						// Append uploaded file
						var li = '<li id="file_' + key + '">';
						li+= '<input type="hidden" name="file_ids[]" value="' + key + '">';
						li+= '<img src=\"{$upload_dir}/thumb/' + val + '\">';
						li+= '<a href=\"{$delete_url}?id=' + key + '\" class=\"modal-ajax\">Delete</a>';
						li+= '</li>';
						$('.images li:last-child img').attr('src', '{$upload_dir}/thumb/' + val);
						$('.images li:last-child a').attr('href', '{$delete_url}?id=' + key);
						$('.images li:last-child a').addClass('modal-ajax');

					});
				}

				if (data.alert !== undefined && data.alert != '') {
					// Show alert
					$('.alert-danger').html(data.alert).show();
					//$('body,html').animate({scrollTop: 0}, 400);
				}

				if (data.errors !== undefined && !$.isEmptyObject(data.errors)) {
					// Collect errors
					var html = '';
					$.each(data.errors, function(key, val) {
						html+= key + ': ' + val + '<br>';
					});
					//$('body,html').animate({scrollTop: 0}, 400);
					// Show alert
					$('.alert-danger').html(html).show();
				}

			}
		});
	});

	
EOT;

$this->registerJS($js);