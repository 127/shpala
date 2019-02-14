<?php
return [
	'development' => [
		'driver' => 'mysql',
		'host' => 'localhost',
		'port' => 3306,
		'username' => 'developer',
		'password' => '',
		'database' => 'development_shpala',
		'tables_prefix' => 'shpala_',
		'options' => [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'"
		]
	],
	'production' => [
		'driver' => 'mysql',
		'host' => 'localhost',
		'port' => 3306,
		'username' => 'root',
		'password' => '',
		'database' => 'production_shpala',
		'tables_prefix' => 'shpala_',
		'options' => [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'"
		]
	]
];
?>