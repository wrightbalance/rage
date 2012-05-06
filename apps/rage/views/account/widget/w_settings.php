<?php if(!isset($settings)) { 
	$settings = "";	
}?>

<div class="maincol">
	<h3>Account Settings</h3>
	<ul class="tab nav nav-tabs">
		<li class="<?=empty($settings) ? 'active' : ''?>"><a href="/accounts/settings" data-setup="plane" class="ps">Account Info</a></li>
		<li class="<?=$settings == "changepass" ? 'active' : ''?>"><a href="/accounts/settings/changepass" data-setup="plane" class="ps">Change Password</a></li>
		<li class="<?=$settings == "changeemail" ? 'active' : ''?>"><a href="/accounts/settings/changeemail" data-setup="plane" class="ps">Change Email</a></li>
		<li style="display: none"><a href="#">Lock Account</a></li>
	</ul>
	

	<div class="tpane pactive">
			<table class="table table-bordered table-striped">
				<tbody>
					<tr>
						<td width="120">Display Name</td>
						<td><?=$details['nickname']?></td>
					</tr>
					<tr>
						<td width="120">User Name</td>
						<td><?=$account['userid']?></td>
					</tr>
					<tr>
						<td width="120">Gender</td>
						<td><?=$account['sex'] == "M" ? "Male" : "Female"?></td>
					</tr>
					<tr>
						<td width="120">Birth Date</td>
						<?php if($account['birthdate'] !== "0000-00-00") { ?> 
						<td><?=date('F d, Y',strtotime($account['lastlogin']))?></td>
						<? } else { ?> 
						<td>-</td>
						<? } ?>
					</tr>
					<tr>
						<td width="120">Last IP</td>
						<td><?=$account['last_ip']?></td>
					</tr>
					<tr>
						<td width="120">Last Login</td>
						<td><?=date('F d, Y H:i:s',strtotime($account['lastlogin']))?></td>
					</tr>
				</tbody>
			</table>
		
		
	</div>
	<div class="tpane">
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
