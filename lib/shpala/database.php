<?php
class Database {
	
	private $_connect;
	private $_error = 'Cannot connect to the database: ';
	
	public function __construct () {
		$db = require_once $GLOBALS['APP_DIR'].'/config/db.php';
		$db = $db[$GLOBALS['APP_ENV']];
		$this->_connect = $this->set_connect($db);
		return $this;
	}
	
	public function set_connect($db, $interface = 'pdo'){
		if ($interface=='mysqli') {
			return mysqli_connect(
					$db['host'].':'.$db['port'], 
					$db['username'], 
					$db['password'],
					$db['database']
				   ) or die($this->_error . mysqli_error());
		} else {
			return new PDO ("{$db['driver']}:host={$db['host']}:{$db['port']};dbname={$db['database']}", $db['username'], $db['password']);
		}
	}
	
	public function get_connect (){
		return $this->_connect;
	}
}
?>