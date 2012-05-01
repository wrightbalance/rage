<?php $this->load->view('layout/head_default') ?>
<body>
<div class="topBar">
	<div class="tileCenter clearfix">
		<div class="logo"><a href="<?=site_url()?>">
		<?php if(isset($details['_id'])) {?>
		<img src="<?=resource_url('images/logo2.png')?>" alt=""/>
		
		<? } else { ?>
		<img src="<?=resource_url('images/logo.png')?>" alt=""/>
		<? } ?>
		</a></div>
		<?php if(isset($showlogin) && $showlogin) {?>
		<div class="quicklogin">
			<?php $this->load->view('widget/quicklogin')?>
		</div>
		<? } ?>
		
		<?php if(isset($details['_id'])) {?>
	
		<div class="top-action">
			
			<div class="btn-toolbar">
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
		
	</div>
	

</div>

<div class="body">
<div class="tileCenter clearfix">
	<div class="content clearfix">
	
	
