<?php $this->load->view('layout/head_default') ?>
<body>
<div class="topBar">
	<div class="tileCenter clearfix">
		<div class="logo">RagnaGears&trade;</div>
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
	
	
