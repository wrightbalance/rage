
$(document).ready(function(){

	accoungFlex();
	
	
})

function accoungFlex()
{
	$('.accounts').livequery(function(){
		
		
	$(this).flexigrid
    (
        {
		autoload: true,
        blockOpacity: 0,
        title: 'Account Lists',
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
