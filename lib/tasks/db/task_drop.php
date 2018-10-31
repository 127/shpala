<?php
$stmnt = $db->_connect->prepare("DROP DATABASE IF EXISTS {$db->_config['database']}");
$stmnt->execute() or die(print_r($stmnt->errorInfo()));
?>