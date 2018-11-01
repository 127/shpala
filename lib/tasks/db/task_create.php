<?php
$stmnt = $connect->prepare("CREATE DATABASE {$dbname} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$stmnt->execute() or die(print_r($stmnt->errorInfo()));
?>