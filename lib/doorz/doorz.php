<?php
//TODO
// 7. multilang
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
			$router->error404('controller"'.$router->params['controller'].'" ');

		$db = new Database();
		$c = $db->get_connect();

		$controller = new  $router->controller($c);
		BaseModel::$_db_di = $c;
	
		$action = $router->action;
		if (!method_exists($controller, $action))
			$router->error404('action "'.$router->params['action'].'" ');

		$controller->$action();
		
		$view = new View($router->params, $controller->view);
		if(count($view->errors)>0)
			foreach ($view->errors as $k=>$v)
				$router->error404($v);
	}
}
?>