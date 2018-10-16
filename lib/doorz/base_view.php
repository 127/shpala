<?php
class BaseView {
	protected $path = '/app/views/';
	protected $extension = '.phtml';
	protected $action_file; 
	
	public function __construct(&$router) {
		if (!is_dir($GLOBALS['APP_DIR'].$this->path.$router->params['controller'])){
			$router->error404('controller view');
		}
		$this->action_file = $GLOBALS['APP_DIR']
								.$this->path
								.$router->params['controller']
								.'/'
								.$router->params['action']
								.$this->extension;
		echo $this->action_file."\n";
		if (!file_exists($this->action_file)) {
			$router->error404('action view');
		}
	}
	
	public function render(&$_v) {
		include $this->action_file;
	}
}
	
?>