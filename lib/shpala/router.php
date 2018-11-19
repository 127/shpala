<?php
class Router {
	public $controllerClass;
	public $actionMethod;
	public $params = [];
	public $resources;
	protected $_rootController;
	protected $_rootAction;
	protected $_defaultAction = 'index';
	protected $_controllerPostfix = 'Controller';
	protected $_actionPostfix = 'Action';
	
	public function __construct(array &$config) {
		if(!isset($config['root'])) die('Set app root controller and action!');
		if(!isset($config['resources'])) die('No resources in app!');
		$this->resources = $config['resources'];
			
		$_l_ = explode('#', $config['root']);
		$this->_rootController = $_l_[0];
		$this->_rootAction 	   = $_l_[1];

		$url = explode('/', $_SERVER['REQUEST_URI']);
		$this->params['controller'] = ($url[1]!=false) ? $url[1] : $this->_rootController;
		$this->params['action'] = (isset($url[2]) && $url[2]!=false) ? $url[2] : $this->_defaultAction;
		
		$this->controllerClass = ucfirst($this->params['controller']).$this->_controllerPostfix;
		$this->actionMethod = ucfirst($this->params['action']).$this->_actionPostfix;

		if(count($url)>3){
			$kvals = array_slice($url,3);
			$this->params['vars'] = array();
			foreach (array_chunk($kvals, 2) as $pair) {
				if(!isset($pair[1]))
					$pair[1]=null;
				list($key, $value) = $pair;
				$this->params['vars'][$key] = $value;
			}
		}
	}
	
	// public function error404($subj){
	// 	 die($subj.' doesn\'t exist');
	// }
}
?>