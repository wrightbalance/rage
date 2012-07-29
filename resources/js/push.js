$(document).ready(function(){
	
	$('a.ps').live('click',function(){
		if(typeof history.pushState != "undefined")
		{
			var uri = $(this).attr('href');
			var setup = $(this).data('setup');

			window.history.pushState(uri,uri,uri);
			
			if(setup != "plane")
			{
				$('#loadcontent').load(uri,function(){
					$('*').removeClass('wait');
				});
		
			}

			return false;
		}
		else
		{
			return true;
		}
	})
	
})
