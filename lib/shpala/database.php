<?php
class Database {
	
	private $connect;
	
	public function __construct () {
		$db = require_once $GLOBALS['APP_DIR'].'/config/db.php';
		$db = $db[$GLOBALS['APP_ENV']];
		$this->connect = new PDO ("{$db['driver']}:host={$db['host']}:3306;dbname={$db['database']}", $db['username'], $db['password']);
	}
	
	public function get_connect (){
		return $this->connect;
	}
}
?>