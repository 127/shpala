<?php
class BaseView {
	public function __construct() {
		
	}
	public function render(&$_v, &$actionFile) {
		include $actionFile;
;	}
}
	
?>