		</div>
	</div>
</div>


<?php $this->load->view('modal/loader')?>

<?php if(isset($user)){?>
<?php if(!isset($user['nickname']) && !$user['nickname']){?>
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
	
	<?php if(isset($user['account_id'])) {?>
	var accountid = <?=$user['account_id']?>;
	var nickname = "<?=$user['nickname']?>";
	var photo_path = "<?=resource_url('images/photo_'.strtolower($user['sex']).'.jpg')?>";
	var gender = "<?=$user['sex']?>";
	<? } ?>
	
</script>


<?php if(!isset($jsgroup)) $jsgroup = "default"?>

<script type="text/javascript" src="<?=site_url("mini/js/{$jsgroup}/".mtime('js',$jsgroup).'.js')?>"></script>

</body>
</html>