$(document).ready(function(){
	
	$('.sform').live('submit',function(e){
	e.preventDefault();
	
	var form = this;
	var dt = $(form).serializeArray();
	var action = $(form).attr('action');
	
	if($('.message').val() == "")
		return false;

	$('.message').css('height',20);
	$(form).trigger('reset');

	$.ajax({
		url: action,
		data: dt,
		type: 'POST',
		dataType: 'json',
		success: function(data)
		{
			try
			{
				var html = "";
				var db = data.db;
		
				html  = '';
				html += '<div class="srow clearfix" style="display: none" id="streamholder-'+db.sid+'">';
				html += '<a href="#" data-id="'+db.sid+'" class="close deleteStream close_extend" data-kind="stream">×</a>';
				html +=		'<div class="avatar50">';
				html +=		'<img src="'+photo_path+'"/>';
				html +=		'		</div>';
				html +=		'		<div class="srow_details">';
				html +=		'			<a href="" class="'+db.abadge+'">'+nickname+'</a> ' + db.content;
				html +=		'		</div>';
				html +=		'		<div class="srow_actions">';
				html +=		'			<a href="#" id="docomment" data-id="'+db.sid+'">Comment</a> - <span>Just now</span>';
				html +=		'		</div>';
				html +=		'		<div class="srow_comments" id="c2-'+db.sid+'">';
				html +=		'			<div class="loadcomment"></div>';
				html +=		'			<div class="comment_box">';
				html +=		'				<input type="text" name="comment" data-id="'+db.sid+'" id="postcomment-"'+db.sid+'"" class="reset" placeholder="Write a comment..."/>';
				html +=		'			</div>';		
				html +=		'		</div>';
				html +=		'	</div>';
				html +=		'	<hr>';
				
				
				$('.streams').prepend(html);
				$('.stream_box_action').slideUp('fast');
				$('.srow').slideDown('fast');
			}
			catch(e){
				console.log(e);
			};
		}
		,error: function(xhr)
		{
			
		}
		})
	})
	
	$('#docomment').live('click',function(e){
		e.preventDefault();
		var id = $(this).data('id');
		
		
		$('#c2-'+id+' .comment_box').slideDown('fast');
		$('#c2-'+id+' .comment_box input').focus();
	})
	
	$('input[name=comment]').live('keypress',function(e){
		if(e.which == 13)
		{
			var p = this;
			var v = $(this).val();
			var id = $(this).data('id');
			var html = "";
			
			var dt = {comment:v,account_id:accountid,nickname:nickname,sid:id,gender:gender};
			
			if(v == "") return false;
			
			$.ajax({
				url : root + 'stream/comment',
				data: dt,
				dataType: 'json',
				type: 'POST',
				success: function(data)
				{
					try
					{
						var db = data.db;
						
						html  = 	'											';
						html +=		'			<div class="comments clearfix" id="comment-"'+db.cid+'"">';
						html +=		'				<div class="avatar32">';
						html +=		'				<img src="'+photo_path+'" width="32" height="32"/>';
						html += 	'				</div>';
						html +=		'				<div class="comments_details">';
						html +=		'					<a href="" class="'+db.abadge+'">'+nickname+'</a> '+db.comment;
						html += 	'					<span style="display: block; font-size: 10px; margin-top: 3px; color: #333;">Just now</span>';
						html +=		'				</div>';
						html +=		'			</div>';
						
						$('#c2-'+id+' .loadcomment').append(html);
						
						$(p).val('');
					}
					catch(e)
					{}
				}
			})
			
			
		}
	})

	$('.deletecomment').live('click',function(e){
		e.preventDefault();
		
		var id = $(this).data('id');
		var comment_id = $(this).data('comment_id');
		var ans = confirm('Are you sure you want to delete?');
		
		if(ans)
		{
			var dt = {comment_id:comment_id};
			
			$.ajax({
				url: root + 'stream/delete_comment',
				dataType: 'json',
				type: 'post',
				data: dt,
				success: function(data)
				{
					try
					{
						$('#commentHolder-'+comment_id).slideUp('fast');
					}
					catch(e)
					{
						console.log(e);
					}
				}
			})
		}
	})
	
	$('.deleteStream').live('click',function(e){
		e.preventDefault();
		
		var id 			= $(this).data('id');
		var ans 		= confirm('Are you sure you want to delete?');
		var kind 		= $(this).data('kind');
		var comment_id 	= $(this).data('comment_id');
		
		if(ans)
		{
			var dt = {id:id,comment_id:comment_id,kind:kind};
			
			$.ajax({
				url: root + 'stream/delete',
				dataType: 'json',
				type: 'post',
				data: dt,
				success: function(data)
				{
					try
					{
						console.log(data);
						
						if(data.kind == "comment")
						{
							$('#commentHolder-'+comment_id).slideUp('fast');
						}
						else if(data.kind == "stream")
						{
							$('#streamholder-'+id).slideUp('fast');
						}
					}
					catch(e)
					{
						console.log(e);
					}
				}
			})
		}
	})
})
