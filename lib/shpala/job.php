<?
class Job {
	protected $_jobs = [];
	protected $_db;
	protected $_intval = 3600*1; 	 //1 hour default 
	
	public function __construct(&$db) {
		$this->_db = &$db;
		// $f = $GLOBALS['APP_DIR'].'/tmp/jobs/.timer';
		// if(file_exists($f)){
		// 	if( (time()-filectime($f)) > $this->intval){
		// 		touch($f) or die('touch timer failed');
		// 		// $this->call_init();
		// 		//TODO GET ALL JOBS classes and runf all of
		// 	}
		// } else {
		// 	touch($f) or die('touch timer failed');
		// }
		return $this;
	}
	
    protected function call_init($class){
        if(method_exists($class, 'init')){
            $class->init();
        }
    }
	
}
?>