<?php

class BaseController  {

	public $_db;
	public $view; //= (object)[]; //view vars
	public $params=null;
	
	public function __construct(&$db, &$params=null) {
		$this->view = [];
		$this->_db  = $db;
		$this->params = $params;
		$this->call_init();
		return $this;
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