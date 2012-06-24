<div class="maincol">
	<h3>Rankings</h3>
	<ul class="tab nav nav-tabs">
		<li class="active"><a href="<?=push_url('rankings/pvp')?>" data-setup="plane" class="ps">PVP Ladder</a></li>
		<li class=""><a href="<?=push_url('rankings/guild')?>" onclick="$('.guildFlex').flexReload();" data-setup="plane" class="ps">Guild Ladder</a></li>
	</ul>
	

	<div class="tpane pactive">
		
		<table class="pvpFlex"></table>
		
	</div>
	<div class="tpane">
		
		<table class="guildFlex"></table>
		
	</div>


</div>
