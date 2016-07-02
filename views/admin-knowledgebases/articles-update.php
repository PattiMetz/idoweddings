<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
?>
<?php

$form = ActiveForm::begin([
//	'layout' => 'horizontal',
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
	<h4 class="modal-title"><?php echo Html::encode($this->title); ?></h4>
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
		'class' => 'alert-info',
		'style' => 'display: none'
	],
	'body' => '',
	'closeButton' => false,
]);

?>

<div class="input_wrapper">
	<?php echo $form->field($model, 'knowledgebase_id')->dropDownList($model->knowledgebases, ['class'  => 'form-control chosen-style'])->label(false); ?>

	<?php echo $form->field($model, 'category_id')->textInput()->label(false); ?>
<!--input id="category_id" class="easyui-combotree"-->
	<!--input class="easyui-combotree" value="0" data-options="url:'tree_data1.json',method:'get',required:false" style="width:200px;"-->

</div>
<div class="status_wrapper clearfix">
	<div class="col-lg-6">
		<?php echo $form->field($model, 'title')->textInput(); ?>
	</div>
	<div class="col-lg-6">
		<?php echo $form->field($model, 'status')->radioList($model->statuses, ['unselect' => NULL])->label(false); ?>
	</div>
</div>	

	<?php echo $form->field($model, 'content')->textArea(['rows' => '6']); ?>

<div class="attach_block">
	<span>Attachments:</span>
	<ul id="files" class="attach_list clearfix">
		<?php foreach ($model->files as $file): ?>
			<li id="file_<?php echo $file['id']; ?>">
				<input type="hidden" name="file_ids[]" value="<?php echo $file['id']; ?>">
				<i><?php echo Html::encode($file['name']); ?></i>
				<button class="remove-file" type="button" data-id="<?php echo $file['id']; ?>" title="Delete"></button>
			</li>
		<?php endforeach; ?>
	</ul>
	<a class="btn btn-danger" href="#">Attach file</a>
	<input type="file" id="files-select" name="files[]" size="20" multiple />

</div>

<div class="pseudo_foo">
	<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php

$categories_tree_url = Url::to(['admin-knowledgebases/categories-tree']);
$upload_url = Url::to(['admin-knowledgebases/entries-files-upload']);

$js = <<<EOT
	$('#category_id').combotree({
		animate: true,
		data: {$model->categories_tree_json}
	});

	$('#knowledgebase_id').on('change', function() {
		$('#category_id').combotree({
			url: '{$categories_tree_url}' + '?knowledgebase_id=' + $(this).val()
		});
		$('#category_id').combotree('setValue', '0');
	});

	var xhr;

	$('#files-select').on('change', function() {

		// Disable browse files button
		$('#files-select').attr('disabled', true);

		// Hide alert
		$('.alert-danger').hide();

		// Display uploading status
		$('.alert-info').html('Uploading... <a id="files-abort" href="#">Abort</a>').show();

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
						li+= '<i>' + val + '</i>';
						li+= '<button class="remove-file" type="button" data-id="' + key + '" title="Delete"></button>';
						li+= '</li>';

						$('#files').append(li);

						// Handle remove file
						$('.remove-file').off();
						$('.remove-file').on('click', function() {
							var fileId = $(this).attr('data-id');
							$('#file_' + fileId).remove();
						});
					});
				}

				if (data.alert !== undefined && data.alert != '') {
					// Show alert
					$('.alert-danger').html(data.alert).show();
				}

				if (data.errors !== undefined && !$.isEmptyObject(data.errors)) {
					// Collect errors
					var html = '';
					$.each(data.errors, function(key, val) {
						html+= key + ': ' + val + '<br>';
					});

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
