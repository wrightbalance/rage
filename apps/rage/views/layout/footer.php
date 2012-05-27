		</div>
	</div>
</div>


<?php $this->load->view('modal/loader')?>

<?php if(isset($details)){?>
<?php if(!isset($details['nickname']) && !$details['nickname']){?>
<?php $this->load->view('modal/set_nickname')?>
<? } ?>
<? } ?>

<div class="footer">
	<div class="tileCenter">
		RagnaGears &copy; 2012 ~ Brought to you by <a href="">jingcleovil</a>
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
