<div class="rightcol">
	
	<ul class="nav nav-list">
		<li><a href="#"><i class=" icon-calendar"></i> Create Event</a></li>
	</ul>
	<hr>
	<?php if(isset($onlines) && $online){ ?>
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
	<div class="widget">
		<h4>Top 5 Killer</h4>
		<ul class="nav nav-list">
			<li><a href="#"><i class="icon-star"></i> Sheldon</a></li>
			<li><a href="#"><i class="icon-star"></i> Testing</a></li>
			<li><a href="#"><i class="icon-star"></i> Testing</a></li>
			<li><a href="#"><i class="icon-star-empty"></i> Testing</a></li>
			<li><a href="#"><i class="icon-star-empty"></i> Testing</a></li>
		</ul>
	</div>
	
</div>
