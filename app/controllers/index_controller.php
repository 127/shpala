<?php

class IndexController extends BaseController  {
	
	protected function init() {
		print_r($this->db);
	}
	
	public function IndexAction() {
		echo 'indexAction';
		
	}
}
?>