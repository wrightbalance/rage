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
		var form = $('.deletechar');
		var action = $(form).attr('action');
		var dt = $(form).serializeArray();

		$('.char_delete_confirm').fadeIn('fast',function(){
			$('.delete_char').data('delstate','delete');
		});
		$('.char_stats,.char_image').hide();
		
		$(this).text('Yes delete it now');
	

		if($(this).data('delstate') == "delete")
		{
				$('.fields',form).hide();
			$('.response',form).html('<div class="res_message loader">Loading...</div>');
			
			$.ajax({
				url: action,
				dataType: 'json',
				type: 'POST',
				data: dt,
				success: function(data)
				{
					try
					{
						$('.response',form).html(data.message);
						
						if(data.action == "done")
						{
							if($('#charid'+data.char_id).length)
							{
								$('#charid'+data.char_id).remove();
								$('#modal_loader').modal('hide');
							}
						}
						else
						{
							$('.response',form).html(data.message);
				
						}
					}
					catch(e)
					{
						$('.response').html('<div class="res_message">Oops! Something went wrong. Please try again.</div> <button class="btn retryform" type="button">Retry</button>');
						console.log(e);
					}
				}
				,error: function(xhr)
				{
					$('.response').html('<div class="res_message">Oops! Something went wrong. Please try again.</div> <button class="btn retryform" type="button">Retry</button>');
					console.log(xhr);
				}
			})
		}
		
	})
	
	$('.characters').livequery(function(){
		$(this).flexigrid
		(
			{
			autoload: true,
			blockOpacity: 0,
			singleSelect: true,
			preProcess: function(data)
			{
				return data;
			},
			url: root + 'characters/getList',
			dataType: 'json',
			colModel : [ 
						 {display: 'Account ID', name : 'account_id', width : 60, sortable: true}
						,{display: 'Name', name : 'name', width : 110, sortable: true}
						,{display: 'Job', name : 'class', width : 80, sortable: true}
						,{display: 'Base Level', name : 'base_level', width : 60, sortable: true, align: 'center'}
						,{display: 'Job Level', name : 'job_level', width : 60, sortable: true}
						,{display: 'Zeny', name : 'zeny', width : 60, sortable: false}
						
					],
			sortname: "account_id",
			sortorder: "asc",
			showToggleBtn: true, 
			searchitems : [
						{display: 'Character Name', name : 'name'},
						{display: 'Account ID', name : 'account_id'},
						],
			params: [{name:'item',value: 1}],
			usepager: true,
			rpOptions: [15, 30, 60, 90],
			rp: 10,
			useRp: true,        
			timeout: 20,
			height: 390,
			onTimeout: function()
			{
				
			},
			onSuccess: function()
			{
			
			},
			showTableToggleBtn: true,
			
		   }
		);
		
	})
	
	
})
