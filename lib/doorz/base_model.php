<?php
// TODO singletone
class BaseModel {
	protected $db;
	
	public function __construct() {
		// $this->init_db();
	}
	//
	// protected function init_db() {
	// 	$this->db = new PDO ("{$GLOBALS['DB']['driver']}:host={$GLOBALS['DB']['host']}:3306;dbname={$GLOBALS['DB']['database']}", $GLOBALS['DB']['username'], $GLOBALS['DB']['password']);
	// }
}
	
?>