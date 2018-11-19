<?php
class Config {
	//locale not included
	private $_convention = 'routes|db|environment';
	protected $_dir = '/config/';
	public $config=[];
	
	public function __construct() {
		$_vals_ = explode('|',$this->_convention);
		foreach($_vals_ as $k=>$v) {
			$this->config[$v] = [];
			$_p_ = $GLOBALS['APP_DIR'].$this->_dir.$v;
			$file = $_p_.'.php';
			if(file_exists($file)){
				$_c_ = require_once($file);
				$this->config[$v] = isset($_c_[$GLOBALS['APP_ENV']]) ? $_c_[$GLOBALS['APP_ENV']] : $_c_;
			}
			if(is_dir($_p_)) {
				$file = $_p_.'/'.$GLOBALS['APP_ENV'].'.php';
				if(file_exists($file))
					$this->config[$v] =  require_once($file);
			}
			
		}
		// die(print_r($this->config));
	}
	
}
?>