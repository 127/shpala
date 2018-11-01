<?php
// print_r($db->get_connect());
$stmnt = $connect->prepare("DROP DATABASE {$dbname}");
$stmnt->execute() or die(print_r($stmnt->errorInfo()));
?>