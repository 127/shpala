<?php
$connect = $db->get_connect();
echo 'DB version: '.$connect->query('select version()')->fetchColumn()."\n";
?>
