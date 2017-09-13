<?php
$GLOBALS['APP_ENV'] = (false === getenv('APP_ENV') ? 'development' : getenv('APP_ENV') );
$GLOBALS['APP_DIR'] = realpath(__DIR__);

$db = require_once "config/db.php";
$GLOBALS['DB'] = $db[$GLOBALS['APP_ENV']];

require_once 'lib/autoload.php';
new Doorz();

?>