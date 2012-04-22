		</div>
	</div>
</div>
<div class="footer">
	<div class="tileCenter">
		RagnaGears &copy; 2012
	</div>
</div>

<script type="text/javascript">
	var root = "<?=site_url()?>";
	
	<?php if(isset($details['_id'])) {?>
	var accountid = <?=$details['_id']?>;
	var nickname = "<?=$details['nickname']?>";
	var photo_path = "<?=resource_url('images/photo_'.strtolower($details['sex']).'.jpg')?>";
	var gender = "<?=$details['sex']?>";
	<? } ?>
	
</script>


<?php if(!isset($jsgroup)) $jsgroup = "default"?>

<script type="text/javascript" src="<?=site_url("mini/js/{$jsgroup}/".mtime('js',$jsgroup).'.js')?>"></script>

</body>
</html>
