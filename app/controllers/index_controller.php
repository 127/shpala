<?php
class IndexController extends ApplicationController {
	protected function init() {
		echo 'autorun init'."\n";
	}

	public function IndexAction() {
		$this->view['model']= new SchemaMigrationModel();
		$this->view['title'] = 'index action index controller';
	}
	
	public function AnotherAction() {}
}
?>
