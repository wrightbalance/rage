<div class="maincol wide">
	<h3>Items</h3>
	<?php if($this->authorize){?>
	<div class="cms_action clearfix">
		<button class="btn floatright create_news" data-btnstate="create"><i class="icon-pencil"></i> Add Item</button>
	</div>
	<? } ?>
	<div class="epane" style="display: none">
	<?php $this->load->view('items/form/modify')?>
	</div>
	<div class="vpane">
		<table class="itemsFlex"></table>
	</div>
</div>
