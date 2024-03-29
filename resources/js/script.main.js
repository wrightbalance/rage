var jsonPROC = {
	retry : function(data,form)
	{
	
		$('.response',form).html(data.message);
		/*
		$('.frow').removeClass('error');
		$('.error_message').slideUp('fast');
		
		$.each(data.error,function(i,n){
			
			if($('.'+i).length)
			{
				$('.'+i).addClass('error');
				$('.'+i+' .error_message').slideDown('fast').html(n);
			}
		})
		*/
	},
	error2 : function(data,form)
	{
		$('.response',form).html(data.message);
		$(form).trigger('reset');
	},
	forward : function(data,form)
	{
		$(form).trigger('reset');
		$('.response',form).html('<div class="res_message">'+data.message+'</div>');
		
		setTimeout(function(){
			location.href=data.url;	
		},500)
		
	}	
	
}

$(document).ready(function(){
	
	$('.form').live('submit',function(e){
		e.preventDefault();
		
		var form = this;
		var dt = $(form).serializeArray();
		var action = $(form).attr('action');
		
		/*
		
		$('.loaders',form).fadeIn('fast');
		$('button',form).attr('disabled','disabled');

		if($('.fields',form).length)
		{
			$('.fields',form).hide();
			$('.response',form).html('<div style="margin-top: 10px; margin-left: 15px;">Processing, please wait...</div>');
		}
		*/
		$('.response',form).html('<div class="res_message loader">Loading...</div>');
		$('.fields',form).hide();
		
		
		$.ajax({
			url: action,
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
	
	$('.showform').live('click',function(e){
		e.preventDefault();
		$('.response').empty();
		$('.fields').show();

	})
	
	$('.main_nav a').click(function(e){
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
	})
	
})

$('.retryform').live('click',function(){
	$('.fields').show();
	$('.response').empty();
})

