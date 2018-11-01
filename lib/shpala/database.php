<?php
// TODO total refactor errors with
//https://gist.github.com/jonahlyn/1186647
class Database {
    // private static $instance = null;
    private $_dbc;
	private $_config;
    private $_error = false;
	// private $_error = 'Cannot connect to the database: ';
	
	public function __construct ($config=false, $set_default_db=true) {
		$this->set_connect($config);
		if($set_default_db==true)
			$this->set_db();
	}
	
	public function set_connect($config=false, $interface='pdo'){
		if($config==false)
			$config = (require_once($GLOBALS['APP_DIR'].'/config/db.php'))[$GLOBALS['APP_ENV']];
		$this->_config = $config;
		if ($interface=='mysqli') {
			$this->_dbc = mysqli_connect($config['host'].':'.$conf['port'], $config['username'], $config['password']) or die(mysqli_error());
		} else {
			try {
				$this->_dbc = new PDO ("{$config['driver']}:host={$config['host']}:{$config['port']}", $config['username'], $config['password']);
				return $this->_dbc;
			} catch (PDOException $e) {
            	die($e->getMessage());
        	}
		}
	}
	
	public function set_db($dbname=false){
		if($dbname==false)
			$dbname = $this->_config['database'];
		$this->_dbc->exec("use {$dbname}");
		return $this;
	}
	
	public function get_db(){
		return $this->_dbc->query('select database()')->fetchColumn();
	}
	
	public function get_config(){
		return $this->_config;
	}
	
	public function get_connect (){
		return $this->_dbc;
	}

}
?>