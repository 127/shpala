<?php
class View {
	protected $path = '/app/views/';
	protected $extension = '.phtml';
	protected $action_file; 
	public $errors = [];
	
	public function __construct(&$params) {
		
		if (!is_dir($GLOBALS['APP_DIR'].$this->path.$params['controller']))
			 return $this->errors['controller'] = 'controller view';
		
		$this->action_file = $GLOBALS['APP_DIR']
								.$this->path
								.$params['controller']
								.'/'
								.$params['action']
								.$this->extension;

		if (!file_exists($this->action_file)) 
			return $this->errors['action'] = 'action view';
	}
	
	public function render(&$_v) {
		include $this->action_file;
	}
}
	
?>