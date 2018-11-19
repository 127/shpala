<?php
class Resource {
	public  $name;
	public  $connect=null;
	public $controller;
	protected $_router;
	protected $_errors=[];
	// public $model;
	// public $view;
	// public $helpers;
	// public $jobs;
	
	public function __construct(Router &$router, PDO &$connect=null){
		$this->name = $router->params['controller'];
		$this->_router = $router;
		if(isset($connect)) $this->connect = $connect;
	}
	
	public function build(){
		if(count($this->_errors)==0){
			$this->controller = new $this->_router->controllerClass($this->connect);
		}
	}
	
	public function validate(){
		if(!in_array($this->name, $this->_router->resources))
			$this->_errors['no_resource_identified'] = true;
		if (!class_exists($this->_router->controllerClass))
			$this->_errors['controller_class_not_exists'] = true;
		if (!method_exists($this->_router->controllerClass, $this->_router->actionMethod))
			$this->_errors['action_method_not_exists'] = true;
		return (count($this->_errors)==0) ? true : false;
	}
	
	public function run(){
		$action = $this->_router->actionMethod;
		$this->controller->$action();
	}
	
		
}

?>