$(document).ready(function(){
	
	$('.main-nav li a').live('click',function(e){
		e.preventDefault();
		var uri = $(this).attr('href');

		if(uri == "/account/signout")
			location.href = uri;
		
		$('.nav li').removeClass('active');
		$('.nav li a i').removeClass('icon-white');
		
		$(this).parent().addClass('active');
		$('i',this).addClass('icon-white');
		
		
		if(typeof history.pushState != "undefined")
		{
			if(location.pathname === uri) return false;
			$('*').addClass('wait');
			window.history.pushState(uri,uri,uri);
			$('#loadcontent').load(uri,function(){
				$('*').removeClass('wait');
				
				getOnline();
			});
		}
	})
	
	$('.tab li a').live('click',function(e){
		e.preventDefault();
		
		var idx = $(this).parent().index();
		
		$('.tab li').removeClass('active');
		$(this).parent().addClass('active');
		
		$('.tpane').siblings().removeClass('pactive');
		$('.tpane').eq(idx).addClass('pactive');
	})
	
	$('textarea.message').live('focus',function(){
		if($(this).val() == "")
		{
			$('.stream_box_action').slideDown('fast');
			$(this).css('height',50);
		}
	}).live('blur',function(){
		if($(this).val() == "")
		{
			$('.stream_box_action').slideUp('fast');	
			$(this).css('height',20);
		}
	})
	
	$('.view').live('click',function(e){
		e.preventDefault();
		
		var account_id = $(this).data('aid');
		
		$("#view").modal({
			show: true,
			backdrop: true
		})
		
		
		$('*').addClass('wait');
		
		$(".mtitle").empty().html(account_id + ' View account details');
		
		$.ajax({
			url: root + 'characters/getAccountCharacter',
			dataType: 'json',
			data: {account_id:account_id},
			type: 'POST',
			success: function(data)
			{
				try
				{
					if(data)
					{
						var html = "";
						$('.loadchar').html('');
						
						$.each(data.db,function(i,n){
							html = "";
							html += "<tr>";
							html += "	<td><a href=''>"+n.char_id+"</a></td>";
							html += "	<td>"+n.char_num+"</td>";
							html += "	<td>"+n.name+"</td>";
							html += "	<td>"+n.job+"</td>";
							html += "	<td>"+n.level+"</td>";
							html += "</tr>";
						   
							$('.loadchar').prepend(html);
						})
						
						$('*').removeClass('wait');
					}
				}
				catch(e)
				{}
			}
		})
		
	});
	
})

var jsonPROC = {
	retry : function(data,form)
	{
	
	}
}

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
