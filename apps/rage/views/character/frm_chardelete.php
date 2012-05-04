<div class="char_delete_confirm" style="display:none">


<form class="form-horizontal form deletechar" method="post" action="<?=site_url('characters/delete')?>">
	<input type="hidden" name="action" value="changepass"/>
	<div class="response"></div>
	<fieldset class="fields">
		<p><span class="label label-warning">Warning</span> Once the character has been deleted you will no longer recover it.</p>	
<br/>
	
		<div class="control-group">
			<label class="control-label" for="user_pass">Your Password</label>
			<div class="controls">
			  <input type="password" class="input-xlarge" id="user_pass" name="user_pass">
			</div>
		</div>
		
	</fieldset>
</form>
</div>
