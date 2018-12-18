<?php
spl_autoload_register(function($class_name){
	//autoload classes from directories
	$dirs = array(
		'/app/controllers/',
		'/app/controllers/concerns/',
		'/app/models/',
		'/app/views/',
		'/app/jobs/',
		'/app/helpers/',
		'/lib/shpala/'	
	);
        
	foreach($dirs as $dir){
		$class_name = preg_replace_callback(
						'/(^|[a-z])([A-Z])/',
						function($m) { 
							return strtolower($m[1] ? $m[1]."_".$m[2] : $m[2]); 
						},
						$class_name);
						
		$f = $GLOBALS['APP_DIR'].$dir.$class_name. '.php';
		if(file_exists($f)) require_once($f);
	}
});
?>