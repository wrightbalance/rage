<?php if($user){?>
<div class="leftcol">
	<div class="profileAvatar clearfix">
		<div class="photo">
			<?php 
				$photo = resource_url('images/photo_'.strtolower($user['sex']).'.jpg');
				
				if(file_exists('./resources/images/avatar/'.$this->accountid.'.jpg')){
					$photo = resource_url('images/avatar/'.$this->accountid.'.jpg');
				}
					
			?>
			
			<img src="<?=$photo?>" width="40" height="40"/>
		</div>
		<?php if(isset($user['nickname'])){?>
		<div class="name"><a href="<?=push_url('account/settings')?>" class="ps"><?=$user['nickname']?></a></div>
		<? } ?>
	</div>
	<div class="profileMenu">
	
		<ul class="main-nav nav nav-list">
			
			<?php if(isset($pages) && $pages){?>
				
				
				<li class="nav-header">Navigation</li>
				<li><a href="<?=push_url()?>" class="ps">Home</a></li>
				<?php foreach($pages as $p){?>
				<li><a href="<?=push_url("ref/{$p['friendly_url']}")?>" class="ps"><?php echo $p['title']?></a></li>
				<?php } ?>
				
			
			<?php } ?>
			<li class="divider"></li>
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
			
		

        </ul>
	</div>
</div>
<? } ?>
