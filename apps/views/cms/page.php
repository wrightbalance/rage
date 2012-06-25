<div class="maincol">
	
	<?php
		$title = "404 Page not found.";
		$body = "The page you are looking for does not seem to exists";
	
		if($page_details)
		{
			$title = $page_details['title'];
			$body = $page_details['body'];
		}
	?>
	
	<h3><?=$title?></h3>
	<br/>
	<div class="vpane">
		<?=nl2br($body)?>
	</div>

</div>
