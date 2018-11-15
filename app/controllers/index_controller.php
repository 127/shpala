<?php

class IndexController extends BaseController  {
	
	protected function init() {

	}

	public function IndexAction() {
		$this->view['title'] = 'indexAction';
		// $example = new ExampleModel(); needs existing table to be launched
	}
}
?>