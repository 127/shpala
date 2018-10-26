<?
class BaseJob {
	 //1 hour default 
	protected $intval = 3600*1;
	
	public function __construct(&$db) {
		$f = $GLOBALS['APP_DIR'].'/tmp/jobs/.timer';

		if(file_exists($f)){ 
			if( (time()-filectime($f)) > $intval){
				touch($f) or die('touch timer failed');
				$this->call_init();
			}
		} else {
			touch($f) or die('touch timer failed');
		}
	}
	
    protected function call_init(){
        if(method_exists($this, 'init')){
            $this->init();
        }
    }
	
}
?>