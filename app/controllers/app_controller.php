<?php
// use lib\doorz;

class AppController extends BaseController {
	
	// protected $db;
	
	function __construct() {
		parent::__construct();
		print_r($this->db);
		echo 1;
	}
	
}
?>