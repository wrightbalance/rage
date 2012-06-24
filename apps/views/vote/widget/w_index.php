<div class="maincol wide">
	
	<h3>Vote Banners</h3>
	<hr>
	
	<?php if(count($char) == 0) { ?> 
	
	<p><div class="alert alert-error">
        <strong>Note</strong> You need at least one character to use the Vote System.
      </div></p>
	
	<? } else { ?>
	<p>Click the voting links to earn points.</p>
	
	
	<div class="cashpoints">
		Total Cashpoints: <?=$cashpoints?>
	</div>
	
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
