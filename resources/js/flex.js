
$(document).ready(function(){

	accountFlex();
	storageFlex();
	
	
})

function accountFlex()
{
	$('.accounts').livequery(function(){
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
			url: root + 'account/getList',
			dataType: 'json',
			colModel : [ 
						{display: 'Account ID', name : 'account_id', width : 70, sortable: true}
						,{display: 'Username', name : 'userid', width : 160, sortable: true}
						,{display: 'Group ID', name : 'group_id', width : 50, sortable: true, align: 'center'}
						,{display: 'IP', name : 'last_ip', width : 150, sortable: true}
						,{display: 'Last Login', name : 'age', width : 150, sortable: false}
						
					],
			sortname: "account_id",
			sortorder: "asc",
			showToggleBtn: true, 
			searchitems : [
						{display: 'Username', name : 'userid'},
						{display: 'E-mail', name : 'email'},
						{display: 'IP', name : 'last_ip'},
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
}

function storageFlex()
{
	$('.storage').livequery(function(){
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
			url: root + 'characters/getStorage',
			dataType: 'json',
			colModel : [ 
						{display: 'Name', name : 'nameid', width : 160, sortable: true}
						,{display: 'Quantity', name : 'amount', width : 50, sortable: false}
						,{display: 'Card 0', name : 'card0', width : 50, sortable: false}
						,{display: 'Card 1', name : 'card1', width : 50, sortable: false}
						,{display: 'Card 2', name : 'card2', width : 50, sortable: false}
						,{display: 'Card 3', name : 'card3', width : 50, sortable: false}
						
					],
			sortname: "account_id",
			sortorder: "asc",
			showToggleBtn: true, 
			searchitems : [
						{display: 'Name', name : 'nameid'},
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
}

