<?php
class Resource {
	public  $name;
	public  $connect=null;
	public $controller;
	public $view;
	protected $_router;
	protected $_errors=[];
	protected $_tpl_layout;
	protected $_tpl_action;
	// public $model;
	// public $helpers;
	// public $jobs;
	
	public function __construct(Router &$router, PDO &$connect=null){
		$this->name = $router->params['controller'];
		$this->_router = $router;
		if(isset($connect)) $this->connect = $connect;
	}
	
	public function build(){
		//=========JOBS============//
		if( $this->connect!=null)
			BaseJob::$_db_di = $this->connect;
		new Queue();
		//=========APP============//
		$this->controller = new $this->_router->controllerClass($this->connect);

	}
	
	public function validate(){
		$this->_tpl_layout = $GLOBALS['APP_DIR'].View::$path.View::$layout_file;
		$this->_tpl_action = $GLOBALS['APP_DIR'].View::$path
								.$this->_router->params['controller'].'/'
								.$this->_router->params['action']
								.View::$extension;
		if(!in_array($this->name, $this->_router->resources))
			$this->_errors['no_resource_identified'] = true;
		if (!class_exists($this->_router->controllerClass))
			$this->_errors['controller_class_not_exists'] = true;
		if (!method_exists($this->_router->controllerClass, $this->_router->actionMethod))
			$this->_errors['action_method_not_exists'] = true;
		if(!file_exists($this->_tpl_layout))
			$this->_errors['layout_template_not_exists'] = true;
		if(!file_exists($this->_tpl_action)) 
			$this->_errors['action_template_not_exists'] = true;
			
		return (count($this->_errors)==0) ? true : false;
	}
	
	public function run(){
		$action = $this->_router->actionMethod;
		$this->controller->$action();
		$this->view = new View($this->_tpl_layout, $this->_tpl_action, $this->controller->view);
	}
	
		
}

?>