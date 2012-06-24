<div class="maincol wide">
	
	<h3>Pages Content Management</h3>
	<div class="cms_action clearfix">
		<button class="btn floatright create_news" data-btnstate="create"><i class="icon-pencil"></i> Create Page</button>
	</div>
	<hr>
	<div class="epane" style="display: none">
	<?php $this->load->view('cms/form/edit_page')?>
	</div>
	<div class="vpane">
		<table class="pagesFlex"></table>
	</div>

</div>
