<form class="form-horizontal form" method="post" action="<?=site_url('accounts/update')?>">
	<input type="hidden" name="action" value="changepass"/>
	<div class="response"></div>
	<fieldset class="fields">
		<div class="control-group">
			<label class="control-label" for="old_password">Old Password</label>
			<div class="controls">
			  <input type="password" class="input-xlarge" id="old_password" name="old_password">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="new_password">New Password</label>
			<div class="controls">
			  <input type="password" class="input-xlarge" id="new_password" name="new_password">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="confirm_password">Confirm Password</label>
			<div class="controls">
			  <input type="password" class="input-xlarge" id="confirm_password" name="confirm_password">
			</div>
		</div>

		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Save changes</button>
			<button class="btn">Cancel</button>
		</div>
	</fieldset>
</form>
