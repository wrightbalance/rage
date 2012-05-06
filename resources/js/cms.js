$(document).ready(function(){
	$('.create_news').live('click',function(e){
		var btnstate = $(this).data('btnstate');
		
		if(btnstate == "create")
		{
			$(this).html('<i class="icon-repeat"></i> Go back');
			$(this).data('btnstate','edit');
			$('.epane').show();
			$('.vpane').hide();
		}
		else
		{
			$(this).html('<i class="icon-pencil"></i> Create News');
			$(this).data('btnstate','create');
			$('.epane').hide();
			$('.vpane').show();
		}
		
	})
	
	$('a.viewnews').live('click',function(e){
		e.preventDefault();
		var uri = $(this).attr('href');
		var newsid = $(this).data('aid');
		
		editState('create');
		//window.history.pushState(uri,uri,uri);
		
		viewnews(newsid)	
	})


	$('textarea.edit').livequery(function(){
	$(this).tinymce({
			// Location of TinyMCE script
			script_url : root + 'resources/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,forecolor",
			//theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			//theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			height:210,

		});

	})
	
	$('a.deletenews').live('click',function(e){
		e.preventDefault();
		
		var newsid = $(this).data('aid');
		
		var ans = confirm('Are you sure to delete this item?');
		
		if(ans)
		{
			$.post(root+'cms/newsdelete',{newsid:newsid},function(){
				$('.newsFlex').livequery(function(){
					$(this).flexReload();
				})
			},'json')
		}
		
	})
	
	$('.get_news').live('click',function(e){
		e.preventDefault();
		
		$('#news_loader').html('');
		$('*').addClass('wait');
		
		//if($(this).parent().hasClass('active')) return false;
		
		$.ajax({
			url: root + 'cms/getNewsList',
			dataType: 'json',
			type: 'get',
			success: function(data)
			{
				try
				{
					var html = "";
					var db = data.news;
					
					$.each(db,function(i,n){
						html  = "";
						html += "<div class=\"nrow\">";
						html +=		"<span class=\"label label-info\">"+n.category+"</span>"; 
						html +=		"		<a href=\"\">"+n.news_title+"</a>"; 
						html +=		"		<span class=\"ndate\">"+n.created+"</span>";
						html +=	"</div>";
						html +=	"<div id=\"news_details-"+n._id+"\"></div>";
						
						$('#news_loader').prepend(html);
					})
					
					$('*').removeClass('wait');
					
				}
				catch(e)
				{
					console.log(e);
				}
			}
		})
	})
	
	
})

$('.cancel').live('click',function()
{
	$('.create_news').html('<i class="icon-pencil"></i> Create News');
	$('.epane').show();
	$('.vpane').hide();
})

function editState(state)
{
	if(state == "view")
	{
		$('.create_news').html('<i class="icon-pencil"></i> Create News');
		$('.epane').show();
		$('.vpane').hide();
		$('.create_news').data('btnstate','create');
	}
	else
	{
		$('.create_news').html('<i class="icon-repeat"></i> Go Back');
		$('.epane').show();
		$('.vpane').hide();
		$('.create_news').data('btnstate','edit');
	}
}

function viewnews(newsid)
{
	$('.formnews').trigger('reset');
	
	$.ajax({
		url: root + 'cms/getNews',
		dataType: 'json',
		type: 'post',
		data: {newsid:newsid},
		success: function(data)
		{
			try
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
			catch(e)
			{
				
			}
		}
	})
}
