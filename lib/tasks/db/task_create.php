<?php
$stmnt = $db->_connect->prepare("CREATE DATABASE {$db->_config['database']} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$stmnt->execute() or die(print_r($stmnt->errorInfo()));
?>