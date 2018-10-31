<?php
echo "Running server on localhost:8000\n";
system('cd '.$GLOBALS['APP_DIR'].'/public && php -S localhost:8000');
?>