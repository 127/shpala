<?php
class JobPopulate extends BaseJob {
	private $_dir   = '/tmp/seeds/';
	private $_seeds = [];
	protected function init() {
		$this->_dir   = $GLOBALS['APP_DIR'].$this->_dir;
		$this->_seeds =  array_slice(scandir($this->_dir),3);
		if(count($this->_seeds)==0) 
			return;
		foreach ($this->_seeds as $f){
			$ff = $this->_dir.'/'.$f;
			$seed = json_decode(file_get_contents($ff));
			$stmt =  $this->_db->prepare('INSERT IGNORE INTO articles (url, uuid, title, keywords, author, source, preview, body) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
			$stmt->execute([$seed->url, 
							$seed->uuid, 
							$seed->title,
							$seed->keywords,
							$seed->author,
							$seed->uuid,
							$seed->preview,
							$seed->body
						   ]); // or die(print_r($stmt->errorInfo())); 
			unlink($ff) or die('failed to unlink'.$ff."\n");
		}
		// print_r($this->_seeds);
	}
	
}	
?>