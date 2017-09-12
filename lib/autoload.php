<?php
function __autoload($class_name) {
	print_r($_APP);
        //class directories
        $directorys = array(
            '/app/',
            '/app/controllers/',
            '/app/models/',
            '/app/views/',
			'/config/',
			'/config/environment/',
			'/lib/doorz'	
        );
        
        //for each directory
        foreach($directorys as $directory)
        {
			$class_name = "{$dir}{$ds}".preg_replace(
					'/(^|[a-z])([A-Z])/e',
					'strtolower(strlen("\\1") ? "\\1_\\2" : "\\2")', $class_name);// .".php";
            if(file_exists($GLOBALS['APP']['homedir'].$directory.$class_name. '.php'))
            {
                require_once($GLOBALS['APP']['homedir'].$directory.$class_name. '.php');
                return;
            }            
        }
    }
?>