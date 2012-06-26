<?php if(!isset($settings)) { 
	$settings = "";	
}?>

<div class="maincol">
	<h3>Account Settings</h3>
	<ul class="tab nav nav-tabs">
		<li class="<?=empty($settings) ? 'active' : ''?>"><a href="/account/settings" data-setup="plane" class="ps">Account Info</a></li>
		<li class="<?=$settings == "changepass" ? 'active' : ''?>"><a href="/account/settings/changepass" data-setup="plane" class="ps">Change Password</a></li>
		<li class="<?=$settings == "changeemail" ? 'active' : ''?>"><a href="/account/settings/changeemail" data-setup="plane" class="ps">Change Email</a></li>
		<li style="display: none"><a href="#">Lock Account</a></li>
	</ul>
	

	<div class="tpane pactive">
			<table class="flexme">
					<thead>
			<tr>
				<th width="100" colspan="2"></th>
				<th width="300" colspan="2"></th>
			</tr>
		</thead>
				<tbody>
					<tr>
						<td width="120"><span style="padding: 0 20px 0 0">Display Name</span></td>
						<td width="400"><?=$user['nickname']?></td>
					</tr>
					<tr>
						<td width="120">User Name</td>
						<td><?=$user['userid']?></td>
					</tr>
					<tr>
						<td width="120">Gender</td>
						<td><?=$user['sex'] == "M" ? "Male" : "Female"?></td>
					</tr>
					<tr>
						<td width="120">Birth Date</td>
						<?php if($user['birthdate'] !== "0000-00-00") { ?> 
						<td><?=date('F d, Y',strtotime($user['lastlogin']))?></td>
						<? } else { ?> 
						<td>-</td>
						<? } ?>
					</tr>
					<tr>
						<td width="120">Last IP</td>
						<td><?=$user['last_ip']?></td>
					</tr>
					<tr>
						<td width="120">Last Login</td>
						<td><?=date('F d, Y H:i:s',strtotime($user['lastlogin']))?></td>
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
