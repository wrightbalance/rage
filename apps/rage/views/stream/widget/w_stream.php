<div class="maincol">
	<div class="live_pvp">
		<span class="plabel">LIVE PVP:</span>
		<span class="pcomment">Triblist has pawned Stutter's head at guild_vs2</span>
	</div>
	
	
	<ul class="tab nav nav-tabs nomargin">
		<li class="active"><a href="#">Stream Feed</a></li>
		<li><a href="#" class="get_news" data-kind="news">Change Log
			<?php if(isset($news_count) && $news_count > 0) { ?> 
				<span class="nbadge news"><?=$news_count?></span>
			<? } ?>
			</a>
		</li>
	</ul>
	
	<br/>
	<div class="tpane pactive">
	<div class="stream_box">
		<form class="sform" method="post" action="<?=site_url('stream/post')?>">
		<input type="hidden" value="<?=$details['account_id']?>" name="account_id"/>
		<?php if(isset($details['nickname'])){?>
		<input type="hidden" value="<?=$details['nickname']?>" name="nickname"/>
		<? } ?>
		<input type="hidden" value="<?=$details['sex']?>" name="gender"/>
		<textarea class="message" name="message" placeholder="What is in your mind?"></textarea>
		<div class="stream_box_action clearfix">
			<button type="submit" class="btn btn-primary floatright">Post</button>
		</div>
		</form>
	</div>

	<div class="streams">
		<?php if(isset($streams) && $streams){ ?>
			<?php foreach($streams as $key=>$val){?>
			<div class="stream_row" id="streamholder-<?=(string)$val['_id']?>">
			<div class="srow clearfix">
				<?php if(isset($isAdmin) && $isAdmin){ ?>
					<a href="#" data-id="<?=(string)$val['_id']?>" class="close deleteStream close_extend" data-kind="stream">×</a>
				<? } ?>
				<div class="avatar50">
					<img src="<?=resource_url('images/photo_'.strtolower($val['gender']).'.jpg')?>" />
				</div>
				<div class="srow_details">
					<a href="#"><?=ucwords($val['nickname'])?></a>
					<?=parseurl(nl2br($val['message']))?>
				</div>
				<div class="srow_actions">
					<a href="#" id="docomment" data-id="<?=(string)$val['_id']?>">Comment</a> - <span><?=ago($val['created'])?></span>
				</div>
				<div class="srow_comments" id="c2-<?=(string)$val['_id']?>">
					<div class="loadcomment">
						<?php foreach($val['comments'] as $k=>$v){?>
						<div class="comments clearfix" id="commentHolder-<?=$v['comment_id']?>">
							<div class="avatar32">
								<img src="<?=resource_url('images/photo_'.strtolower($v['gender']).'.jpg')?>" width="32" height="32"/>
							</div>
							<div class="comments_details">
								<a href=""><?=$v['nickname']?></a> <?=$v['comment']?>
							</div>
							<?php if(isset($isAdmin) && $isAdmin){ ?>
							<a href="#" data-id="<?=(string)$val['_id']?>" data-comment_id="<?=$v['comment_id']?>" class="close deleteStream" data-kind="comment">×</a>
							<? } ?>
						</div>
						<? } ?>
					</div>
					<?php 
		
						$comment_text = "";
						
						if(count($val['comments']) > 0)
							$comment_text = "style=\"display:block\"";
					?>
					<div class="comment_box" <?=$comment_text?>>
						<input type="text" name="comment" data-id="<?=(string)$val['_id']?>" id="postcomment-<?=(string)$val['_id']?>" class="reset" placeholder="Write a comment..."/>
					</div>
					
				</div>
			</div>
			<hr>
			</div>
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
