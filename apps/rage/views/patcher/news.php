<?php $this->load->view('layout/head_default')?>

<body>
	
<div class="body">
	<?php if($news){?> 
		<?php foreach($news as $n){?>
		<div class="newsrow">
			<h2><?=$n['news_title']?></h2>
			<span class="news_date"><?=date('M d, Y',strtotime($n['created']))?></span>
			<div class="nbody">
			<?=$n['news_body']?>
			<span class="author">
				~ <?=$n['author']?>
			</span>
			</div>
		</div>
		<? }  ?>
	<? } else {?>
	<h2>Welcome to Ragnagears</h2>
	<? } ?>
</div>

</body>
</html>
