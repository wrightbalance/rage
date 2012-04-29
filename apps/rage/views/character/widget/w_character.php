<div class="maincol">
	<h3>Characters</h3>
	
	<table class="table table-bordered table-striped">
	  <thead>
		  <tr>
			<th width="25">Slot</th>
			<th width="200">Character Name</th>
			<th width="200">Job</th>
			<th width="25">Level</th>
			<th>Reset</th>
		  </tr>
		</thead>
		<tbody>
		
		<?php if(isset($characters) && $characters){ ?> 	
		  <?php foreach($characters as $char){ ?>
			  <tr>
				<td align="center"><?=$char['char_num']?></td>
				<td><?=$char['name']?></td>
				<td><?=jobClass($char['class'])?></td>
				<td>150</td>
				<td>
					<select class="reset" name="reset" data-charid="<?=$char['char_id']?>">
						<option value="">-Reset</option>
						<option value="1">Map</option>
						<option value="2">Equipment</option>
						<option value="3">Hair</option>
						<option value="4">All</option>
					</select>
				</td>
			  </tr>
		  <? } ?>
		<? } ?> 

		</tbody>
	</table>
	
</div>
<?php $this->load->view('widget/rightcol')?>
<?php $this->load->view('modal/reset')?>
