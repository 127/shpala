<?php
class View {
	public $errors = [];
	public static $path = '/app/views/';
	public static $extension = '.phtml';
	public static $layout_file = 'layouts/application.phtml';
	protected $layout_path;
	protected $action_path; 
	protected $view;
	protected $_v;
	
	public function __construct(string $layout_path, string $action_path, array &$_v) {	
		$this->layout_path = $layout_path;
		$this->action_path = $action_path;

		//shortcuts
		$this->_v = &$_v;
		$this->view = &$_v;
		require_once $this->layout_path;
	}
	
	public function renderAction() {
		//reverse shortcut	
		// $_v = &$this->_v;
		// $view = &$this->_v;
		require_once $this->action_path;
	}
	
	public function renderPartial($file, $vars) {
		require_once $file;
	}
}
	
?>