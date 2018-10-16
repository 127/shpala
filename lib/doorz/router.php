<?php
class Router {
	public $controller;
	public $action;
	public $params = [];
	protected $defaultPathController = 'index';
	protected $defaultPathAction     = 'index';
	protected $controllerPostfix	 = 'Controller';
	protected $actionPostfix		 = 'Action';
	
	public function __construct() {
		$url = explode('/', $_SERVER['REQUEST_URI']);
		$this->params['controller'] = ($url[1]!='') ? $url[1] : $this->defaultPathController;
		$this->params['action'] = (isset($url[2]) && $url[2]!='') ? $url[2] : $this->defaultPathAction;
		$this->controller = ucfirst($this->params['controller']).$this->controllerPostfix;
		$this->action = ucfirst($this->params['action']).$this->actionPostfix;
	}
	
	public function error404($subj){
		 die($subj.' doesn\'t exist');
	}
}
?>