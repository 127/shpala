<?php
class View {
  public $resource;
  public $errors=[];
  
  protected $view;
  
  private static $_tpl_layout;
  private static $_tpl_action; 
  
  private static $_path = '/app/views/';
  private static $_extension = '.html.php';
  private static $_layout_file = 'layouts/application'; //no extension
  private static $_public_path='/public/'; 
  
  public function __construct(Resource &$resource) {  
    $this->resource = $resource;
    $this->view = $resource->controller->view;
    if(isset($resource->i18n)) {
      $this->i18n = $resource->i18n;
    }
    $path = static::get_path();
    $ext  = static::get_extension();
    static::$_tpl_layout = $GLOBALS['APP_DIR'].$path.static::get_layout_file().$ext;
    static::$_tpl_action = $GLOBALS['APP_DIR'].$path
                .$this->resource->router->params['controller'].'/'
                .$this->resource->router->params['action']
                .$ext;
  }
  
  public static function set_path(string $value){
    static::$_path = $value;
  }
  
  public static function get_path(){
    return static::$_path;
  }
  
  public static function set_extension(string $value){
    static::$_extension = $value;
  }
  
  public static function get_extension(){
    return static::$_extension;
  }
  
  public static function set_layout_file(string $value){
    static::$_layout_file = $value;
  }
  
  public static function get_layout_file(){
    return static::$_layout_file;
  }
  
  public static function set_public_path(string $value){
    static::$_public_path = $value;
  }
  
  public static function get_public_path(){
    return static::$_public_path;
  }

  public function validate_layout(){
    if(!file_exists(static::$_tpl_layout)){
      $this->errors['layout_template_not_exists'] = true;
    }
    return (count($this->errors)>0) ? false : true;
  }
  
  public function validate_action(){
    if(!file_exists(static::$_tpl_action)){
      $this->errors['action_template_not_exists'] = true;
    }
    return (count($this->errors)>0) ? false : true;
  }
  
  public function render_layout(){
    //shortcut
    $_v=$this->view;
    $_t=$this->i18n;
    require_once static::$_tpl_layout;
  }
  
  public function render_action() {
    //shortcut
    $_v=$this->view;
    $_t=$this->i18n;
    require_once static::$_tpl_action;
  }
  
  public function render_partial($file, $vars) {
    require_once $file;
  }
  
  public static function render_static($file, $header=false){
    if($header!=false) {
      Router::header($header);
    }
    require_once $GLOBALS['APP_DIR'].static::get_public_path().$file;
    exit(0);
  }
}
  
?>