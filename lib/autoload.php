<?php
function __autoload($class_name) {

        //class directories
        $directorys = array(
            '/app/',
            '/app/controllers/',
            '/app/models/',
            '/app/views/',
			'/config/',
			'/config/environment/',
			'/lib/doorz/'	
        );
        
        //for each directory
        foreach($directorys as $directory)
        {
			//"{$dir}{$ds}".
			
			$class_name = preg_replace_callback(
							'/(^|[a-z])([A-Z])/',
							function($m) { 
								return strtolower($m[1] ? $m[1]."_".$m[2] : $m[2]); 
							},
							$class_name
						  );
			$f = $GLOBALS['APP_DIR'].$directory.$class_name. '.php';
            if(file_exists($f))
            {
                require_once($f);
                return;
            }            
        }
    }
?>