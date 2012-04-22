<?php
  $shell = shell_exec( 'cd ~/apps/hives/ && git reset --hard HEAD && git pull origin master');
  echo '<pre><b>Github Message: </b><br/>';$shell;
?>
