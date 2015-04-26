$(document).ready(function(){
	
	$('.word_type_id').change(function(e){
		val  = $(this).val();		
		if(val == 1)
		{
			$('.clsWordCategory').removeClass('hide');
			$('.clsWordCategory').show();
		}
		else
		{	
			$('.clsWordCategory').addClass('hide');
			$('.clsWordCategory').hide();
		}
	});		
	//$('#inputColor').ColorPicker();
	
	/*$('#inputColor').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			$(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});*/


});