function getOnline()
{
	/*
	$.get(root +'characters/getOnline',function(e){
		var db = e.db;
		var html = "";
		
		$('.onlinechars').html('<li>Loading...</li>');
		
		$.each(db,function(i,n){
			html  = "";
			html += "<li><a href=\"#\"><i class=\"icon-ok\"></i> "+n.name+"</a></li>";
			$('.onlinechars').prepend(html);
		})

	},'json');*/
}

$(document).ready(function(e){
	/*
	$('select[name=reset]').live('change',function(){
		var action = $(this).val();
		var char_id = $(this).data('charid');
		
		if(action == "") return false;
		
		$('input[name=char_id]').val('');
		$('input[name=action]').val('');
		
		$('#reset').modal({
			show: true,
			backdrop: true
		})
		
		$('.message').html('You are about to reset your character. Please be sure that your character is currenty <b>offline.</b>');
		
		$('.close_nevermind').show();
		$('.close_reset').hide();
		$('.close_confirm').show();
		
		$('input[name=char_id]').val(char_id);
		$('input[name=action]').val(action);
	})
	*/
	
	$('.char_reset a').live('click',function(e){
		e.preventDefault();
		var action = $(this).data('act');
		var char_id = $(this).data('charid');
		
		$('input[name=char_id]').val('');
		$('input[name=action]').val('');
		
		$('#reset').modal({
			show: true,
			backdrop: true
		})
		
		$('.message').html('You are about to reset your character. Please be sure that your character is currenty <b>offline.</b>');
		
		$('.close_nevermind').show();
		$('.close_reset').hide();
		$('.close_confirm').show();
		
		$('input[name=char_id]').val(char_id);
		$('input[name=action]').val(action);
	})
	
	$('#confirm_reset').live('click',function(e){
		e.preventDefault();
		
		var char_id = $('input[name=char_id]').val();
		var action = $('input[name=action]').val();
		
		$.ajax({
			url: root + 'characters/reset',
			dataType: 'json',
			data: {char_id: char_id,action:action},
			type: 'post',
			success: function(data)
			{
				try
				{
					//$('#reset').modal('hide');
					$('.message').html('').html(data.message);
					$('.close_nevermind').hide();
					$('.close_reset').show();
					$('.close_confirm').hide();
					$('select[name=reset]').val('');
				}
				catch(e)
				{
					
				}
			}
		})
	})
})
