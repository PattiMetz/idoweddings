<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\widgets\breadcrumbs;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $model app\models\venue\VenueLocation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="venue-location-form">

    <?php 
    	$upload_dir = "/uploads/venue/".$model->group->venue_id."/location";
    	$this->title = $model->group->venue->name;
		$this->params['breadcrumbs'][] = ['label' => 'Venues', 'url' => ['admin-venue/index']];
		$this->params['breadcrumbs'][] = $this->title;

    	$form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
           
        ]);
    ?>

    <div class="clerafix">

    	<?php echo Breadcrumbs::widget([
             'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
          ]) ?>

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
    <div class="list_wrap">    
    	<p><span>Group of Locations</span><?php echo $model->group->name?></p>
    	<div class="col-sm-12">
	    	<?php echo $form->field($model, 'group_id',['template'=>'{input}'])->hiddenInput() ?>
	    	<div class="col-sm-6">
	    		<?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	    	</div>
	    	<div class="col-sm-6">
	    		<?php echo $form->field($model, 'guest_capacity')->textInput(['maxlength' => true]) ?>
	    	</div>
	    </div>

    </div>
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
    
    <?php echo $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'clientOptions' => [
			'customConfig' => '/js/ckeditor/config.js',
        ]
    ]) ?>

   

    <?php if($model->id) {?>
	    <div class="attach_block">
			<span>Attachments:</span>
			<ul id="files" class="attach_list clearfix">
				 <?php if(isset($images) && count($images)>0) {?> 
			        <ul class="docs">
			            <?php foreach ($images as $image) {?>
			            <li>
			                <?=Html::img($upload_dir . "/thumb/".$image->id . '.' . end(explode('.', $image->image)))?>
			                <?=Html::a('delete',[Url::to([Yii::$app->controller->id."/delete-image", 'id'=>$image->id])],['class'=>'modal-ajax'])?>
			            </li>
			            <?php }?>
			        </ul>
			    <?php }?>
			</ul>
			<a class="btn btn-danger" href="#">Attach file</a>
			<input type="file" id="files-select" name="files[]" size="20" multiple />

		</div>
	<?php }?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$upload_url = Url::to(['admin-venue-location/files-upload', 'location_id' => $model->id]);
$delete_url = Url::to([Yii::$app->controller->id."/delete-image"]);
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

						$('#files').append(li);

						
					});
				}

				if (data.alert !== undefined && data.alert != '') {
					// Show alert
					$('.alert-danger').html(data.alert).show();
					$('body,html').animate({scrollTop: 0}, 400);
				}

				if (data.errors !== undefined && !$.isEmptyObject(data.errors)) {
					// Collect errors
					var html = '';
					$.each(data.errors, function(key, val) {
						html+= key + ': ' + val + '<br>';
					});
					$('body,html').animate({scrollTop: 0}, 400);
					// Show alert
					$('.alert-danger').html(html).show();
				}

			}
		});
	});

	// Handle remove file
	$('.remove-file').on('click', function() {
		var fileId = $(this).attr('data-id');
		$('#file_' + fileId).remove();
	});
EOT;

$this->registerJS($js);