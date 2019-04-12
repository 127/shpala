<?php
// error_reporting(9);
if (version_compare(PHP_VERSION, '5.6.30', '<')) { die ('Minimal requirements: PHP 5.6.3'); }
date_default_timezone_set('Europe/Moscow');

$__ts = microtime(true); 
$__exit = require_once('../bootstrap.php');
if($__exit == false) return false;
	
echo '<!-- Time: '.number_format((microtime(true)-$__ts),3).'-->';

?>