<form class="form form-horizontal mainreg" method="post" action="<?=site_url('account/post')?>">
	<div class="response"></div>
	<div class="fields">
		<div class="frow username">
			<label>Username</label>
			<input type="text" name="username"/>
			<div class="error_message"></div>
		</div>

		<div class="frow password">
			<label>Password</label>
			<input type="password" name="password"/>
			<div class="error_message"></div>
		</div>
		
		<div class="frow email">
			<label>E-mail Address</label>
			<input type="text" name="email"/>
			<div class="error_message"></div>
		</div>
		
		<div class="frow gender">
			<label>I am</label>
			<select name="gender">
				<option value="">Select Sex</option>
				<option value="M">Male</option>
				<option value="F">Female</option>
			</select>
			<div class="error_message"></div>
		</div>
		
		<?php if(config_item('AddBirthday')){?>
		<div class="frow month day year">
			<label>Birthdate</label>
			<select name="month" class="wsmall">
				<option value="">Month</option>
				<option value="1">Jan</option>
				<option value="2">Feb</option>
				<option value="3">Mar</option>
				<option value="4">Apr</option>
				<option value="5">May</option>
				<option value="6">Jun</option>
				<option value="7">Jul</option>
				<option value="8">Aug</option>
				<option value="9">Sep</option>
				<option value="10">Oct</option>
				<option value="11">Nov</option>
				<option value="12">Dec</option>
			</select>
			<select name="day" class="wsmall">
				<option value="">Day</option>
				<?php for($x=1;$x<=31; $x++){?>
				<option value="<?=$x?>"><?=$x?></option>
				<? } ?>
			</select>
			<select name="year" class="wsmall">
				<option value="">Year</option>
				<?php for($x=date('Y')-10;$x>=1975; $x--){?>
				<option value="<?=$x?>"><?=$x?></option>
				<? } ?>
			</select>
			<div class="error_message"></div>
		</div>
		
		<? } ?>
		
		<div class="frow nickname">
			<label>Nick Name</label>
			<input type="text" name="nickname"/>
			<div class="error_message"></div>
		</div>
		
		<div class="frow_btn preloader clearfix">
			<button class="btn btn-primary floatleft">Create Account</button><div class="loaders"></div>
		</div>

	</div>
	
</form>
