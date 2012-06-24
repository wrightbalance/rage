<?php if($user){?>
<div class="leftcol">
	<div class="profileAvatar clearfix">
		<div class="photo">
			<img src="<?=resource_url('images/photo_'.strtolower($user['sex']).'.jpg')?>" width="40" height="40"/>
		</div>
		<?php if(isset($user['nickname'])){?>
		<div class="name"><a href="<?=site_url()?>"><?=$user['nickname']?></a></div>
		<? } ?>
	</div>
	<div class="profileMenu">
	
		<ul class="main-nav nav nav-list">
			<li class="nav-header">Account</li>
			<li class="<?=$page == "stream" ? 'active' : ''?>"><a href="<?=push_url()?>"><i class="icon-stream"></i>Stream</a></li>
			<li class="<?=$page == "characters" ? 'active' : ''?>"><a href="<?=push_url('characters/charlist')?>"><i class="icon-chars"></i>Characters</a></li>
			<li class="<?=$page == "settings" ? 'active' : ''?>"><a href="<?=push_url('account/settings')?>"><i class="icon-settings"></i>Settings</a></li>
			<li class="<?=$page == "vote" ? 'active' : ''?>"><a href="<?=push_url('vote')?>"><i class="icon-settings"></i>Vote</a></li>
			<li class="divider"></li>
			
			<li class="nav-header">Support</li>
			
			<li class="<?=$page == "help-guide" ? 'active' : ''?>"><a href="/help-guide"><i class="icon-guide"></i> Help Guide</a></li>
	
			<li class="divider"></li>

        </ul>
	</div>
</div>
<? } ?>
