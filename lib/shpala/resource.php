<?php
class Resource {
	public $name;
	
	//resources links
	public $connect=null;
	public $controller;
	public $view;
	public $i18n=null;
	public $router;
	public $errors=[];
	public $tpl_layout;
	public $tpl_action;
	// public $model;
	// public $helpers;
	// public $jobs;
	
	public function __construct(Router &$router, 
								PDO &$connect=null, 
								i18n &$translate=null,
								BaseHelpers &$helpers=null){
		$this->name   = $router->params['controller'];
		$this->router = $router;
		if(isset($translate)) $this->i18n    = $translate;
		if(isset($connect))   $this->connect = $connect;
		if(isset($helpers))   $this->helpers = $helpers;
	}
	
	public function build(){
		//=========JOBS============//
		if($this->connect!=null)
			BaseJob::$_db_di = $this->connect;
		new Queue();
		//=========APP============//
		$this->controller = new $this->router->controllerClass($this);

	}
	
	public function validate(){
		$this->tpl_layout = $GLOBALS['APP_DIR'].View::$path.View::$layout_file;
		$this->tpl_action = $GLOBALS['APP_DIR'].View::$path
								.$this->router->params['controller'].'/'
								.$this->router->params['action']
								.View::$extension;
		if(!in_array($this->name, $this->router->resources))
			$this->errors['no_resource_identified'] = true;
		if (!class_exists($this->router->controllerClass))
			$this->errors['controller_class_not_exists'] = true;
		if (!method_exists($this->router->controllerClass, $this->router->actionMethod))
			$this->errors['action_method_not_exists'] = true;
		if(!file_exists($this->tpl_layout))
			$this->errors['layout_template_not_exists'] = true;
		if(!file_exists($this->tpl_action)) 
			$this->errors['action_template_not_exists'] = true;

		return (count($this->errors)==0) ? true : false;
	}
	
	public function run(){
		$action = $this->router->actionMethod;
		$this->controller->$action();
		$this->view = new View($this);
	}
	
		
}

?>