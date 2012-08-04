<?php if(empty($user)){?>
<div class="quicklogin">
<form class="form form-inline form" method="post" action="<?=site_url('account/auth')?>">
	<input type="hidden" name="action" value="quicklogin"/>
	<div class="response"></div>
	<div class="fields">
		<input type="text" class="input-small" placeholder="Username" name="username">
		<input type="password" class="input-small" placeholder="Password" name="password">
		<button type="submit" class="btn btn-primary">Sign in</button>
		<a href="<?=site_url('account/forgot')?>">Forgot Password?</a>
	</div>
</form>
</div>
<? } ?>
