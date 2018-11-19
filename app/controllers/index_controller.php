<?php
class IndexController extends ApplicationController {
	protected function init() {
		echo 'autorun init'."\n";
	}

	public function IndexAction() {
		echo 'index action index controller'."\n";
		// $this->view['title'] = 'indexAction';
		// $example = new ExampleModel(); needs existing table to be launched
	}
}
?>
