<?php if($user){?>
<div class="leftcol">
	<div class="profileAvatar clearfix">
		<div class="photo">
			<img src="<?=resource_url('images/photo_'.strtolower($user['sex']).'.jpg')?>" width="40" height="40"/>
		</div>
		<?php if(isset($user['nickname'])){?>
		<div class="name"><a href="<?=push_url('account/settings')?>" class="ps"><?=$user['nickname']?></a></div>
		<? } ?>
	</div>
	<div class="profileMenu">
	
		<ul class="main-nav nav nav-list">
			<li class="nav-header">Account</li>
			<li class="<?=$page == "main" ? 'active' : ''?>"><a href="<?=push_url()?>"><i class="icon-road <?=$page == "main" ? 'icon-white' : ''?>"></i>Stream</a></li>
			<li class="<?=$page == "characters" ? 'active' : ''?>"><a href="<?=push_url('characters/view')?>"><i class="icon-user"></i>Characters</a></li>
			<li class="<?=$page == "settings" ? 'active' : ''?>"><a href="<?=push_url('account/settings')?>"><i class="icon-cog"></i>Settings</a></li>
			<li class="<?=$page == "vote" ? 'active' : ''?>"><a href="<?=push_url('vote')?>"><i class="icon-thumbs-up"></i>Vote</a></li>
			<li class="divider"></li>
			<li class="nav-header">Rankings</li>
			<li class="<?=$page == "rankings" ? 'active' : ''?>"><a href="<?=push_url('rankings/pvp')?>"><i class="icon-star"></i>PVP Ladder</a></li>
			<li class="divider"></li>
			<li class="nav-header">Database</li>
			<li class="<?=$page == "items" ? 'active' : ''?>"><a href="<?=push_url('items')?>"><i class="icon-list-alt"></i>Items</a></li>
			<li class="divider"></li>
			
			<li class="nav-header">Support</li>
			
			<li class="<?=$page == "help-guide" ? 'active' : ''?>"><a href="<?=push_url('ticket')?>"><i class="icon-tags"></i> Ticket</a></li>
			<li class="<?=$page == "help-guide" ? 'active' : ''?>"><a href="/help-guide"><i class="icon-guide"></i> Help Guide</a></li>
	
			<li class="divider"></li>

        </ul>
	</div>
</div>
<? } ?>
