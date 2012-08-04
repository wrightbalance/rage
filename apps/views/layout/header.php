<?php $this->load->view('layout/head_default') ?>
<body>
<div class="topBar">
	<div class="tileCenter clearfix">
		<div class="logo"><a href="<?=site_url()?>">
			<img src="<?=resource_url('images/logo.jpg')?>"/>
		</a></div>
	
		
		<?php $this->load->view('menu/topmenu')?>
		<?php $this->load->view('widget/toplogin')?>
		<?php if($this->accountid == FALSE){?>
		<div class="clear"></div>
		
		<?php $this->load->view('menu/nav')?>
		<? } ?>
	</div>
	
	
</div>

<div class="body">
<div class="tileCenter clearfix">
	<div class="content clearfix">
		
		
		<?php $this->load->view('widget/sidebar')?>
	
	
