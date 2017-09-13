<?php
//TODO
//1 get controller and action
//2 instantiate controller, run action
//3 get variables to view 
//4 run render
//5 output
class Doorz {
	protected $router;
	protected $controller;
	protected $action;
	public function __construct() {
		$this->router = new Router();
		$this->controller = new  $this->router->controller();
		$action = $this->router->action;
		$this->controller->$action();
		// echo $this->router->controller.'Controller';
	}
}
?>