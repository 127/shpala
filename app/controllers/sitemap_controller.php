<?php
class SitemapController extends ApplicationController {
	private $_excl = [
		'sitemap_index', 
		'sitemap_urls'
	];
	// Priorities by resource
	private $_priorities = [
		'defaults' => [
			'actions' => [0.5, 'monthly']
		],
		'index' => [
			// 'exclude'  => [	'index' ], //ecxlude action
			'priority' => [0.5, 'monthly']
		]
	];
	protected function init() {
		header('Content-Type: application/xml; charset=utf-8');
		$this->set_render_layout(false);
		View::set_extension('.xml.php');
	}

	public function IndexAction() {
		$_t = Router::get_routes_table();
		$this->view['index'] = array_diff(array_keys($_t), $this->_excl);	
	}
	
	public function ModuleAction() {
		$this->view['quantity'] = $this->_h->_quantity;
		$_c = str_replace('_sitemap.xml', '', trim($_SERVER['REQUEST_URI'], '/'));
		$this->view['controller'] = $_c;
		$_a = Router::get_controller_actions($_c);
		if(isset($this->_priorities[$_c]['exclude'])){
			$_ex = $this->_priorities[$_c]['exclude'];
			$_a = array_filter($_a, function($el) use ($_ex){
				if(!in_array($el, $_ex)){
					return $el;
				}
			});
		}
		$this->view['actions'] = $_a;
		if(isset($this->_priorities[$_c]['priority'])){
			$this->view['importance'] = $this->_priorities[$_c]['priority'][0];
			$this->view['frequency'] = $this->_priorities[$_c]['priority'][1];
		} else {
			$this->view['importance'] = $this->_priorities['defaults']['actions'][0];
			$this->view['frequency'] = $this->_priorities['defaults']['actions'][1];
		}
	}
	
}
?>
