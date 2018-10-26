<?php

class BaseController  {

	public $_db;
	public $view; //= (object)[]; //view vars
	
	public function __construct(&$db) {
		$this->view = [];
		$this->set_db($db);
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
}
?>