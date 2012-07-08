		</div>
	</div>
</div>


<?php $this->load->view('modal/loader')?>

<?php if(isset($user) && !empty($user)){?>
<?php if(!isset($user['nickname']) && !$user['nickname']){?>
<?php $this->load->view('modal/set_nickname')?>
<? } ?>
<? } ?>

<div class="footer">
	<div class="tileCenter">
		<span style="float: right;">Geared Control Panel &copy; 2012 <br/></span>
		<a href="http://www.jingcleovil.com" target="_blank" style="color: #fff;">
			<img src="<?=resource_url('images/logo_author.png')?>"/>
		</a>
	</div>

</div>

<script type="text/javascript">
	var root = "<?=site_url()?>";
	
	<?php if(isset($user['account_id'])) {?>
	var accountid = <?=$user['account_id']?>;
	var nickname = "<?=$user['nickname']?>";
	var photo_path = "<?=resource_url('images/photo_'.strtolower($user['sex']).'.jpg')?>";
	var gender = "<?=$user['sex']?>";
	var group = "<?=$group?>";
	<? } ?>
	
</script>


<?php if(!isset($jsgroup)) $jsgroup = "default"?>

<script type="text/javascript" src="<?=site_url("mini/js/{$jsgroup}/".mtime('js',$jsgroup).'.js')?>"></script>

</body>
</html>
