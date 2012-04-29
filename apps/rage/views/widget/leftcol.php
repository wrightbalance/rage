<div class="leftcol">
	<div class="profileAvatar clearfix">
		<div class="photo">
			<img src="<?=resource_url('images/photo_'.strtolower($details['sex']).'.jpg')?>" width="40" height="40"/>
		</div>
		<div class="name"><a href=""><?=$details['nickname']?></a></div>
	</div>
	<div class="profileMenu">
	
		<ul class="main-nav nav nav-list">
			<li class="nav-header">Account</li>
			<li class="<?=$page == "stream" ? 'active' : ''?>"><a href="/"><i class="<?=$page == "stream" ? 'icon-white' : ''?>  icon-list-alt"></i> Stream</a></li>
			<li class="<?=$page == "character" ? 'active' : ''?>"><a href="/characters"><i class="<?=$page == "character" ? 'icon-white' : ''?> icon-user"></i> Characters</a></li>
			<li class="<?=$page == "storage" ? 'active' : ''?>"><a href="/characters/storage"><i class="<?=$page == "storage" ? 'icon-white' : ''?> icon-inbox"></i> Storage</a></li>
			<li class="<?=$page == "settings" ? 'active' : ''?>"><a href="/account/settings"><i class="<?=$page == "settings" ? 'icon-white' : ''?> icon-cog"></i> Settings</a></li>
			
			<li class="divider"></li>
			
			<li class="nav-header">Support</li>
			<li class="<?=$page == "help-guide" ? 'active' : ''?>"><a href="/help-guide"><i class="<?=$page == "help-guide" ? 'icon-white' : ''?> icon-question-sign"></i> Help Guide</a></li>
			<li><a href="/ticket/file"><i class="icon-file"></i> File a Ticket</a></li>
			
			<li class="divider"></li>
			
			<?php if(isset($isAdmin) && $isAdmin) { ?> 
			<li class="nav-header">Admin</li>
			<li class="<?=$page == "account" ? 'active' : ''?>"><a href="/account"><i class="<?=$page == "account" ? 'icon-white' : ''?> icon-question-sign"></i> Accounts</a></li>
			<? } ?>
			<li class="divider"></li>
			
			<li><a href="/account/signout"><i class="icon-off"></i> Logout</a></li>
        </ul>
	</div>
</div>
