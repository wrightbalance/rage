<div class="maincol">
	
	<div class="regform" style="width: 300px; margin: 150px auto; padding: 15px">
		<h3>Forgot Password</h3>
		<form class="form form-horizontal" method="post" action="<?=site_url('account/forgotpassword')?>">
		<div class="response"></div>
		<div class="fields">
	
			<div class="frow email">
				<label>E-mail Address</label>
				<input type="text" name="email"/>
				<div class="error_message"></div>
			</div>
	
			<div class="frow_btn preloader clearfix">
				<button class="btn btn-primary floatleft">Forgot Password</button><div class="loaders"></div>
			</div>

		</div>
		
	</form>
	</div>
</div>
