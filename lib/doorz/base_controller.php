<?php
// namespace lib\doorz;

class BaseController {

	protected $db;
	
	public function __construct() {
		$this->db = new PDO ("{$GLOBALS['APP']['DB']['driver']}:host={$GLOBALS['APP']['DB']['host']}:3306;dbname={$GLOBALS['APP']['DB']['database']}", $GLOBALS['APP']['DB']['username'], $GLOBALS['APP']['DB']['password']);
	}
}
?>