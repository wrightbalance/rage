<div class="maincol wide">
	
	<h3>Vote For Points</h3>
	<hr>
	
	<?php if(count($char) == 0) { ?> 
	
	<p><div class="alert alert-error">
        <strong>Note</strong> You need at least one character to use the Vote System.
      </div></p>
	
	<? } else { ?>

	<table class="flexme">	
		<thead>
			<tr>
				<th width="120">Type</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="120"><span style="padding: 0 20px 0 0">Total Caspoints</span></td>
				<td ><span style="padding: 0 50px 0 0"><?=$cashpoints?></span></td>
			</tr>
		</tbody>
	</table>
	
	<br/>
	<br/>
	
	<div class="vote_sites">
		<?php foreach($banners as $banner){?>
			<?php
				$lastvote = $banner['lastvote'];
				$allowvote = true;
				$allow_mac = false;
				
	
				if(isset($lastvote['vote_date']) && strtotime($lastvote['vote_date']) + (60*60*($banner['hours'])) > time())
				{
					$allowvote = false;
				}
				else
				{
					if(config_item('use_mac_address'))
					{

						$last_mac = $banner['last_mac'];
	
		
						if($last_mac > 0 && strtotime($banner['last_mac_vote']) + (60*60*($banner['hours'])) > time()) 
						{
							$allowvote = false;
						
						}
					}
				}
			
				
				
			?>
			<?php if($allowvote) { ?>
			<div class="brows" id="banner_<?=$banner['id']?>">
				
				
				<a href="<?=site_url("vote/in/{$banner['id']}")?>" target="_blank" onclick="document.getElementById('banner_<?=$banner['id']?>').style.visibility='hidden'">
					<img src="<?=$banner['image_url']?>" alt=""/>
				</a>
				<div class="bdetails">
					<p>Points: <?=$banner['credits']?></p>
					<p>Interval: <?=$banner['hours']?></p>
				</div>
				
			</div>
			
			<? } else { ?>
			<div class="brows" style="opacity: 0.2; filter: alpha(opacity=20)">
				<img src="<?=$banner['image_url']?>" alt=""/>
				<p>Vote in... <?=$banner['hours']?> hours</p>
				
			</div>
			<? } ?>
		<? } ?>
	</div>
	 <? } ?>
	
</div>
