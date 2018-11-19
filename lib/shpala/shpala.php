<?php
//TODO
class Shpala {
	protected $_config = [];
	protected $_i18n = [];
	protected $_resource;

	public function __construct() {
		$this->_config = new Config();
		$this->_i18n   = new i18n();
		die(print_r($this->_i18n->_t('title.abbr')));
	}
	
	public function dispatch() {
		//
		// $router = new Router();
		//
		// if (!class_exists($router->controller))
		// 	$router->error404('controller"'.$router->params['controller'].'" ');
		//
		// $db = new Database();
		// $c = $db->get_connect();
		//
		// $controller = new  $router->controller($c);
		// BaseModel::$_db_di = $c;
		//
		// $action = $router->action;
		// if (!method_exists($controller, $action))
		// 	$router->error404('action "'.$router->params['action'].'" ');
		//
		// $controller->$action();
		//
		//
		//
		// $view = new View($router->params, $controller->view);
		// if(count($view->errors)>0)
		// 	foreach ($view->errors as $k=>$v)
		// 		$router->error404($v);
		//
		// //=========JOBS============//
		// BaseJob::$_db_di = $c;
		// new Queue();

	}
}
?>