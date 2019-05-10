<?='<?xml version="1.0" encoding="UTF-8"?>'?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php

$s='';
$lastmod = (new DateTime())->format('c');
foreach($_v['actions'] as $url){
	$_a = $url=='index' ? '' : '/'.$url;
	$s .= '	<url>
		<loc>https://'.$_SERVER['HTTP_HOST'].'/'.$_v['controller'].$_a.'</loc>
		<lastmod>'.$lastmod.'</lastmod>
		<changefreq>'.$_v['frequency'].'</changefreq>
		<priority>'.$_v['importance'].'</priority>
	</url>'."\n";
}
echo $s;
?>
</urlset>
