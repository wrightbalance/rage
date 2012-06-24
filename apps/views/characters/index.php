<div class="maincol wide">
	<h3>Characters</h3>
	<hr>
	
	<?php if($authorize){?>
	<table class="characters"></table>
	<? } else { ?>
	<table class="characters2"></table>
	<? } ?>


</div>

<?php $this->load->view('characters/modal/view')?>
