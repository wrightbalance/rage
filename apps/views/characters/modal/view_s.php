<div class="modal-header">
<a class="close" data-dismiss="modal">×</a>
<h3>Viewing <?=$char['name']?> - <?=jobClass($char['class'])?></h3>
</div>
<div class="modal-body clearfix">

<?php $this->load->view('characters/frm_chardelete')?>

<div class="char_image">
	<?php if($user['sex'] == "M"){?>
		<img src="<?=resource_url('images/jobs/male/'.$char['class'].'.png')?>" alt=""/>
	<? } else { ?> 
		<img src="<?=resource_url('images/jobs/female/'.$char['class'].'.png')?>" alt=""/>
	<? } ?>
</div>

<div class="char_stats">
	<table class="table table-bordered table-striped">
		<tbody class="loadchar">
		<tr>
			<td width="20">Str</td>
			<td><b><?=$char['str']?></b></td>
			<td width="20">Int</td>
			<td><b><?=$char['int']?></b></td>
		</tr>
		<tr>
			<td>Agi</td>
			<td><b><?=$char['agi']?></b></td>
			<td>Dex</td>
			<td><b><?=$char['dex']?></b></td>
		</tr>
		<tr>
			<td>Vit</td>
			<td><b><?=$char['vit']?></b></td>
			<td>Luk</td>
			<td><b><?=$char['luk']?></b></td>
		</tr>
		</tbody>
	</table>
</div>

</div>
<div class="modal-footer">
	<a href="#" class="btn btn-danger delete_char" data-delstate="showform">Delete Character</a>
	<a href="#" class="btn" data-dismiss="modal">Close</a>
</div>
