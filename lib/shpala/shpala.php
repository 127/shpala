<?php
//TODO
class Shpala {
	protected $_config = [];
	protected $_i18n = [];
	protected $_router;
	protected $_helpers;
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
			if(isset($this->_config->config['db']['tables_prefix'])) {
				BaseModel::$_prefix_di = $this->_config->config['db']['tables_prefix'];
			}
		}
		
		$helper_name = ucfirst($this->_router->params['controller']).'Helpers';
		if (class_exists($helper_name)) {
			$this->_helpers = new $helper_name;
		} elseif(class_exists('ApplicationHelpers')){
			$this->_helpers = new ApplicationHelpers();
		} else {
			$this->_helpers = new BaseHelpers();
		}

		$this->_resource = new Resource($this->_router, 
										$this->_connect, 
										$this->_i18n, 
										$this->_helpers);
										
		if($this->_resource->validate() == true){
			$this->_resource->build();
			$this->_resource->run();
		} else {
			if($GLOBALS['APP_ENV']!='production') {
				print_r($this->_resource);
			} else {
				View::renderStatic('404.html', 404);
			}
		}
	}
	
}
?>