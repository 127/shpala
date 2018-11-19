<?php
//TODO
class Shpala {
	protected $_config = [];
	protected $_i18n = [];
	protected $_router;
	protected $_database;
	protected $_connect=null;
	protected $_resources = [];
	protected $_resource;

	public function __construct() {
		$this->_config = new Config();
		$this->_router = new Router($this->_config->config['routes']);
		$this->_i18n   = new i18n();
		if(isset($this->_config->config['db'])) {
			$this->_database = new Database($this->_config->config['db']);
			$this->_connect = $this->_database->get_connect();
			BaseModel::$_db_di = $this->_connect;
			if(isset($this->_config->config['tables_prefix']))
				BaseModel::$_prefix_di = $this->_config->config['db']['tables_prefix'];
		}
		$this->_resource = new Resource($this->_router, $this->_connect, $this->_i18n);
		if($this->_resource->validate() == true){
			$this->_resource->build();
			$this->_resource->run();
		} else {
			//log shit here
		}
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