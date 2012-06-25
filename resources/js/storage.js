$(document).ready(function(){
	
	$('.storageFlex').livequery(function(){
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
			url: root + 'storage/getList',
			dataType: 'json',
			colModel : [ 
						 {display: '', name : '', width : 24, sortable: false}
						,{display: 'Name', name : 'name_english', width : 300, sortable: true}
						,{display: 'Quantity', name : 'amount', width : 50, sortable: true}		
					],
			sortname: "name_english",
			sortorder: "asc",
			showToggleBtn: true, 
			searchitems : [
						{display: 'Item Name', name : 'name_japanese'},

						],
			params: [{name:'item',value: 1}],
			usepager: true,
			rpOptions: [15, 30, 60, 90],
			rp: 15,
			useRp: true,        
			timeout: 20,
			height: 260,
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
