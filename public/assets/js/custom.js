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

});