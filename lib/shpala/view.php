<?php
class View {
	protected $path = '/app/views/';
	protected $extension = '.phtml';
	protected $action_file; 
	protected $layout_file = 'layouts/application.phtml';
	protected $view;
	protected $_v;
	public 	  $errors = [];
	
	public function __construct(&$params, &$_v) {
		
		if (!is_dir($GLOBALS['APP_DIR'].$this->path.$params['controller']))
			 return $this->errors['controller'] = 'controller "'.$params['controller'].'" view';
		
		$this->action_file = $GLOBALS['APP_DIR']
								.$this->path
								.$params['controller']
								.'/'
								.$params['action']
								.$this->extension;

		if (!file_exists($this->action_file)) 
			return $this->errors['action'] = 'action "'.$params['action'].'"  view';
		
		$this->layout_file = $GLOBALS['APP_DIR'].$this->path.$this->layout_file;
		if (!file_exists($this->layout_file)) 
			return $this->errors['layout'] = 'layout file';
		//shortcuts
		$this->_v = &$_v;
		$this->view = &$_v;
		require_once $this->layout_file;
	}
	
	public function renderAction() {
		//reverse shortcut	
		$_v = &$this->_v;
		$view = &$this->_v;
		require_once $this->action_file;
	}
	
	public function renderPartial($file, $vars) {
		require_once $file;
	}
}
	
?>