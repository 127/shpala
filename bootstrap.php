<?php
$GLOBALS['APP_ENV'] = (false === getenv('APP_ENV') ? 'development' : getenv('APP_ENV') );
$GLOBALS['APP_DIR'] = realpath(__DIR__);

require_once 'lib/autoload.php';
$app = new Shpala();

?>