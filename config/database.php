<?php
return array(
	'development' => array(
		'driver' => 'mysql',
		'host' => 'localhost',
		'port' => 3306,
		'username' => 'developer',
		'password' => '',
		'database' => 'development_shpala',
		'tables_prefix' => 'shpala_'
	),
	'production' => array(
		'driver' => 'mysql',
		'host' => 'localhost',
		'port' => 3306,
		'username' => 'root',
		'password' => '',
		'database' => 'production_shpala',
		'tables_prefix' => 'shpala_'
	)
);
?>