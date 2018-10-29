<?php
class BaseJob {
	public static $_db_di;
	protected $_db;
	
	public function __construct() {
		$this->_db = self::$_db_di;
        if(method_exists($this, 'init')){
            $this->init();
        }
		return $this;
	}
}

?>