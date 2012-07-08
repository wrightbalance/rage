var module = {
	
	create: function(item)
	{
		console.log(item);
	}
	,modify: function(data)
	{
		console.log(data);
		$('.vpane').hide();
		$('.epane').show();
	}
}


$(document).ready(function(){
	
	$('.module').live('click',function(){
		
		var mod = $(this).data('mod');
		var data = $(this).data('dt');
		
		module[mod](data);
		
	})
	
})
