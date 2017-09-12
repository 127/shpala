<?php
class BaseController {
	
	function __construct(){
		$this->db = new PDO ("{$GLOBALS['APP']['DB']['driver']}:host={$GLOBALS['APP']['DB']['host']};dbname={$GLOBALS['APP']['DB']['database']}", $GLOBALS['APP']['DB']['username'], $GLOBALS['APP']['DB']['password']);
	}
}
?>