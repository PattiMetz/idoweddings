$(document).on('ready pjax:end', function() {
		show_top_block();
		$('#page').change(function(){
			var href = location.href;
			var matches = href.match(/page_id=(\d{1,})/);
			if(matches && matches[1])
				location.href = href.replace('page_id=' + matches[1], 'page_id='+$(this).val());
			else
				location.href = href + '&page_id='+$(this).val();
		})
	});
$('#top input[type=radio]').on('change',show_top_block);
function show_top_block() {
	$('.top_block').hide();
	$('.' + $('#top input[type=radio]:checked').val() + '_block').show();
	if($('#top input[type=radio]:checked').val() == 'slideshow' || $('#top input[type=radio]:checked').val() == 'image') 
		$('.upload_block').show();
}