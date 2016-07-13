$(document).on('ready pjax:end', function() {
	alert('pjax end');
	get_menu($('.grid-view table tbody tr:first-child').attr('data-key'));
	$('.grid-view table tbody tr:first-child').addClass('active');
	$('.multiple').multipleSelect({});
	$('.grid-view table tr').on('click',function(){
		$('.grid-view table tr').removeClass('active');
		$(this).addClass('active');
		get_menu($(this).attr('data-key'));
	})
});
function get_menu(id) {
	
	
	$.ajax({
		url:'".Url::to(["admin-venue/menu"])."',
		method:'POST',
		data:{'id':id},
		success:function(data){
			$('.venue_list').html(data);
		}

	})
}