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
		return $this;
	}
	
    protected function call_init(){
        if(method_exists($this, 'init')){
            $this->init();
        }
    }
	
	public function set_db(&$db){
		$this->_db = $db;
	}
	
	public function get_db(){
		return $this->_db;
	}
	
	public function save(){

	}
	
	public function update(){

	}
	
	public function delete(){

	}
	
	public function create(){

	}
	
	public function all($where=false){
		return $this->_db->query('SELECT * FROM '.$this->table.' '.$where)->fetchAll();
	}
	
	public function count($where=false){
		return $this->_db->query('SELECT COUNT(*) FROM '.$this->table.' '.$where)->fetchColumn();
	}
	
	public function find(int $id, $where=false){
		return $this->_db->query('SELECT * FROM '.$this->table.' WHERE id='.$id.' '.$where)->fetchAll();
	}
}
	
?>