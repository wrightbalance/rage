function getOnline()
{
	$.get(root +'characters/getOnline',function(e){
		var db = e.db;
		var html = "";
		
		$('.onlinechars').html('<li>Loading...</li>');
		
		$.each(db,function(i,n){
			html  = "";
			html += "<li><a href=\"#\"><i class=\"icon-ok\"></i> "+n.name+"</a></li>";
			$('.onlinechars').prepend(html);
		})
		
		
		console.log(db);
	},'json');
}
