<?php
include $GLOBALS['SHPALA_DIR'].'router.php';
$resources = (new Config())->config['routes']['resources'];
// print_r($resources->config);die();
Router::set_routes_table($resources);
echo Router::get_routes_info();
?>