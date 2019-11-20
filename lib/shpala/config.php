<?php
class Config {
  //locale dir config/locale not included
  private $_required = 'routes|database|environment';
  protected $_dir = '/config/';
  public $config=[];
  
  public function __construct() {
    $_r = []; //resulting array
    $_vals_ = explode('|',$this->_required);
    foreach($_vals_ as $k=>$v) {
      $_p_ = $GLOBALS['APP_DIR'].$this->_dir.$v;
      $file = $_p_.'.php';
      if(is_file($file)){
        $_c_ = require_once($file);
        $_r[$v] = isset($_c_[$GLOBALS['APP_ENV']]) ? $_c_[$GLOBALS['APP_ENV']] : $_c_;
      }
      if(is_dir($_p_)) {
        $file = $_p_.'/'.$GLOBALS['APP_ENV'].'.php';
        if(file_exists($file)){
          $_c_ = require_once($file);
          $_r[$v] = empty($_r[$v]) ? $_c_ : array_merge($_r[$v], $_c_);
        }
      }
    }
    $this->config = $_r;
    unset($r);
  }
}
?>