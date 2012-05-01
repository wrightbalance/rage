<div class="maincol">
	<h3>Characters</h3>
	
	<table class="table table-bordered table-striped">
	  <thead>
		  <tr>
			<th width="25">Slot</th>
			<th width="200">Character Name</th>
			<th width="150">Job</th>
			<th width="100">Level</th>
			<th width="70"></th>
		  </tr>
		</thead>
		<tbody>
		
		<?php if(isset($characters) && $characters){ ?> 	
		  <?php foreach($characters as $char){ ?>
			  <tr>
				<td style="text-align: center"><?=$char['char_num']?></td>
				<td><?=$char['name']?></td>
				<td><?=jobClass($char['class'])?></td>
				<td>150</td>
				<td>
					<!--
					<select class="reset" name="reset" data-charid="<?=$char['char_id']?>">
						<option value="">-Reset</option>
						<option value="1">Map</option>
						<option value="2">Equipment</option>
						<option value="3">Hair</option>
						<option value="4">All</option>
					</select>
					-->
					<div class="btn-group">
					  <button class="btn dropdown-toggle" data-toggle="dropdown">Reset <span class="caret"></span></button>
					  <ul class="dropdown-menu char_reset">
						<li><a href="#" data-act="1" data-charid="<?=$char['char_id']?>">Map</a></li>
						<li><a href="#" data-act="2" data-charid="<?=$char['char_id']?>">Equipment</a></li>
						<li><a href="#" data-act="3" data-charid="<?=$char['char_id']?>">Hair</a></li>
						<li><a href="#" data-act="4" data-charid="<?=$char['char_id']?>">All</a></li>
					  </ul>
					</div>
				</td>
			  </tr>
		  <? } ?>
		<? } ?> 

		</tbody>
	</table>
	
</div>
<?php $this->load->view('widget/rightcol')?>
<?php $this->load->view('character/modal/reset')?>
