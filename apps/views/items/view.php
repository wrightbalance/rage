<div class="maincol wide">
	<?php 
		$icon = img("resources/images/icons/12137.gif",array('alt'=>"",'title'=>$items['description']));
		
		if(file_exists('./resources/images/icons/'.$items['id'].'.gif'))
		{
			$icon = img("resources/images/icons/{$items['id']}.gif",array('alt'=>"",'title'=>$items['description']));
		}	
		
	?>
	<h3>Item Details of <?php echo $items['name_japanese']?></h3>
	<br/>
	<table class="flexme">	
		<thead>
			<tr>
				<th width="120" colspan="2"></th>
				<th width="120" colspan="2">Attributes</th>
				<th width="120" colspan="2">Details</th>
			</tr>
		</thead>
		<tbody>
		
			<tr>
				<td width="120">
					<?php echo $icon?>
				</td>
				<td width="120"><span>Descriptions</span></td>
				<td ><span style="padding: 0 150px 0 0"><?php echo $items['description']?></span></td>
			</tr>
			<tr>
				<td width="120"></td>
				<td width="120"><span>Descriptions</span></td>
				<td ><span style="padding: 0 150px 0 0"><?php echo $items['description']?></span></td>
			</tr>
			<tr>
				<td width="120"></td>
				<td width="120"><span>Type</span></td>
				<td ><span style="padding: 0 50px 0 0"><?php echo itemTypes($items['type']) ? itemTypes($items['type']) : 'Unknown'?></span></td>
			</tr>
		</tbody>
	</table>

</div>
