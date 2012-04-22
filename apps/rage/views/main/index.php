<div class="col1 clearfix">
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
	
</div>
<div class="col2">
	
	<div class="regform shadow">
		<h3><?=$formtitle?></h3>
		<?php $this->load->view("account/{$form}")?>
		
	</div>
	
</div>
