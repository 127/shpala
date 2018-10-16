<?php
class View {
	protected $path = '/app/views/';
	protected $extension = '.phtml';
	protected $action_file; 
	protected $layout_file = 'layouts/application.phtml';
	public $errors = [];
	protected $_v;
	
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
		
		$this->_v = $_v;
		require_once $this->layout_file;
	}
	
	public function renderAction() {
		require_once $this->action_file;
	}
}
	
?>