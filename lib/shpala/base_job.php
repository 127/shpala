<?php
class BaseJob {
	public static $_db_di=null;
	protected $_db;
	
	public function __construct() {
		if(self::$_db_di!=null)
			$this->_db = self::$_db_di;
        if(method_exists($this, 'init')){
            $this->init();
        }
		return $this;
	}
}

?>