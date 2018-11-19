<?php
class Resource {
	public $conf;
	public $router;
	public $connect;
	public $controller;
	public $model; 
	public $view;
	public $i18n;
	// public $helpers;
	// public $jobs;
	
	public function __construct(Config &$conf, Router &$router, &$connect=false, i18n &$i18n=null){
		$this->conf = $conf;
		$this->i18n = $router;
		$this->connect = $connect;
		if(isset($database)) $this->database  = $database;
		if(isset($i18n)) 	 $this->i18n = $i18n;
		print_r($this);
	}
	
	public function build(){
		
	}
	
	public function validate(){
		
	}
	
	public function run(){
		echo 'run';
	}
	
		
}

?>