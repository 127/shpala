<?php
//TODO
class Shpala {
	public 	  $version = '1.0.0';
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
		if(isset($this->_config->config['database'])) {
			$this->_database = new Database($this->_config->config['database']);
			$this->_connect = $this->_database->get_connect();
			BaseRecord::$_db_di = $this->_connect;
			if(isset($this->_config->config['database']['tables_prefix'])) {
				BaseRecord::$_prefix_di = $this->_config->config['database']['tables_prefix'];
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
										
		if($this->_resource->validate_essentials() == false)
			return $this->_errors_dispatcher();
		
		$this->_resource->build();
		$this->_resource->run();
		
		if($this->_resource->render_layout == true) {
			if($this->_resource->validate_tpls() == false){
				$this->_errors_dispatcher();
			} else {
				$this->_resource->output();
			}
		}

	}
	
	private function _errors_dispatcher(){
		if($GLOBALS['APP_ENV']!='production') {
			print_r($this->_resource->errors);
		} else {
			View::render_static('404.html', 404);
		}	
	}
	
}
?>