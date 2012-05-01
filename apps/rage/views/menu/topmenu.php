<?php if(isset($details['_id'])) {?>

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
			<li><a href="/account"  class="ps">Account</a></li>
			<li><a href="/cms/pages" class="ps">Pages</a></li>
			<li><a href="/cms/news"  class="ps">News</a></li>

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
			<li><a href="/account/settings">Account Settings</a></li>
			<li><a href="/account/settings/changepass" class="ps">Change Password</a></li>
			<li><a href="/account/settings/changeemail">Change E-mail</a></li>
			<li class="divider"></li>
			<li><a href="<?=site_url('account/signout')?>">Logout</a></li>
		  </ul>
		</div>
		
		
	</div>
</div>
<? } ?>
