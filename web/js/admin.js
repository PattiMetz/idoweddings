var ajaxTimeout = 5000;
var ajaxTimeoutMessage = 'The request is aborted due to timeout';

$(function() {

	$(document).on('pjax:start', function() {
		$('#preloader').show();
	});

	$(document).on('pjax:end', function() {
		$('#preloader').hide();
	});
	
	$(document).on('ready pjax:end', function() {
		$('select.chosen-style').chosen({disable_search_threshold: 10});
	});

	$( document ).ajaxComplete(function() {
		$('select.chosen-style').chosen({disable_search_threshold: 10});
	});
	
	$('body').on('click', '.modal-ajax', function(e) {

		e.preventDefault();

		$('#main .alert-danger').hide();

		$('#main .alert-success').hide();

		$('#preloader').show();

		var target = $(e.target);

		var url;

		if (target.is('a')) {

			url = $(this).attr('href');

		} else if (target.is('button')) {

			url = $(this).attr('value');

		} else {

			return;

		}

		$('#modal .ajax-content').hide();

		$('#modal .error').hide();

		$('#modal .confirm').hide();

		$('#modal .loading').show();

		$('#modal').modal('show');
		
		$('#modal .modal-dialog').hide();

		$.ajax({
			url: url,
			timeout: ajaxTimeout,
			complete: function () {

				$('#preloader').hide();

				$('#modal .modal-dialog').show();
				
				$('#modal .loading').hide();

			},
			error: function(jqXHR) {

				var message;

				if (jqXHR.status == 0) {

					message = ajaxTimeoutMessage;

				} else {

					message = jqXHR.responseText;

				}

				$('#modal .error .alert-danger').html(message).show();

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

		var container = ($(this).closest('#modal').length > 0) ? '#modal' : '#main';

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

				$(container + ' .alert-danger').html(message).show();

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

					$(container + ' .alert-danger').html(data.alert).show();

				} else {

					$(container + ' .alert-danger').hide();

				}

				if (success) {

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

					if (data.message !== undefined && data.message != '') {

						$(container + ' .alert-success').html(data.message).show();

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

	/***/
	function openPanel() {
		var winWidth = $(window).width();
		if (winWidth > 750) {
			$('.left_panel').hover(function() {
				$(this).addClass('open');
			}, function() {
				$(this).removeClass('open');
			});
		} else {
			$('.left_panel').hover(function() {
				$(this).removeClass('open');
			});
		}
	}
	openPanel();
	
	$('.item_list li').click(function() {
		$(this).addClass('active');
		$('.item_list li').not(this).removeClass('active');
	});
	
	function leftPanelHeight() {
		var winWidth = $(window).width();
		var PanelHeight = $('.main_wrapper').height();
		if (winWidth > 750) {
			$('.left_panel').css('height', PanelHeight).attr('style','');
			$('.item_list').getNiceScroll().remove();
		} else {
			$('.left_panel').css('height', 'auto');
			$('.item_list').niceScroll({cursorcolor:"#fff", cursoropacitymax: "0.7"});	
		}
	}
	leftPanelHeight();
	
	$('.mob_btn').click(function() {
		if ($(this).hasClass('clicked')) {
			$('.left_panel').animate({ width: '256px' }, 500);
			$(this).removeClass('clicked');
		} else {
			$('.left_panel').animate({ width: '0' }, 500);
			$(this).addClass('clicked');
		}
	});
	
	function listMenu() {
		$('.left_panel:not(.open)').find('.item_list li a').click(function() {
			$('.left_panel:not(.open)').css('width', '0');
			$('.mob_btn').addClass('clicked');
		});		
	}
	listMenu();
	
	$(document).click(function(event) {
		var winWidth = $(window).width();
		if (winWidth < 750) {
			if ($(event.target).closest('.left_panel:not(.open)').length == 0 && $(event.target).attr('class') != 'mob_btn') {
				$('.left_panel:not(.open)').animate({ width: '0' }, 500);
				$('.mob_btn').addClass('clicked');
			}
		}
	});
	
	$(document).on('ready pjax:end', function() {
		$('.doc_table td:first-child, .doc_table td:nth-child(2)').hover(function() {
			$('.arrows').hide();
			$(this).parent('tr').find('.arrows').show();
		}, function() {
			$(this).parent('tr').find('.arrows').hide();
		});
	});
	
	$('.select_all').change(function(){
		if($(this).is(':checked'))
			$(this).parent().next().find('input[type=checkbox]').attr('checked', 'checked');
		else
			$(this).parent().next().find('input[type=checkbox]').removeAttr('checked');
	})
	
	$('#venue-types_array label, #venue-vibes_array label, #venue-services_array label').each(function(){
		var flag=0;
		$(this).find('input').click(function(){
			if (flag==0){
				$(this).closest('label').addClass('active');
				flag=1;
			}
			else{
				flag=0;
				$(this).closest('label').removeClass('active');
			}
		});
	});
	
	$('.table_of_pages select').change(function() {
		var optVal = $(this).val();
		if ( optVal == 0 ) {
			$(this).next('.chosen-container').find('.chosen-single').addClass('off');
		}
		else {
			$(this).next('.chosen-container').find('.chosen-single').removeClass('off');
		}
	});
	
	$('.navigation_pos li a').click(function() {
		$('.navigation_pos li a').parent('li').removeClass('active');
		$(this).parent('li').addClass('active');
	});
		
	$(window).resize(function(){
		openPanel();
		leftPanelHeight();		
		listMenu();
	});
	/***/

	/* Fix for CKEditor in a Bootstrap Modal - http://jsfiddle.net/pvkovalev/4PACy/ */
	$.fn.modal.Constructor.prototype.enforceFocus = function () {
		var $modalElement = this.$element;
		$(document).on('focusin.modal', function (e) {
		var $parent = $(e.target.parentNode);
		if ($modalElement[0] !== e.target && !$modalElement.has(e.target).length
			// add whatever conditions you need here
			&&
			!$parent.hasClass('cke_dialog_ui_input_select') && !$parent.hasClass('cke_dialog_ui_input_text')) {
				$modalElement.focus();
			}
		});
	};

	/* Prevent Bootstrap Modal from disappearing when clicking outside or pressing escape */
	$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';
	$.fn.modal.prototype.constructor.Constructor.DEFAULTS.keyboard = false;
	
});
