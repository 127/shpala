<?php
// TODO total refactor errors with
//https://gist.github.com/jonahlyn/1186647
class Database {
    private $_dbc;
	private $_config;
    private $_error = false;
	// private $_error = 'Cannot connect to the database: ';
	
	public function __construct (&$config=false, $set_default_db=true) {
		if($config!=false) {
			$this->set_connect($config);
			if($set_default_db==true)
				$this->set_db();
		}
	}
	
	public function set_connect(array &$config, $interface='pdo'){
		$this->_config = $config;
		if(isset($config['tables_prefix']))
			BaseModel::$_prefix_di = $config['tables_prefix'];
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