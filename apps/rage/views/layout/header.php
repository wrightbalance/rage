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
	</div>
</div>

<div class="body">
<div class="tileCenter clearfix">
	<div class="content clearfix">
	
	
