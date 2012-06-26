<div class="maincol wide">
	<?php 
		$icon = "";
		
		if(file_exists('./resources/images/items/large/'.$items['id'].'.gif'))
		{
			$icon = img("resources/images/items/large/{$items['id']}.gif",array('alt'=>"",'title'=>$items['description']));
		}	
		
	?>
	<h3>Item Details of <strong><?php echo $items['name_japanese']?></strong></h3>
	<br/>
	<div class="item-image <?php echo itemTypes($items['type']) ? itemTypes($items['type']) : 'Unknown'?>">
		<?=$icon?>
	</div>
	<br/>
	<table class="flexme" style="width: 500px;">	
		<thead>
			<tr>
				<th width="70" colspan="2">Attributes</th>
				<th width="490" colspan="2">Details</th>
			</tr>
		</thead>
		<tbody>
		
			<tr>
				<td width="120"><span>Descriptions</span></td>
				<td ><?php echo $items['description']?></td>
			</tr>
			<tr>
				<td width="120"><span>Type</span></td>
				<td ><?php echo itemTypes($items['type']) ? itemTypes($items['type']) : 'Unknown'?></td>
			</tr>
			<tr>
				<td width="120"><span>Buy</span></td>
				<td ><?php echo $items['price_buy'] ? number_format($items['price_buy']) : 0?></td>
			</tr>
			<tr>
				<td width="120"><span>Sell</span></td>
				<td ><?php echo $items['price_sell'] ? number_format($items['price_sell']) : 0?></td>
			</tr>
			<tr>
				<td width="120"><span>Defence</span></td>
				<td ><?php echo $items['defence']?></td>
			</tr>
			<tr>
				<td width="120"><span>Range</span></td>
				<td ><?php echo $items['range']?></td>
			</tr>
		</tbody>
	</table>

</div>
