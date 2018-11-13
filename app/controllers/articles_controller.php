<?php

class ArticlesController extends BaseController { //extends BaseController 
	
	
	// protected function init() {
	// 	echo 321;
	// 	print_r($this->db);
	// }
	
	
	function IndexAction(){
		$articles = new ArticleModel();
		// foreach($articles as $article ){
		// 	$this->view['articles'] .= '';
		// }
		$this->view['title'] = 'ArticlesController->IndexAction';
	}
}
?>