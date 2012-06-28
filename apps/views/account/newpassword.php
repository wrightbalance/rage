<div class="maincol">
	
	<div class="regform" style="width: 300px; margin: 150px auto; padding: 15px">
		<h3>Set New Password</h3>
		<form class="form form-horizontal" method="post" action="<?=site_url('account/setPassword')?>">
		<input type="hidden" name="account_id" value="<?=$details['account_id']?>"/>
		<input type="hidden" name="code" value="<?=$code?>"/>
		<div class="response"></div>
		<div class="fields">
	
			<div class="frow email">
				<label>New password</label>
				<input type="password" name="new_password"/>
			</div>
			
			<div class="frow email">
				<label>Confirm new password</label>
				<input type="password" name="confirm_password"/>
			</div>
	
			<div class="frow_btn preloader clearfix">
				<button class="btn btn-primary floatleft">Set Password</button><div class="loaders"></div>
			</div>

		</div>
		
	</form>
	</div>
</div>
