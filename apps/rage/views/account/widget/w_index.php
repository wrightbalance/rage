<div class="maincol wide">
	<h3>All Accounts</h3>

	<table class="table table-bordered table-striped">
	  <thead>
		  <tr>
			<th>Account ID</th>
			<th>Username</th>
			<th>E-mail</th>
			<th>Group ID</th>
			<th>IP</th>
			<th>Last Login</th>
			
		  </tr>
		</thead>
		<tbody>
		<?php if(isset($accounts) && $accounts) { ?> 
		<?php foreach($accounts as $account) { ?>
		  <tr>
			<td><a href="#" class="view" data-aid="<?=$account['account_id']?>"><?=$account['account_id']?></a></td>
			<td><?=$account['userid']?></td>
			<td><?=$account['email']?></td>
			<td><?=$account['group_id']?></td>
			<td><?=$account['last_ip']?></td>
			<td><?=date('M d, Y H:i:s',strtotime($account['lastlogin']))?></td>
		  </tr>
		  <? } ?>
	   <? } ?>
		</tbody>
	</table>
</div>

<?php $this->load->view('account/modal/view')?>
