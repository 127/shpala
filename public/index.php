<?php
if (version_compare(PHP_VERSION, '5.6.30', '<')) { die ('Minimal requirements: PHP 5.6.3'); }
date_default_timezone_set('Europe/Moscow');


$GLOBALS['APP_ENV'] = (false === getenv('APP_ENV') ? 'development' : getenv('APP_ENV') );
$GLOBALS['APP_DIR'] = realpath(__DIR__.'/../');

$db = require_once $GLOBALS['APP_DIR']."/config/db.php";
$GLOBALS['DB'] = $db[$GLOBALS['APP_ENV']];

require_once $GLOBALS['APP_DIR'].'/lib/autoload.php';

$a = new Doorz();

// $a = new AppController();

?>