<div class="col1 clearfix">
	
	<div class="intro">
		<h1>News and Updates</h1>
		
		<div class="icontent">
			<hr>
			
			<div class="news features clearfix">
				
				<div class="features_details">
					<h5>RagnaGears now officially released.</h5>
					<span class="date">April 29, 2012</span>
					<p><b>Features-</b></p>
					<ul>
						<li>3rd Job Classes Enabled</li>
						<li>Lot of custom gears.</li>
						<li>Easy to Manage Your Account</li>
					</ul>
					<p><b>Drop Rate-</b></p>
					<ul>
						<li>Normal Monster Item: 100%</li>
						<li>Normal Monster Card: 75%</li>
						<li>MVP and Mini Boss Item: 100%</li>
						<li>MVP and Mini Boss Card: 10%</li>
					</ul>
					<p><b>Monsters-</b></p>
					<ul>
						<li>Baphomet Jr mob count in Prt_Maze03 is now 4x (100)</li>
						<li>Grand Peco mob count in yuno_fild08 is now 2x (160)</li>
						<li>Dokebi mob count in pay_dun04 is now 4x (160)</li>
						
					</ul>
					<p><b>Items-</b></p>
					<ul>
						<li>Yggdrasill Berry Drop rate is 75%</li>
						<li>Gold Dro rate is 100%</li>
					</ul>
				</div>
				
			</div>
			<hr>
			<!--
			<div class="features clearfix">
				<div class="features_details ">
					<h5>3rd Class Job</h5>
					<p>We have 12 3rd classe jobs with fully implemented skills. <br/> <button class="btn btn-mini btn-primary">Details</button></p>
				</div>
			</div>
			
			<div class="features clearfix">
				<div class="features_details ">
					<h5>Cool Website</h5>
					<p>Your account will be managed easily. We have facebook like feature. <br/> <button class="btn btn-mini btn-primary">Details</button></p>
				</div>
			</div>
			-->
			
			
			<div class="features clearfix">
		
				<div class="features_details">
					<a href="http://www.mediafire.com/download.php?h20xbbbgummmtd8" target="_blank" class="btn btn-large">Download (v1.1-Lion)</a>
				</div>
			</div>
			
		</div>
		
	</div>
	<!--
	<div class="newsbox shadow clearfix">
		<h3>Latest News</h3>
		
		<div class="nrow">
			<div class="avatar">
				
			</div>
			<div class="ncontent">
				<h4>Referral Points</h4>
				<span>Apr 20, 2012</span>
				<p>
					Lorem ipsum dolor sit amet, consectetuer adipiscing elit, 
					sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna 
					aliquam erat volutpat. Ut wisi enim ad minim veniam, 
					quis nostrud exerci tation ullamcorper suscipit lobortis
					 nisl ut aliquip ex ea commodo consequat.
				</p>
			</div>
		</div>
		
		
		<div class="paginate">
			<div class="btn-toolbar">
				<div class="btn-group">
				  <button class="btn">1</button>
				  <button class="btn">2</button>
				  <button class="btn">3</button>
				  <button class="btn">4</button>
				</div>
			</div>
		</div>
		
	</div>
	
	<div class="colsub shadow marginRight10">
		<h4>Top Killer</h4>
		<table class="table table-bordered table-striped table-ranking">
			<thead>
				<tr>
					<th width="20%">Rank #</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>Crusher</td>
				</tr>
				<tr>
					<td>2</td>
					<td>Sheldon</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Penny</td>
				</tr>
				<tr>
					<td>4</td>
					<td>Howard</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="colsub shadow"></div>
	
	-->
</div>
<div class="col2">
	
	<div class="regform" <?=isset($margindown) ? $margindown : ''?>>
		<h3><?=$formtitle?></h3>
		<?php $this->load->view("account/{$form}")?>
		
	</div>
	
</div>
