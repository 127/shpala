<?php
// namespace lib\doorz;

class BaseController {

	protected $db;
	
	public function __construct() {
		$this->db = new PDO ("{$GLOBALS['DB']['driver']}:host={$GLOBALS['DB']['host']}:3306;dbname={$GLOBALS['DB']['database']}", $GLOBALS['DB']['username'], $GLOBALS['DB']['password']);
		print_r($this->db);
		echo 12;
	}
}
?>