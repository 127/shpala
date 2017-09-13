<?php
// TODO проверка существования контроллеров и экшенов и отвал в 404
class Router {
	public $controller;
	public $action;
	public function __construct() {
		$url = explode('/', $_SERVER['REQUEST_URI']);
		$this->controller = ($url[1]!='' ? $url[1] : 'Index').'Controller';
		$this->action = (isset($url[2]) && $url[2]!='' ? $url[2] : 'Index').'Action';
		// print_r($url);
		// print_r($this->controller);
	}
}
?>