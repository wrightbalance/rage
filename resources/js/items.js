$(document).ready(function(){
	
	$('.itemsFlex').livequery(function(){
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
			url: root + 'items/getList',
			dataType: 'json',
			colModel : [ 
						 {display: '', name : '', width : 24, sortable: false}
						,{display: 'Name', name : 'name_english', width : 200, sortable: true}
						,{display: 'Type', name : 'type', width : 70, sortable: true}
						,{display: 'Buy', name : 'price_buy', align:'right', width : 50, sortable: true}
						,{display: 'Sell', name : 'price_sell', align:'right', width : 50, sortable: true}
						,{display: 'Weight', name : 'weight', align:'right', width : 50, sortable: true}
						,{display: 'Defence', name : 'defence', align:'right', width : 50, sortable: true}
						,{display: 'Range', name : 'range', align:'right', width : 50, sortable: true}
						,{display: 'Slots', name : 'slots', align:'right', width : 50, sortable: true}
						
					],
			sortname: "id",
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
