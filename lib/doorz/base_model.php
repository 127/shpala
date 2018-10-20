<?php
// TODO singletone
// TODO CRUD methods
class BaseModel {
	public static $_db_di;
	protected $_db;
	protected $postfix = 'Model';
	protected $table;
	protected $colummns = [];
	
	public function __construct() {
		$this->_db = self::$_db_di;
		$this->table = strtolower(substr(get_class($this), 0, -(strlen($this->postfix)))).'s';
		foreach ($this->_db->query('DESCRIBE '.$this->table)  as $row) {
			$p = $row['Field'];
			array_push($this->colummns, $p);
			$this->$p = null;
		}
		$this->call_init();
	}
	
    protected function call_init(){
        if(method_exists($this, 'init')){
            $this->init();
        }
    }
	
	protected function set_db(&$db){
		$this->_db = $db;
	}
	
	protected function get_db(){
		return $this->_db;
	}
	
	protected function save(){

	}
	
	protected function update(){

	}
	
	protected function delete(){

	}
	
	protected function create(){

	}
	
	protected function all(){

	}
	
	protected function find($id){

	}
}
	
?>