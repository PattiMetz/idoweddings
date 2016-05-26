$(function() {

	var ajaxTimeout = 5000;

	var ajaxTimeoutMessage = 'The request is aborted due to timeout';

	$('body').on('click', '.modal-ajax', function() {

		$('#modal .ajax-content').hide();

		$('#modal .error').hide();

		$('#modal .confirm').hide();

		$('#modal .loading').show();

		$('#modal').modal('show');

		$.ajax({
			url: $(this).attr('value'),
			timeout: ajaxTimeout,
			complete: function () {

				$('#modal .loading').hide();

			},
			error: function(jqXHR) {

				var message;

				if (jqXHR.status == 0) {

					message = ajaxTimeoutMessage;

				} else {

					message = jqXHR.responseText;

				}

				$('#modal .error .alert').html(message).show();

				$('#modal .error').show();

			},
			success: function (data) {

				$('#modal .modal-body .ajax-content').html(data).show();

			} 
		});

	});

	$('body').on('click', '.modal-confirm', function() {

		$('#modal .ajax-content').hide();

		$('#modal .error').hide();

		$('#modal .loading').hide();

		var message = $(this).attr('data-message');

		if (message !== undefined) {

			$('#modal .confirm-message').html(message);

		}

		var buttonPrimaryText = $(this).attr('data-button-primary-text');

		if (buttonPrimaryText !== undefined) {

			$('#modal .confirm .btn-primary').html(buttonPrimaryText);

		}

		$('#modal .confirm-form').attr('action', $(this).attr('value'));

		$('#modal .confirm').show();

		$('#modal').modal('show');

	});

	$('body').on('beforeSubmit', '.ajax-form', function() {

		$('.btn-primary', this).attr('disabled', true);

		var $form = $(this);

		$.ajax({
			url: $form.attr('action'),
			method: 'POST',
			data: $form.serialize(),
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

				$('.alert').html(message).show();

			},
			success: function(data) {

				var success = true;

				if (data.errors !== undefined && !$.isEmptyObject(data.errors)) {

					success = false;

					$.each(data.errors, function(key, val) {
						$('.field-' + key).addClass('has-error');
						$('.field-' + key + ' .help-block').html(val);
					});

				}

				if (data.alert !== undefined && data.alert != '') {

					success = false;

					$('.alert').html(data.alert).show();

				} else {

					$('.alert').hide();

				}

				if (success) {

					$('#modal').modal('hide');

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

		});

	});

	$('body').on('submit', 'form.ajax-form', function(e) {

		e.preventDefault();

	});
 
	$('body').on('click', '#modal .btn-cancel', function() {

		$('#modal').modal('hide');

	});

	$('#modal .confirm-form').on('submit', function() {

		$('#modal').modal('hide');

	});

});
