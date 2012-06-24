<div class="maincol">
	
	<?php
		$title = "404 Page not found.";
		$body = "The page you are looking for does not seem to exists";
		
		if($page)
		{
			$title = $page['title'];
			$body = $page['body'];
		}
	?>
	
	<h3><?=$title?></h3>
	
	<div class="vpane">
		<?=nl2br($body)?>
	</div>

</div>
