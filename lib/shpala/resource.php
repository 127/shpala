<?php
class Resource {
  public $name;
  
  //resources links
  public $connect=null;
  public $controller;
  public $view;
  public $i18n=null;
  public $router;
  public $errors=[];
  // public $model;
  // public $helpers;
  // public $jobs;
  
  public function __construct(Router &$router, 
                PDO &$connect=null, 
                i18n &$translate=null,
                BaseHelpers &$helpers=null,
                Config &$config=null){
    $this->name   = $router->current_resource;
    $this->router = $router;
    $this->config = $config;
    if(isset($translate)) {
      $this->i18n = $translate;
    }
    if(isset($connect)){
      $this->connect = $connect;
    }
    if(isset($helpers)){
      $this->helpers = $helpers;
    }
  }
  
  public function build(){
    //=========JOBS============//
    if($this->connect!=null){
      BaseJob::$_db_di = $this->connect;
    }
    new Queue();
    //=========APP============//
    $this->controller = new $this->router->controller_class($this);
  }
  
  public function validate_resource(){
    // if(!in_array($this->name, $this->router->resources)){
    //   if(!isset($this->router->resources[$this->name])){
    //     $this->errors['no_resource_identified'] = true;
    //   }
    // }
    if (!class_exists($this->router->controller_class)){
      $this->errors['controller_class_not_exists'] = true;
    }
    if (!method_exists($this->router->controller_class, $this->router->action_method)){
      $this->errors['action_method_not_exists'] = true;
    }
    return (count($this->errors)==0) ? true : false;
  }

  
  public function run(){
    $action = $this->router->action_method;
    $this->controller->$action();
  }
  
  public function init_view(){
    $this->view = new View($this);
  }
}

?>