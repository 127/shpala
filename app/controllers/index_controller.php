<?php

class IndexController extends BaseController  {
	
	protected function init() {

	}

	public function IndexAction() {
		$this->view->title = 'indexAction';
	}
}
?>