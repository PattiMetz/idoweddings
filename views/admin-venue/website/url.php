<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use app\models\Currency;
?>
<?php

$form = ActiveForm::begin([
	'layout' => 'horizontal',
	'options' => [
		'class' => 'validate-form'
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
	<h4 class="modal-title">Change venue url address</h4>
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
<?php echo $form->errorSummary($model); ?>

<p>Please indicate your preferred website address for the venue</p>
<div class="form-group">
	<input type="hidden" id="validate" name='validate'/>
	<div class="col-sm-8">
		<?php echo $form->field($model, 'url',['template'=>'http://{input}.idoweddings.com'])->textInput(['class'=>'form-control webaddress_input']); ?>
	</div>
	<div class="col-sm-3">
		<?php echo Html::submitButton('Validate Address', ['class' => 'btn btn-primary','name'=>'validate', 'onclick'=>'$("#validate").val(1)']) ?>
	</div>
</div>
<div class="pseudo_foo">
	<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel','name'=>'save', 'onclick'=>'$("#validate").val(0)']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php 
	$js = <<<EOT
	$('body').on('beforeSubmit', '.validate-form', function() {

		$('.btn-primary', this).attr('disabled', true);

		var container = ($(this).closest('#modal').length > 0) ? '#modal' : '#main';

		var f = $(this);

		$.ajax({
			url: f.attr('action'),
			method: 'POST',
			data: f.serialize(),
			context: this,
			timeout: ajaxTimeout,
			complete: function () {

				$('.btn-primary', this).attr('disabled', false);

			},
			error: function(jqXHR) {

				var message;

				if (jqXHR.status == 0) {

					message = ajaxTimeoutMessage;

				} else {

					message = jqXHR.responseText;

				}

				$(container + ' .alert-danger').html(message).show();

				$('body,html').animate({scrollTop: 0}, 400);

			},
			success: function(data) {

				var success = true;

				if (data.errors !== undefined && !$.isEmptyObject(data.errors)) {

					success = false;
					$(container + ' .alert-success').html('').hide();
					$.each(data.errors, function(key, val) {
						$('.field-' + key).addClass('has-error');
						$('.field-' + key + ' .help-block').html(val);
					});

				}

				if (data.alert !== undefined && data.alert != '') {

					success = false;

					$(container + ' .alert-success').html('').hide();
					
					$(container + ' .alert-danger').html(data.alert).show();

					$('body,html').animate({scrollTop: 0}, 400);

				} else {

					$(container + ' .alert-danger').hide();

				}

				if (success) {

					

					if (data.message !== undefined && data.message != '') {

						$(container + ' .alert-success').html(data.message).show();

						$('body,html').animate({scrollTop: 0}, 400);

						return false;

					} else {
						if (container == '#modal') {

							$('#modal').modal('hide');

						}

						if (data.reload !== undefined) {

							location.reload();

						}
						if (data.pjax_reload !== undefined) {

							$.pjax.reload({
								container: data.pjax_reload
							});

						}
					}
				}
			}
		});

	});
	$('body').on('submit', 'form.validate-form', function(e) {

		e.preventDefault();

	});
EOT;
$this->registerJs($js);