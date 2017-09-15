<?php
class Router {
	public $controller;
	public $action;
	
	public function __construct() {
		$url = explode('/', $_SERVER['REQUEST_URI']);
		$this->controller = ($url[1]!='' ? $url[1] : 'Index').'Controller';
		$this->action = (isset($url[2]) && $url[2]!='' ? $url[2] : 'Index').'Action';
	}
	
	public function error404($subj){
		 die($subj.' doesn\'t exist');
	}
}
?>