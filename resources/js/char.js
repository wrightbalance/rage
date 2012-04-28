function getOnline()
{
	$.get(root +'characters/getOnline',function(e){
		var db = e.db;
		
		console.log(db);
	},'json');
}
