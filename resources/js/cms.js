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
})


	$('.cancel').live('click',function()
	{
		$('.create_news').html('<i class="icon-pencil"></i> Create News');
		$('.epane').show();
		$('.vpane').hide();

	})
