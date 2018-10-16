<?php
//TODO
//3 get variables to view 
//4 run render
//5 output
class Doorz {
	// protected $router;
	// protected $controller;
	// protected $action;
	// protected $view;

	
	public function __construct() {
		$this->dispatch();
	}
	
	public function dispatch() {


		$router = new Router();

		if (!class_exists($router->controller))
			$router->error404('controller');

		$db = new Database();
		$c = $db->get_connect();

		$controller = new  $router->controller($c);
	
		$action = $router->action;
		if (!method_exists($controller, $action))
			$router->error404('action');

		$controller->$action();
		
		$view = new BaseView($router);
		$view->render($controller->view);
	}
}
?>