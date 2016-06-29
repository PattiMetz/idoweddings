$(document).ready(function(){
	$('.add_page').click(function(){
		var html = '<div class="pseudo_head"><h4 class="modal-title">Add page</h4></div>'+$('#page_name').html();
		
		$('#modal .modal-body').html(html).show();
	});	
})
