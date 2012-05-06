<div class="maincol">

	<ul class="tab nav nav-tabs nomargin">
		<li class="active"><a href="#"><i class="icon-comment"></i> Stream Feed</a></li>
		<li><a href="#" class="get_news" data-kind="news"><i class="icon-list-alt"></i> Latest News <!--<span class="nbadge">12</span></a>--></li>
		<li><a href="#" class="get_news" data-kind="events"><i class="icon-calendar"></i> Events</a></li>
		<li><a href="#" class="get_news" data-kind="changelog"><i class="icon-tags"></i> Change Log</li></a></li>

	</ul>
	
	<br/>
	<div class="tpane pactive">
	<div class="stream_box">
		<form class="sform" method="post" action="<?=site_url('stream/post')?>">
		<input type="hidden" value="<?=$details['_id']?>" name="account_id"/>
		<input type="hidden" value="<?=$details['nickname']?>" name="nickname"/>
		<input type="hidden" value="<?=$details['sex']?>" name="gender"/>
		<textarea class="message" name="message" placeholder="What is in your mind?"></textarea>
		<div class="stream_box_action clearfix">
			<button type="submit" class="btn btn-primary floatright">Post</button>
		</div>
		</form>
	</div>
	<hr/>
	
	
	<div class="streams">
		
		<?php if(isset($streams) && $streams){ ?>
			<?php foreach($streams as $key=>$val){?>

			<div class="srow clearfix" id="<?=(string)$val['_id']?>">
				<div class="avatar50">
					<img src="<?=resource_url('images/photo_'.strtolower($val['gender']).'.jpg')?>" />
				</div>
				<div class="srow_details">
					<a href="#"><?=ucwords($val['nickname'])?></a>
					<?=nl2br($val['message'])?>
				</div>
				<div class="srow_actions">
					<a href="#" id="docomment" data-id="<?=(string)$val['_id']?>">Comment</a> - <span><?=ago($val['created'])?></span>
				</div>
				<div class="srow_comments" id="c2-<?=(string)$val['_id']?>">
					<div class="loadcomment">
						<?php foreach($val['comments'] as $k=>$v){?>
						<div class="comments clearfix">
							<div class="avatar32">
								<img src="<?=resource_url('images/photo_'.strtolower($v['gender']).'.jpg')?>" width="32" height="32"/>
							</div>
							<div class="comments_details">
								<a href=""><?=$v['nickname']?></a> <?=$v['comment']?>
							</div>
						</div>
						<? } ?>
					</div>
					<div class="comment_box">
						<input type="text" name="comment" data-id="<?=(string)$val['_id']?>" id="postcomment-<?=(string)$val['_id']?>" class="reset" placeholder="Write a comment..."/>
					</div>
					
				</div>
			</div>
			<hr>
			<? } ?>
		<? } ?>
		
		
		
		
		
	</div>
	</div>
	
	<div class="tpane news_loader">
		
	</div>
	<div class="tpane news_loader">
	
	</div>
	<div class="tpane news_loader">
		
	</div>

</div>

<?php $this->load->view('widget/rightcol')?>
