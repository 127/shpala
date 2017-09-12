<?php
$environment = getenv('APP_ENV');
if(!$environment) {
	if(file_exists('.env')){
		$handle = @fopen('.env', 'r');
		if ($handle) {
		    while (($buffer = fgets($handle, 4096)) !== false) {
				putenv($buffer);
		    }
		    if (!feof($handle)) {
		        echo 'Error: unexpected fgets() fail.';
		    }
		    fclose($handle);
		}
	} else { 
		putenv('APP_ENV=development');
	}
}
$GLOBALS['APP'] = array( 
	'environment' => getenv('APP_ENV'),
	'homedir' => realpath(__DIR__),
);

$db = require_once "config/db.php";
$GLOBALS['APP']['DB'] = $db[$GLOBALS['APP']['environment']];
// print_r($GLOBALS['APP']['DB']);

require_once 'lib/autoload.php';

$a = new AppController();

?>