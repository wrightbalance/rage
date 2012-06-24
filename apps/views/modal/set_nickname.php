<div class="modal" id="set_nickname">
  <div class="modal-header">
    <h3 class="mtitle">Set your nickname</h3>
  </div>
  <div class="modal-body">
  
	
	
	<form class="form-horizontal form" method="post" action="<?=site_url('account/set_nickname')?>">
		<input type="hidden" name="action" value="changepass"/>
		<div class="response"></div>
		<fieldset class="fields">
			<div class="alert alert-error">
				Please input your desired Nickname. This will be used as your display name throughout the website.
			</div>
			<div class="control-group">
				<label class="control-label" for="nickname">Your Nickname</label>
				<div class="controls">
				  <input type="text" class="input-xlarge" id="nickname" name="nickname">
				</div>
			</div>
		

			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</fieldset>
	</form>

    
  </div>
</div>
