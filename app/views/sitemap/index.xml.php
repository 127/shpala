<?='<?xml version="1.0" encoding="UTF-8"?>'?>

<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
$s='';
$lastmod = (new DateTime())->format('c');
foreach($_v['index'] as $resource){
	$s .= '	<sitemap>
		<loc>https://'.$_SERVER['HTTP_HOST'].'/'.$resource.'_sitemap.xml</loc>
		<lastmod>'.$lastmod.'</lastmod>
	</sitemap>'."\n";
}
echo $s;
?>
</sitemapindex>
