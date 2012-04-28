<div class="rightcol">
	
	<ul class="nav nav-list">
		<li><a href="#"><i class=" icon-calendar"></i> Create Event</a></li>
	</ul>
	<hr>
	<?php if(isset($onlines) && $onlines){ ?>
	<div class="widget">
		<h4>Online Players</h4>
		<ul class="nav nav-list onlinechars">
			<?php foreach($onlines as $online){?>
				<li><a href="#"><i class="icon-ok"></i> <?=$online['name']?></a></li>
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
