$(document).ready(function(e){

	
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
		
		$('.message').html('You are about to reset your character. <br/>Please be sure that your character is currenty <span class="label label-warning">OFFLINE</span> <br/><br/> Would you like to proceed?');
		
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
		
		$('.message').html('<div class="res_message loader">Processing. please wait...</div>');
		
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
					$('.message').html('').html('<div class="res_message">'+data.message+'</div>');
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
	
	$('a.view_char').live('click',function(e){
		e.preventDefault();
		var char_id = $(this).data('char_id');
		
		
		
		$('#modal_loader').modal({
			show: true,
			backdrop: true
		});
		
		$('#modal_loader').html('<div class="modal_body"><div class="res_message loader">Loading character...</div></div>').css('addPadding10');
		
		$.post(root+'characters/view_char',{char_id:char_id},function(data){
			$('#modal_loader').html(data);
		},'html');
		
		$('.delete_char').data('delstate','showform');
		$('.char_delete_confirm').hide();
		$('.char_stats,.char_image').show();
	})
	
	$('.delete_char').live('click',function(e){
		e.preventDefault();

		$('.char_delete_confirm').fadeIn('fast',function(){
			$('.delete_char').data('delstate','delete');
		});
		$('.char_stats,.char_image').hide();
		
		$(this).text('Yes delete it now');
		
		
		if($(this).data('delstate') == "delete")
		{
			$('.deletechar').submit();
		}
		
	})
})
