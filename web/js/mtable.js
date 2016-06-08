alert('start');
$('.calculate_currency').on('keyup', function(){
	var rate = parseFloat($('#currency-rate').val());
	var buffer = parseFloat($('#currency-buffer').val());
	var control_amount = parseFloat($('#currency-control_amount').val());
	if(rate && buffer && control_amount) {
		$('.usd_amount').html(eval(rate*control_amount).toFixed(2));
		$('.usd_buffer_amount').html(eval(rate*control_amount*buffer).toFixed(2));
	}
})