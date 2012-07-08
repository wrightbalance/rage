<div class="rightcol">
	
	<!--
	<ul class="nav nav-list">
		<li><a href="#"><i class=" icon-calendar"></i> Create Event</a></li>
	</ul>
	
	<hr>
	-->
	<?php if(isset($charOnline) && $charOnline){ ?>
	<div class="widget">
		<h4>Online Players</h4>
		<ul class="nav nav-list onlinechars">
			<?php foreach($charOnline as $online){?>
				<li><a href="#"><?=$online['name']?></a></li>
			<? } ?>
		</ul>
	</div>
	<hr>
	<? } ?>
	
	<?php if(isset($pvptop) && $pvptop){?> 
	<div class="widget">
		<h4>Top 5 Killer</h4>
		<ul class="nav nav-list">
			<?php foreach($pvptop as $ptop){?> 
			<li><a href="#"><i class="icon-star"></i> <?=$ptop['name']?></a></li>
			<?  } ?>
		</ul>
	</div>
	<? } ?>
</div>
