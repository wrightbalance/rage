<?php
  $shell = shell_exec( 'cd ~/public_html/rage/ && git reset --hard HEAD && git pull origin master');
  echo '<pre><b>Github Message: </b><br/>';$shell;
?>
