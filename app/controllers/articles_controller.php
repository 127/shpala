<?php

class ArticlesController { //extends BaseController 
	
	
	// protected function init() {
	// 	echo 321;
	// 	print_r($this->db);
	// }
	
	
	function IndexAction(){
		$a = new ArticleModel();
		$this->view['title'] = 'ArticlesController->IndexAction';
	}
}
?>