<?php
// TODO
// abstract class+interfaces to implement queue
// 
class Queue {
	private $_timer = '/tmp/jobs/.timer';
	private $_timer_error_message = 'touch timer failed';
	private $_jobs_dir = '/app/jobs/';
	private $_queue = [];
	private $_intval = 3;//3600*1; 	 //1 hour default 
	
	public function __construct() {
		$this->_timer = $GLOBALS['APP_DIR'].$this->_timer;
		$this->_jobs_dir = $GLOBALS['APP_DIR'].$this->_jobs_dir;
		$this->_queue  = array_slice(scandir($this->_jobs_dir), 3);
		if(file_exists($this->_timer)){
			if( (time()-filectime($this->_timer)) > $this->_intval){
				touch($this->_timer) or die($this->_timer_error_message);
				foreach ($this->_queue as $filename) {
					$f = pathinfo($filename);
					if($f['extension'] == 'php'){
						$class = $this->camelize($f['filename']);
						new $class();
					}
				}
			}
		} else {
			touch($this->_timer) or die($this->_timer_error_message);
		}
		return $this;
	}
	
	
	public function camelize($str, $delimiter='_'){
		return str_replace($delimiter, '', ucwords(strtolower($str), $delimiter));
	}
		
}
?>
