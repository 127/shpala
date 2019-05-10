<?php
return [
	'root' => 'index#index',
	'resources' => [
		'index',
		'sitemap_index' => [
			'path'=>'sitemap.xml',
		    'as'  =>'sitemap#index' 
		],
		'sitemap_urls' => [
			'regexp'=>'/(.*)_sitemap.xml/',
		    'as'  =>'sitemap#module' 
		],
	]
];
?>