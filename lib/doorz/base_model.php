<?php
// TODO singletone
class BaseModel {
	public static $_db;
	protected $postfix = 'Model';
	protected $table;
	
	public function __construct() {
		$this->table = strtolower(substr(get_class($this), 0, -(strlen($this->postfix)))).'s';
		// $This->getAllProperties();
		// echo $this->table;
		// echo 'Parent class: ' . get_class() . "\n" . 'Child class: ' . get_class($this);
		$this->call_init();
	}
	
    protected function call_init(){
        if(method_exists($this, 'init')){
            $this->init();
        }
    }
	
	protected function set_db(&$db){
		self::$_db = $db;
	}
	
	protected function get_db(){
		return self::$_db;
	}
	
	protected function save(){

	}
	
	protected function update(){

	}
	
	protected function delete(){

	}
	
	protected function create(){

	}
}
	
?>