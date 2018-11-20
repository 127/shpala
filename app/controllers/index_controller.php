<?php
class IndexController extends ApplicationController {
	protected function init() {
		echo 'autorun init'."\n";
	}

	public function IndexAction() {
		$this->view['title'] = 'index action index controller';
	}
}
?>
