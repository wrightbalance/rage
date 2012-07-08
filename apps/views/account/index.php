<div class="maincol wide">
	<h3>All Accounts</h3>
	<hr>
	
	
	
	<div class="buttonActions">
		<div class="btn-group">
		  <button class="btn btn-primary">Views</button>
		  <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
		  <ul class="dropdown-menu views">
			<li><a href="#" data-views="all">Show All</a></li>
			<li><a href="#" data-views="banned">Show Banned Accounts</a></li>
			<li><a href="#" data-views="admin">Show Admin Accounts</a></li>
		  </ul>
		</div>
	</div>
	
	<table class="accounts"></table>


</div>

<?php $this->load->view('account/modal/view')?>
