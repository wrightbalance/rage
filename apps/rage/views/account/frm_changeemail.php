<form class="form-horizontal form" action="<?=site_url('account/update')?>">
<input type="hidden" value="changeemail" name="action"/>
<div class="response"></div>
	<fieldset class="fields">
		<div class="control-group">
			<label class="control-label" for="password">Password</label>
			<div class="controls">
			  <input type="password" class="input-xlarge" id="password" name="password">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="current_email">Current Email</label>
			<div class="controls">
			  <input type="text" class="input-xlarge" id="current_email" name="current_email">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="new_email">New Email</label>
			<div class="controls">
			  <input type="text" class="input-xlarge" id="new_email" name="new_email">
			</div>
		</div>

		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Save changes</button>
			<button class="btn">Cancel</button>
		</div>
	</fieldset>
</form>
