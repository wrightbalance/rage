<?php if(!isset($settings)) { 
	$settings = "";	
}?>

<div class="bodycontent clearfix" id="loadcontent">
<div class="maincol">
	<h3>Account Settings</h3>
	<ul class="tab nav nav-tabs">
		<li class="<?=empty($settings) ? 'active' : ''?>"><a href="/account/settings" data-setup="plane" class="ps">Account Info</a></li>
		<li class="<?=$settings == "changepass" ? 'active' : ''?>"><a href="/account/settings/changepass" data-setup="plane" class="ps">Change Password</a></li>
		<li class="<?=$settings == "changeemail" ? 'active' : ''?>"><a href="/account/settings/changeemail" data-setup="plane" class="ps">Change Email</a></li>
		<li style="display: none"><a href="#">Lock Account</a></li>
	</ul>
	

	<div class="tpane pactive">
			<div class="avatar_outer">
				
				<div class="avatar">
					<?php if(isset($user['avatar']) && file_exists('./resources/images/avatar/'.$user['avatar'])){?>
						<img src="<?=resource_url("images/avatar/{$user['avatar']}")?>" alt=""/>
					<? } ?>
				</div>
				
				<div class="clear"></div>
				<div class="uploadify_action" style="position: relative;">
					<input type="file" id="file_upload" style="display: none"/>
				</div>
			</div>
			<div class="account_details">
			<table class="flexme">
				<thead>
					<tr>
						<th width="100" colspan="2"></th>
						<th width="270" colspan="2"></th>
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
						<td><?=date('F d, Y',strtotime($user['birthdate']))?></td>
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
						<?php if(!empty($user['lastlogin'])) { ?> 
						<td><?=date('F d, Y H:i:s',strtotime($user['lastlogin']))?></td>
							<? } else { ?> 
						<td>-</td>
						<? } ?>
					</tr>
				</tbody>
			</table>
			</div>
		
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
</div>
