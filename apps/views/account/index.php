<div class="maincol wide">
	<h3>All Accounts</h3>
	<hr>
	
	
	
	<div class="buttonActions">
		<div class="btn-group">
		  <button class="btn btn-primary">Views</button>
		  <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
		  <ul class="dropdown-menu">
			<li><a href="#">Show Banned Accounts</a></li>
			<li><a href="#">Show Admin Accounts</a></li>
			<li><a href="#">Show In-active Accounts</a></li>

		  </ul>
		</div>
	</div>
	
	<table class="accounts"></table>


</div>

<?php $this->load->view('account/modal/view')?>
