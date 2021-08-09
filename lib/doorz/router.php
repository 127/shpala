<?php
class Router {
	public $controller;
	public $action;
	public $params = [];
	protected $rootController = 'index';
	protected $rootAction     = 'index';
	protected $controllerPostfix	 = 'Controller';
	protected $actionPostfix		 = 'Action';
	
	public function __construct() {
		$f = $GLOBALS['APP_DIR'].'/config/routing.php';
		if(file_exists($f)){
			$routing = require_once $f;
			if(isset($routing['rootControllerPath']))
				$this->rootController = $routing['rootControllerPath'];
			if(isset($routing['rootActionPath']))
				$this->rootAction = $routing['rootActionPath'];
		}
		$url = explode('/', $_SERVER['REQUEST_URI']);
		$this->params['controller'] = ($url[1]!='') ? $url[1] : $this->rootController;
		$this->params['action'] = (isset($url[2]) && $url[2]!='') ? $url[2] : $this->rootAction;
		$this->controller = ucfirst($this->params['controller']).$this->controllerPostfix;
		$this->action = ucfirst($this->params['action']).$this->actionPostfix;
	}
	
	public function error404($subj){
		 die($subj.' doesn\'t exist');
	}
}
?>