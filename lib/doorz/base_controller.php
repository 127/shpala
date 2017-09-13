<?php
// namespace lib\doorz;

class BaseController {

	protected $db;
	
	public function __construct() {
		$this->init_db();
		$this->call_init();
	}
	
	protected function init_db() {
		$this->db = new PDO ("{$GLOBALS['DB']['driver']}:host={$GLOBALS['DB']['host']}:3306;dbname={$GLOBALS['DB']['database']}", $GLOBALS['DB']['username'], $GLOBALS['DB']['password']);
	}
	
    protected function call_init(){
        if(method_exists($this, 'init')){
            $this->init();
        }
    }
}
?>