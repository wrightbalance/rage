<div class="maincol">
	
	<!--
	<ul class="tab black nav nav-tabs nomargin">
		<li class="active"><a href="#">Stream Feed</a></li>
	
	</ul>
	-->
	<br/>
	<div class="tpane pactive">
		<div class="streamResponse"></div>
		<div class="stream_box">
			<form class="sform" method="post" action="<?=site_url('stream/post')?>">
			<input type="hidden" value="<?=$user['account_id']?>" name="account_id"/>
			<?php if(isset($user['nickname'])){?>
			<input type="hidden" value="<?=$user['nickname']?>" name="nickname"/>
			<? } ?>
			<input type="hidden" value="<?=$user['sex']?>" name="gender"/>
			<textarea class="message" name="message" placeholder="What is in your mind?"></textarea>
			<div class="stream_box_action clearfix">
				<button type="submit" class="btn btn-primary floatright"><i class="icon-share icon-white"></i> Share</button>
			</div>
			</form>
		</div>
		<hr/>
		<div class="streams">
			<?php if(isset($streams) && $streams){ ?>
				<?php foreach($streams as $stream){?>
				<?php //echo "<pre>"; print_r($streams)?>
				<div class="stream_row" id="streamholder-<?=$stream['sid']?>">
				<div class="srow clearfix">
					<?php if($authorize || $stream['account_id'] == $user['account_id']){ ?>
						<a href="#" data-id="<?=$stream['sid']?>" class="close deleteStream close_extend" data-kind="stream">×</a>
					<? } ?>
					<div class="avatar50">
						<?php 
							$photo = resource_url('images/photo_'.strtolower($stream['sex']).'.jpg');
							
							if(file_exists('./resources/images/avatar/'.$stream['account_id'].'.jpg')){
								$photo = resource_url('images/avatar/'.$stream['account_id'].'.jpg');
							}
						?>
						<img src="<?=$photo?>" height="50" width="50"/>
					</div>
					<div class="srow_details">
						<a href="#" class="<?=$stream['abadge']?>"><?=ucwords($stream['nickname'])?></a>
						<?=parseurl(nl2br($stream['content']))?>
					</div>
					<div class="srow_actions">
						<a href="#" id="docomment" data-id="<?=$stream['sid']?>">Comment</a> - <span><?=$stream['created']?></span>
					</div>
					<div class="srow_comments" id="c2-<?=$stream['sid']?>">
						<div class="loadcomment">
							<?php //echo "<pre>"; print_r($stream['comments'])?>
							<?php if($stream['comments']){?>
								
								<?php if($stream['comment_count'] > 3){?>
								<div class="comments clearfix">
									<a href="" class="comment_state showComments" data-sid="<?=$stream['sid']?>">View all <?=$stream['comment_count']?> Comments</a>
								</div>
								<? } ?>

								<?php foreach($stream['comments'] as $comment){?>
								<div class="comments clearfix" id="commentHolder-<?=$comment['csid']?>">
									<div class="avatar32">
										<?php 
											$photo2 = resource_url('images/photo_'.strtolower($comment['sex']).'.jpg');
							
											if(file_exists('./resources/images/avatar/'.$comment['account_id'].'.jpg')){
												$photo2 = resource_url('images/avatar/'.$comment['account_id'].'.jpg');
											}
										?>
										
										<img src="<?=$photo2?>" width="32" height="32"/>
									</div>
									<div class="comments_details">
										<a href="#" class="<?=$comment['abadge']?>"><?=$comment['nickname']?></a> <?=$comment['comment']?>
										<span style="display: block; font-size: 10px; margin-top: 3px; color: #333;"><?=$comment['created']?></span>
									</div>

									<?php if($authorize || $comment['account_id'] == $user['account_id']){ ?>
									<a href="#" data-id="<?=$comment['csid']?>" data-comment_id="<?=$comment['csid']?>" class="close deleteStream" data-kind="comment">×</a>
									<? } ?>
								</div>
								<? } ?>
							<? } ?>
						</div>
						<?php 
			
							$comment_text = "";
							
							if(count($stream['comments']) > 0)
								$comment_text = "style=\"display:block\"";
						?>
						<div class="comment_box" <?=$comment_text?>>
							<input type="text" name="comment" data-id="<?=$stream['sid']?>" id="postcomment-<?=$stream['sid']?>" class="reset" placeholder="Write a comment..."/>
						</div>
						
					</div>
				</div>
				<hr>
				</div>
				<? } ?>
			<? } ?>
			
			
			
			
			
		</div>
		
	</div>
	
	<!--
	<div class="tpane news_loader">
		
		
		
	</div>
	<div class="tpane news_loader">
	
	</div>
	<div class="tpane news_loader">
		
	</div>
	-->

</div>

<?php $this->load->view('widget/rightcol')?>
