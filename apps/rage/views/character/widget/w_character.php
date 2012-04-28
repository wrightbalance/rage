<div class="maincol">
	<h3>Characters</h3>
	
	<table class="table table-bordered table-striped">
	  <thead>
		  <tr>
			<th>Slot</th>
			<th>Character Name</th>
			<th>Job</th>
			<th>Level</th>
			<th></th>
		  </tr>
		</thead>
		<tbody>
		
		<?php if(isset($characters) && $characters){ ?> 	
		  <?php foreach($characters as $char){ ?>
			  <tr>
				<td><?=$char['char_num']?></td>
				<td><?=$char['name']?></td>
				<td>Sura</td>
				<td>150</td>
				<td>
					<select style="width: 75px">
						<option value="">-Reset</option>
						<option value="1">Map</option>
						<option value="2">Look</option>
						<option value="3">Hair</option>
					</select>
				</td>
			  </tr>
		  <? } ?>
		<? } ?> 

		</tbody>
	</table>
	
</div>
<?php $this->load->view('widget/rightcol')?>
