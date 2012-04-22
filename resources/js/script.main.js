var jsonPROC = {
	retry : function(data,form)
	{
	
		$('.frow').removeClass('error');
		$('.error_message').slideUp('fast');
		
		$.each(data.error,function(i,n){
			
			if($('.'+i).length)
			{
				$('.'+i).addClass('error');
				$('.'+i+' .error_message').slideDown('fast').html(n);
			}
		})
	},
	error2 : function(data,form)
	{
		$('.response',form).html(data.message);
		$(form).trigger('reset');
	},
	forward : function(data,form)
	{
		$(form).trigger('reset');
		location.href=data.url;
	}	
	
}

$(document).ready(function(){
	
	$('.form').live('submit',function(e){
		e.preventDefault();
		
		var form = this;
		var dt = $(form).serializeArray();
		var action = $(form).attr('action');
		
		$('.loaders',form).fadeIn('fast');
		$('button',form).attr('disabled','disabled');
	
		$.ajax({
			url: root + action,
			data: dt,
			type: 'POST',
			dataType: 'json',
			success: function(data)
			{
				try
				{
					if(typeof data.action != "undefined") 
					{
						jsonPROC[data.action](data,form);
						$('.loaders').fadeOut('fast');
						$('button',form).removeAttr('disabled');
						
					}	
				}
				catch(e){
					$('.response').html('Ops cant connecto to the server. Please try again');
					$('button',form).removeAttr('disabled');
				};
			}
			,error: function(xhr)
			{
				try
				{
				$('.loaders').remove();
				}catch(e){};
			}
		})
	})
	
})
