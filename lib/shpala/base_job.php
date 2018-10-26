<?
class BaseJob {
	 //1 hour default 
	protected $intval = 3600*1;
	
	public function __construct(&$db) {
		$this->call_init();
	}
	
    protected function call_init(){
        if(method_exists($this, 'init')){
            $this->init();
        }
    }
}
?>