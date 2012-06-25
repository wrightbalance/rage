<div class="col1 clearfix">
	
	<div id="loadcontent">
		<?=isset($page_content) ? $page_content : ''?>
	</div>

</div>
<div class="col2">
	
	<div class="regform" <?=isset($margindown) ? $margindown : ''?>>
		<h3><?=$formtitle?></h3>
		<?php $this->load->view("account/{$form}")?>
		
	</div>
	
</div>
