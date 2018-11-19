<?php
class i18n {
	public static $default_locale= 'en';
	public $locale=null;
	public $strings=[];
	protected $_dir = '/config/locale/';
	protected $_separator = '.';
	
	public function __construct($locale=false) {
		$this->locale = ($this->locale===null && $locale!==false) ? $locale : self::$default_locale;
		$file = $GLOBALS['APP_DIR'].$this->_dir.$this->locale.'.php';
		if(file_exists($file)){
			$this->strings = $this->_flatten((require_once($file))[$this->locale]);
		}
	}
	
	public function _t(string $el){
		return isset($this->strings[$el]) ? $this->strings[$el] : false;
	}
	
	protected function _flatten($array, $prefix = '') {
	    $result = array();
	    foreach($array as $key=>$value) {
	        if(is_array($value)) {
	            $result = $result + $this->_flatten($value, $prefix . $key . '.');
	        }
	        else {
	            $result[$prefix . $key] = $value;
	        }
	    }
	    return $result;
	}
	
}	
	
?>