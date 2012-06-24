$(document).ready(function(){
	
	$('.pvpFlex').livequery(function(){
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
			url: root + 'rankings/getListPVP',
			dataType: 'json',
			colModel : [ 
						 {display: 'Rank', name : 'rank', width : 30, align: 'center', sortable: false}
						,{display: 'Name', name : 'name', width : 160, sortable: true}
						,{display: 'Kills', name : 'kills', width : 60, align: 'center', sortable: true}	
					],
			sortname: "kills",
			sortorder: "desc",
			showToggleBtn: true, 
			params: [{name:'item',value: 1}],
			usepager: false,
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
	
	$('.guildFlex').livequery(function(){
		$(this).flexigrid
		(
			{
			autoload: false,
			blockOpacity: 0,
			singleSelect: true,
			height: 'auto',
			preProcess: function(data)
			{
				return data;
			},
			url: root + 'rankings/getListGuild',
			dataType: 'json',
			colModel : [ 
						 {display: 'Rank', name : 'rank', width : 30, align: 'center', sortable: false}
						,{display: 'Emblem', name : 'name', width : 60, sortable: true}
						,{display: 'Guild Name', name : 'name', width : 160, sortable: true}
						,{display: 'Master', name : 'kills', width : 160, sortable: true}	
						,{display: 'Castles', name : 'kills', width : 60, align: 'center', sortable: true}	
					],
			sortname: "guild_count",
			sortorder: "desc",
			showToggleBtn: true, 
			params: [{name:'item',value: 1}],
			usepager: false,
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
