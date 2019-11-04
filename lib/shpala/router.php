<?php
class Router {
	public $controller_class;
	public $action_method;
	public $params = [];
	public $resources;
	public $current_resource;
	private static $_root_controller;
	private static $_root_action;
	private static $_controller_postfix = 'Controller';
	private static $_action_postfix = 'Action';
	private static $_sep_ = '#';
	private static $_default_action = 'index';
	private static $_routing_table;
    private static $_http = [
        100 => 'HTTP/1.1 100 Continue',
        101 => 'HTTP/1.1 101 Switching Protocols',
        200 => 'HTTP/1.1 200 OK',
        201 => 'HTTP/1.1 201 Created',
        202 => 'HTTP/1.1 202 Accepted',
        203 => 'HTTP/1.1 203 Non-Authoritative Information',
        204 => 'HTTP/1.1 204 No Content',
        205 => 'HTTP/1.1 205 Reset Content',
        206 => 'HTTP/1.1 206 Partial Content',
        300 => 'HTTP/1.1 300 Multiple Choices',
        301 => 'HTTP/1.1 301 Moved Permanently',
        302 => 'HTTP/1.1 302 Found',
        303 => 'HTTP/1.1 303 See Other',
        304 => 'HTTP/1.1 304 Not Modified',
        305 => 'HTTP/1.1 305 Use Proxy',
        307 => 'HTTP/1.1 307 Temporary Redirect',
        400 => 'HTTP/1.1 400 Bad Request',
        401 => 'HTTP/1.1 401 Unauthorized',
        402 => 'HTTP/1.1 402 Payment Required',
        403 => 'HTTP/1.1 403 Forbidden',
        404 => 'HTTP/1.1 404 Not Found',
        405 => 'HTTP/1.1 405 Method Not Allowed',
        406 => 'HTTP/1.1 406 Not Acceptable',
        407 => 'HTTP/1.1 407 Proxy Authentication Required',
        408 => 'HTTP/1.1 408 Request Time-out',
        409 => 'HTTP/1.1 409 Conflict',
        410 => 'HTTP/1.1 410 Gone',
        411 => 'HTTP/1.1 411 Length Required',
        412 => 'HTTP/1.1 412 Precondition Failed',
        413 => 'HTTP/1.1 413 Request Entity Too Large',
        414 => 'HTTP/1.1 414 Request-URI Too Large',
        415 => 'HTTP/1.1 415 Unsupported Media Type',
        416 => 'HTTP/1.1 416 Requested Range Not Satisfiable',
        417 => 'HTTP/1.1 417 Expectation Failed',
        500 => 'HTTP/1.1 500 Internal Server Error',
        501 => 'HTTP/1.1 501 Not Implemented',
        502 => 'HTTP/1.1 502 Bad Gateway',
        503 => 'HTTP/1.1 503 Service Unavailable',
        504 => 'HTTP/1.1 504 Gateway Time-out',
        505 => 'HTTP/1.1 505 HTTP Version Not Supported',
	];
	
	public function __construct(array &$config) {
		if(!isset($config['root'])) {
			die('Set app root controller and action!');
		}
		if(!isset($config['resources'])) {
			die('No resources in app!');
		}
		
		$this->resources = $config['resources'];
		$_l_ = explode(static::get_separator(), $config['root']);
		static::set_root_controller($_l_[0]);
		static::set_root_action($_l_[1]);
		
		//set up defaults by url
    $_params_pos = strpos($_SERVER['REQUEST_URI'], '?');
    $request = !$_params_pos ? $_SERVER['REQUEST_URI'] : substr($_SERVER['REQUEST_URI'], 0, $_params_pos);
		$url = explode('/', $request);
		$this->params['controller'] = ($url[1]!=false) ? $url[1] : static::get_root_controller();
		$this->params['action'] = (isset($url[2]) && $url[2]!=false) ? $url[2] : static::get_default_action();
		if(in_array($this->params['controller'], $this->resources)){
			$this->current_resource = $this->params['controller'];
		}

		// map to routing config requested controller and action
		static::set_routes_table($this->resources);
		// $table = static::get_routes_table();
		foreach($this->resources as $name=>$resource){
			if(isset($resource['as'])){
				if(isset($resource['regexp'])){
					if(preg_match($resource['regexp'], $request)){
						$this->current_resource = $name;
						$_m_ = preg_replace($resource['regexp'], $resource['as'], trim($request, '/'));
						$_m_ = explode('/', $_m_);
						$_m_ = explode(static::get_separator(), $_m_[0]);
						$this->params['controller'] = $_m_[0];
						$this->params['action'] = $_m_[1];
						break;
					}
				} elseif(isset($resource['path'])) {
					if($resource['path']==$this->params['controller']){
						$this->current_resource = $name;
						$_l_ = explode(static::get_separator(), $resource['as']);
						$this->params['controller'] = $_l_[0];
						$this->params['action'] = $_l_[1];
						break;
					}
				}
			} 
			// TODO
			// elseif(isset($resource['controller'])){
			//
			// }
		}
		$this->controller_class = ucfirst($this->params['controller']).static::get_controller_postfix();
		$this->action_method = ucfirst($this->params['action']).static::get_action_postfix();

		if(count($url)>3){
			$kvals = array_slice($url,3);
			$this->params['vars'] = array();
			foreach (array_chunk($kvals, 2) as $pair) {
				if(!isset($pair[1])){
					$pair[1]=null;
				}
				list($key, $value) = $pair;
				$this->params['vars'][$key] = $value;
			}
		}
	}
	
	public static function set_root_controller(string $name){
		static::$_root_controller = $name;
	}
	public static function get_root_controller(){
		return static::$_root_controller;
	}
	
	public static function set_root_action(string $name){
		static::$_root_action = $name;
	}
	public static function get_root_action(){
		return static::$_root_action;
	}
	
	public static function set_controller_postfix(string $name){
		static::$_controller_postfix = $name;
	}
	public static function get_controller_postfix(){
		return static::$_controller_postfix;
	}
	
	public static function set_action_postfix(string $name){
		static::$_action_postfix = $name;
	}
	public static function get_action_postfix(){
		return static::$_action_postfix;
	}
	
	public static function set_separator(string $name){
		static::$_sep_ = $name;
	}
	public static function get_separator(){
		return static::$_sep_;
	}
	
	public static function set_default_action(string $name){
		static::$_default_action = $name;
	}
	public static function get_default_action(){
		return static::$_default_action;
	}
	
	public static function set_routes_table($resources){
		$r = [];
		foreach($resources as $k=>$v){
			$is_array = is_array($v);
			$resname  = $is_array ? $k  : $v;
			if(!isset($r[$resname])){
				$r[$resname] = [];
			}
			if(!$is_array){
				$r[$resname]['controller'] = $resname;
				$r[$resname]['actions'] = static::get_controller_actions($resname);
			} else {
				if(isset($v['as'])){
					$_l_ = explode(static::get_separator(), $v['as']);
					$r[$resname]['controller'] = $_l_[0];
					$r[$resname]['actions'] =  $_l_[1];
					if(isset($v['regexp'])){
						$r[$resname]['regexp'] = $v['regexp'];
					} elseif(isset($v['path'])){
						$r[$resname]['path'] = $v['path'];
					}
				} elseif(isset($v['controller'])){
					$r[$resname]['controller'] = $v['controller'];
					$r[$resname]['actions'] =  static::get_controller_actions($v['controller']);
				}
			}
		}
		static::$_routing_table = $r;
	}
	
	public static function get_routes_table(){
		return static::$_routing_table;
	}
	
	public static function get_controller_actions($controller){
		$class_name = ucfirst($controller).static::get_controller_postfix();
		$class_methods = get_class_methods($class_name);
		$actions = preg_grep("/^(.*)".static::get_action_postfix()."$/", $class_methods);
		$r = array_map(function($el){
			return strtolower(str_replace(static::get_action_postfix(), '', $el));
		}, $actions);
		return $r;
	}
	
	public static function get_routes_info(){
		$table = static::get_routes_table();
		if(!$table){
			return false;
		}
		$o = '';
		foreach ($table as $k=>$v){
			if(isset($v['regexp'])){
				preg_match('/\/(.*)\/(.*)/', $v['regexp'], $_m_);
				$o .= "/{$_m_[1]}   ===========>  {$v['controller']}#{$v['actions']}\n";	
			} elseif(isset($v['path'])) {
				$o .= "/{$v['path']}   ===========>  {$v['controller']}#{$v['actions']}\n";	
			} else {	
				foreach($v['actions'] as $action){  
					$p = isset($v['path']) ? $v['path'] : "{$v['controller']}/{$action}"; 
					$o .= "/{$p}   ===========>  {$v['controller']}#{$action}\n";	
				}
			}
		}
		return $o;
	}
	
	public static function header(int $num){
		header(static::$_http[$num]);
	}
	
	public function redirect($location, $num=false){
		if($num!=false) {
			static::header($num);
		}
		header("Location: {$location}");
    exit(0);
	}
}
?>