<?php
return [
	'root' => 'index#index',
	'resources' => [
		'index',
		'sitemap' => [
			'path'=>'sitemap.xml',
		    'as'  =>'sitemap#index' 
		]
	]
];
?>