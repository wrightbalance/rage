<h4 class="wTitle">Latest News:</h4>
<hr class="blackLine"/>

<?php foreach($news as $n){?>
<div class="nrow">
	<div class="nAvatar">
		<?php if(file_exists('./resources/images/avatar/'.$n['author'].'.jpg')){?>
			<img src="<?php echo resource_url('images/avatar/'.$n['author'].'.jpg')?>" alt="" width="40" height="40"/>
		<? } ?>
	</div>
	<div class="nDetails">
		<span><?php echo '['.strtoupper($n['category']).'] '.$n['title']?></span>
		<span><?php echo $n['nickname']?></span>
	</div>
	<div class="nDate">
		<?php echo date('M d, Y',strtotime($n['created_on']))?>
	</div>
	<div class="clear"></div>
</div>
<? } ?>
