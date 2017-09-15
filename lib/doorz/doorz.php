<?php
//TODO
//3 get variables to view 
//4 run render
//5 output
class Doorz {
	// protected $router;
	protected $controller;
	protected $action;

	
	public function __construct() {
		$this->dispatch();

	}
	
	public function dispatch() {


		$router = new Router();

		if (!class_exists($router->controller))
			$router->error404('controller');

		$db = new Database();
		$c = $db->get_connect();


		$this->controller = new  $router->controller($c);
		// print_r($this->controller);
		//
		$action = $router->action;
		if (!method_exists($this->controller, $action))
			$router->error404('action');
		$this->controller->$action();
		
		
	}
}
?>