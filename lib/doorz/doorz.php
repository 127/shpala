<?php
//TODO
//3 get variables to view 
//4 run render
//5 output
class Doorz {
	// protected $router;
	protected $controller;
	protected $action;
	protected $view;
	protected $viewPath = '/app/views/';
	protected $viewExtension = '.phtml';

	
	public function __construct() {
		$this->dispatch();

	}
	
	public function dispatch() {


		$router = new Router();
		$this->view = new BaseView();

		if (!class_exists($router->controller))
			$router->error404('controller');
		// check if file controller folder exists
		// echo $GLOBALS['APP_DIR'].'/app/views/'.$router->params['controller'];
		if (!is_dir($GLOBALS['APP_DIR'].$this->viewPath.$router->params['controller']))
			$router->error404('controller view');

		$db = new Database();
		$c = $db->get_connect();

		$this->controller = new  $router->controller($c);
	
		$action = $router->action;
		if (!method_exists($this->controller, $action))
			$router->error404('action');
		// check if file action exists
		$actionFile = $GLOBALS['APP_DIR'].$this->viewPath.$router->params['controller'].'/'.$router->params['action'].$this->viewExtension;
		if (!file_exists($actionFile))
			$router->error404('action view');
		$this->controller->$action();
		
		$this->view->render($this->controller->view, $actionFile);
	}
}
?>