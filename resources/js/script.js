$(document).ready(function(){

	if($('#set_nickname').length)
	{
		$('#set_nickname').modal({
			show: true,
			backdrop: 'static',
			keyboard: false
		});
	}
	
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
			});
			
			accountFlex();
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
		var  dt = [{name:'account_id',value: account_id}];
		
		$('.modal .characters').livequery(function(){
			$(this).flexOptions({params: dt}).flexReload();
		})
		
		
		
		$('.storageFlex').flexOptions({params:dt}).flexReload();
		
		$("#view").modal({
			show: true,
			backdrop: true
		})
		
		$('*').addClass('wait');
		
		$(".mtitle").empty().html(account_id + ' View account details');
		
		$('.modal .characters').flexToggleCol('account_id',0);
		
		$.ajax({
			url: root + 'account/getAccount',
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
				
						$.each(data.chars,function(i,n){
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
						
						$.each(data.account,function(i,n){
							
							if($('.'+i).length)
							{
								$('.'+i).val(n);
								console.log(i);
							}
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
		$('.response',form).html(data.message);
		$(form).trigger('reset');
	}
	,retry2: function(data,form)
	{
		$('.response',form).html(data.message);
	}
	,reset: function(data,form)
	{
		$('.response',form).empty();
		$(form).trigger('reset');
		$('.create_news').html('<i class="icon-pencil"></i> Create News');
		$('.create_news').data('btnstate','create');
		$('.epane').hide();
		$('.vpane').show();
		$('.fields',form).show();
		$('.'+data.source+'Flex').livequery(function(){
			$(this).flexReload();
		})
	},
	reload: function(data,form)
	{
		location.reload();
	}
}

$('.form').live('submit',function(e){
	e.preventDefault();

	var form 	= this;
	var dt 		= $(form).serializeArray();
	var action 	= $(form).attr('action');
	var act 	= $('input[name=action]').val();
	
	$('.loaders',form).fadeIn('fast');
	$('button',form).attr('disabled','disabled');
	
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
					$('.loaders',form).fadeOut('fast');
					$('button',form).removeAttr('disabled');
					
				}	
			}
			catch(e){
				$('.response').html('<div class="res_message">Oops! Something went wrong. Please try again.</div> <button class="btn retryform" type="button">Retry</button>');
				$('button',form).removeAttr('disabled');
				console.log(e);
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


	
$('.retryform').live('click',function(){
	$('.fields').show();
	$('.response').empty();
})

$(window).bind("popstate", function(evt) {
	var state = evt.originalEvent.state;
	if(state)
	{
		location.href=state;
	}
});
