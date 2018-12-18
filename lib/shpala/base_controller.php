<?php
class BaseController  {
	public $db;
	public $view; 
	public $params;
	public $resource;
	public $i18n;
	
	public function __construct(Resource &$resource) {
		$this->resource = $resource;

		//aliases
		$this->db  		= $resource->connect;
		$this->params 	= $resource->router->params;
		$this->view 	= $resource->view;
		
		if($resource->i18n)    $this->i18n    = $resource->i18n->strings;
		if($resource->helpers) $this->helpers = $resource->helpers;

		$this->call_init();
		return $this;
	}
	
    protected function call_init(){
        if(method_exists($this, 'init')){
            $this->init();
        }
    }
	
	protected function set_db(&$db){
		$this->db = $db;
	}
}
?>