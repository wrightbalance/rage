<div class="col1 clearfix">
	
	<div class="intro">
		<h1>News and Updates</h1>
		
		<div class="icontent">
			
		</div>
		
	</div>

</div>
<div class="col2">
	
	<div class="regform" <?=isset($margindown) ? $margindown : ''?>>
		<h3><?=$formtitle?></h3>
		<?php $this->load->view("account/{$form}")?>
		
	</div>
	
</div>
