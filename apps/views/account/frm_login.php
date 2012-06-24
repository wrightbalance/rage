<form class="form-horizontal form mainlogin" method="post" action="<?=site_url('account/auth')?>">
	<div class="response"></div>
	<div class="fields">
		<div class="frow">
			<label>Username</label>
			<input type="text" name="username"/>
		</div>

		<div class="frow">
			<label>Password</label>
			<input type="password" name="password"/>
		</div>
		
		<div class="frow_btn">
			<button class="btn btn-primary">Login</button><div class="loaders"></div>
		</div>
		
		<div class="frow graybtn">
			<a href="<?=site_url()?>" class="btn btn-success">New to RagnaGears? Create your account</a>
		</div>
	</div>
</form>
