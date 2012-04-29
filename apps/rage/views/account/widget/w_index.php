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
			
		  </tr>
		</thead>
		<tbody>
		<?php if(isset($accounts) && $accounts) { ?> 
		<?php foreach($accounts as $account) { ?>
		  <tr>
			<td><?=$account['account_id']?></td>
			<td><?=$account['userid']?></td>
			<td><?=$account['email']?></td>
			
			<td><?=$account['group_id']?></td>
			<td><?=$account['last_ip']?></td>
		  </tr>
		  <? } ?>
	   <? } ?>
		</tbody>
	</table>
</div>

