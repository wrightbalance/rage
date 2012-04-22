<div class="maincol">
	<h3>Account Settings</h3>
	<ul class="tab nav nav-tabs">
		<li class="active"><a href="#">Change Password</a></li>
		<li><a href="#">Change Email</a></li>
		<li><a href="#">Lock Account</a></li>
	</ul>
	<div class="tpane pactive">
		<?php $this->load->view('account/frm_changepassword')?>
	</div>
	
	<div class="tpane">
		<?php $this->load->view('account/frm_changeemail')?>
	</div>
	
	<div class="tpane">
		<?php $this->load->view('account/frm_lockaccount')?>
	</div>

</div>
<?php $this->load->view('widget/rightcol')?>
