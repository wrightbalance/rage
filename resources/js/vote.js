
$(document).ready(function(){

	voteFlex();
	
	$('.viewvotes').live('click',function(e){
		e.preventDefault();
		
		var id = $(this).data('aid');
		
		editState('create');


		$.ajax({
			url: root + 'vote/getBanners	',
			dataType: 'json',
			type: 'POST',
			data: {id:id},
			success: function(data)
			{
				try
				{
					if(data)
					{
						var db = data.db;
						
						$.each(db,function(i,n){
							$('input[name='+i+']').val(n);
							$('select[name='+i+']').val(n);
							$('textarea[name='+i+']').val(n);
						
							if(db.publish == 1)
							{
								$('input[name='+i+']').attr('checked','checked');
							}
							else
							{
								$('input[name='+i+']').removeAttr('checked');
							}
						})
					}
				}
				catch(e)
				{
					
				}
			},
			error: function(data)
			{
				
			}
		})
	})
	
	$('.deletevote').live('click',function(e){
		e.preventDefault();
		
		var ans = confirm('Are you sure you want to delete?');
		var id = $(this).data('aid');
		
		if(ans)
		{
			$.ajax({
				url: root + 'vote/delete',
				dataType: 'json',
				type: 'POST',
				data: {id:id},
				success: function(data)
				{
					try
					{
						$('.voteFlex').flexReload();
					}
					catch(e)
					{}
				}
				,error: function(e)
				{
					console.log(e);
				}
			})
		}
	})
})

function voteFlex()
{
	$('.voteFlex').livequery(function(){
		$(this).flexigrid
		(
			{
			autoload: true,
			blockOpacity: 0,
			singleSelect: true,
			height: 'auto',
			preProcess: function(data)
			{
				return data;
			},
			url: root + 'vote/getList',
			dataType: 'json',
			colModel : [ 
						 {display: 'Vote Banner', name : 'image_url', width : 100, sortable: false}
						,{display: 'Vote Sites', name : 'vote_url', width : 120, sortable: true}
						,{display: 'Vote URL', name : 'account_id', width : 200, sortable: true}
						,{display: 'Credits', name : 'userid', width : 50, sortable: false}
						,{display: 'Interval', name : 'email', width : 50, sortable: false}
						,{display: 'Edit', name : 'edit', width : 50, sortable: false}
						,{display: 'Delete', name : 'delete', width : 50, sortable: false}
					],
			sortname: "id",
			sortorder: "desc",
			showToggleBtn: true, 
			params: [{name:'item',value: 1}],
			usepager: true,
			rpOptions: [15, 30, 60, 90],
			rp: 15,
			useRp: true,        
			timeout: 20,
			height: 390,
			onTimeout: function()
			{
				
			},
			onSuccess: function()
			{
			
			},
			showTableToggleBtn: true
			
		   }
		);
		
	})
}
