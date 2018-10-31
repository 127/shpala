<?php
// TODO total refactor this class
class Database {
	
	public  $_connect;
	public  $_config;
	private $_dbname;
	private $_error = 'Cannot connect to the database: ';
	
	public function __construct () {
		$db = require_once $GLOBALS['APP_DIR'].'/config/db.php';
		$this->_config = $db[$GLOBALS['APP_ENV']];
		$this->set_connect($this->_config);
		return $this;
	}
	
	public function set_connect(&$db, $interface = 'pdo'){
		if ($interface=='mysqli') {
			$this->_connect = mysqli_connect(
					$db['host'].':'.$db['port'], 
					$db['username'], 
					$db['password'],
					$db['database']
				   ) or die($this->_error . mysqli_error());
		} else {
			//;dbname={$db['database']}
			$this->_connect = new PDO ("{$db['driver']}:host={$db['host']}:{$db['port']}", $db['username'], $db['password']);
		}
	}
	
	public function set_db($db = false){
		if ($db == false)  
			$db = $this->_config['database'];
			
		$this->_connect->exec("use {$db}");
		$this->_dbname = $db;
	}
	
	public function get_db(){
		return $this->_dbname;
	}
	
	public function get_connect (){
		if($this->_dbname==false)
			$this->set_db();
		return $this->_connect;
	}

}
?>