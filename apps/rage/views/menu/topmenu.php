<div class="topnav2">
	<a href="" class=""><i class="curonline"></i>CURRENT ONLINE</a>
	<a href="" class=""><i class="rankings"></i>RANKINGS</a>
	<a href="" class=""><i class="info"></i>INFORMATION</a>
</div>
<?php if(isset($details['account_id'])) {?>

<div class="top-action">
	
	<div class="btn-toolbar">
		
		<?php 
			$groupid = $this->session->userdata('groupid');
		?>
		<?php if($groupid > 90){?>
		<!--ADMIN-->
		<div class="btn-group">
		  <button class="btn" onclick="location.href='<?=site_url()?>'"><i class="icon-book"></i> Admin Dashboard</button>
		  <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
		  <ul class="dropdown-menu">
			<li><a href="<?=config_item('base_uri')?>/accounts"  class="ps">Account</a></li>
			<li><a href="<?=config_item('base_uri')?>/characters"  class="ps">Characters</a></li>
			<li><a href="<?=config_item('base_uri')?>/cms/pages" class="ps">Pages</a></li>
			<li><a href="<?=config_item('base_uri')?>/cms/news"  class="ps">News</a></li>

		  </ul>
		</div>
		<? } ?>
		
		<div class="btn-group">
		  <button class="btn"><i class="icon-envelope"></i> Messages</button>
		  <button class="btn"><i class="icon-check"></i> Notifications</button>
		</div>

		
		<div class="btn-group">
		  <button class="btn" onclick="location.href='<?=site_url()?>'"><i class="icon-home"></i> Home</button>
		  <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
		  <ul class="dropdown-menu">
			<li><a href="<?=config_item('base_uri')?>/accounts/settings">Account Settings</a></li>
			<li><a href="<?=config_item('base_uri')?>/accounts/settings/changepass" class="ps">Change Password</a></li>
			<li><a href="<?=config_item('base_uri')?>/accounts/settings/changeemail">Change E-mail</a></li>
			<li class="divider"></li>
			<li><a href="<?=site_url('accounts/signout')?>">Logout</a></li>
		  </ul>
		</div>
		
		
	</div>
</div>
<? } ?>
