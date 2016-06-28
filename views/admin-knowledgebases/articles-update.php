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
		'id' => 'files-status-row',
		'class' => 'alert-info',
		'style' => 'display: none'
	],
	'body' => 'Uploading... <a id="abort" href="#">Abort</a>',
	'closeButton' => false,
]);

?>

<?php

echo Alert::widget([
	'options' => [
		'id' => 'files-alert',
		'class' => 'alert-danger',
		'style' => 'display: none'
	],
	'body' => '',
	'closeButton' => false,
]);

?>

<div class="input_wrapper">
	<?php echo $form->field($model, 'knowledgebase_id')->dropDownList($model->knowledgebases); ?>

	<?php echo $form->field($model, 'category_id')->textInput(); ?>
<!--input id="category_id" class="easyui-combotree"-->
	<!--input class="easyui-combotree" value="0" data-options="url:'tree_data1.json',method:'get',required:false" style="width:200px;"-->

	<?php echo $form->field($model, 'title')->textInput(); ?>
</div>

<?php echo $form->field($model, 'status')->radioList($model->statuses, ['unselect' => NULL])->label(false); ?>

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

		// Hide alert row
		$('#files-alert').hide();

		// Display uploading status row
		$('#files-status-row').show();

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
			complete: function () {
				// Hide status row
				$('#files-status-row').hide();

				// Clear file input
				$('#files-select').val('');

				// Enable file browse button
				$('#files-select').attr('disabled', false);
			},
			success: function(data){
				if (data.list !== undefined && !$.isEmptyObject(data.list)) {
					$.each(data.list, function(key, val) {
						var li = '<li id="file_' + key + '">';
						li+= '<input type="hidden" name="file_ids[]" value="' + key + '">';
						li+= '<i>' + val + '</i>';
						li+= '<button class="remove-file" type="button" data-id="' + key + '" title="Delete"></button>';
						li+= '</li>';

						$('#files').append(li);

						$('.remove-file').off();
						$('.remove-file').on('click', function() {
alert(2);
							var fileId = $(this).attr('data-id');
							$('#file_' + fileId).remove();
						});
					});
				}

				if (data.alert !== undefined && data.alert != '') {
					$('#files-alert').html(data.alert);
					$('#files-alert').show();
				}

				if (data.errors !== undefined && !$.isEmptyObject(data.errors)) {
					var html = '';
					$.each(data.errors, function(key, val) {
						html+= key + ': ' + val + '<br>';
					});

					$('#files-alert').html(html);
					$('#files-alert').show();
				}

			}
		});
	});

	$('#abort').on('click', function(e) {
alert(3);
		// Prevent default action
		e.preventDefault();

		// Abort the request
		xhr.abort();
	});

	$('.remove-file').on('click', function() {
alert(1);
		var fileId = $(this).attr('data-id');
		$('#file_' + fileId).remove();
	});
EOT;

$this->registerJS($js);
