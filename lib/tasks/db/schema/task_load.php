<?php
$f = $GLOBALS['APP_DIR'].'/config/schema.sql';
if(file_exists($f)){
	$sql = file_get_contents($f) or die("Can't open {$f}");
	$c = $db->get_connect();
	$stmnt = $c->prepare($sql);
	$stmnt->execute() or die(print_r($stmnt->errorInfo()));
}
?>