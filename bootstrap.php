<?php
$GLOBALS['APP_ENV'] = (false === getenv('APP_ENV') ? 'development' : getenv('APP_ENV') );
$GLOBALS['APP_DIR'] = realpath(__DIR__);

if($GLOBALS['APP_ENV'] != 'production'){
	$_sig = '/\.(?:png|jpg|jpeg|gif|css|html|htm|ico|js|webmanifest|txt|json)$/';
	if(php_sapi_name() == 'cli-server' && preg_match($_sig, $_SERVER['REQUEST_URI'])) {
		return false;
	}
}

require_once 'lib/autoload.php';
$app = new Shpala();

?>