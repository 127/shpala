<?php
$f = $GLOBALS['APP_DIR'].'/db/structure.sql';
if(file_exists($f)){
	$sql = file_get_contents($f) or die("Can't open {$f}");
	$db->set_db();
	$stmnt = $connect->prepare($sql);
	$stmnt->execute() or die(print_r($stmnt->errorInfo()));
}
?>