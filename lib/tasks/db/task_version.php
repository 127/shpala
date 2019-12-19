<?php
echo 'DB version: '.$connect->query('select version()')->fetchColumn()."\n";
?>
