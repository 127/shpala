<?php

class IndexController extends BaseController  {
	
	protected function init() {
		// print_r($this->db);
	}
	
	public function IndexAction() {
		// var_dump($this->_v);
		$this->view->title = 'indexAction';
		// echo $this->_v->title;
	}
}
?>