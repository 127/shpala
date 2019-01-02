<?php
class View {
	public $resource;
	public static $path = '/app/views/';
	public static $extension = '.phtml';
	public static $layout_file = 'layouts/application.phtml';
	public static $public_path='/public/'; 
	protected $view;
	protected $_layout_path;
	protected $_action_path; 
	
	public function __construct(Resource &$resource) {	
		$this->resource = $resource;
		$this->_layout_path = $resource->tpl_layout;
		$this->_action_path = $resource->tpl_action;
		$this->view = $resource->controller->view;
		if(isset($resource->i18n)) $this->i18n = $resource->i18n;
		//shortcut
		$_v=$this->view;
		$_t=$this->i18n;
		require_once $this->_layout_path;
	}
	
	public function render_action() {
		//shortcut
		$_v=$this->view;
		$_t=$this->i18n;
		require_once $this->_action_path;
	}
	
	public function render_partial($file, $vars) {
		require_once $file;
	}
	
	public static function render_static($file, $header=false){
		if($header!=false) Router::header($header);
		require_once $GLOBALS['APP_DIR'].self::$public_path.$file;
		exit;
	}
}
	
?>