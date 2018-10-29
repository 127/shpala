<?php
class JobPopulate extends BaseJob {
	private $_dir   = '/tmp/seeds/';
	private $_seeds = [];
	protected function init() {
		$this->_dir   = $GLOBALS['APP_DIR'].$this->_dir;
		$this->_seeds =  array_slice(scandir($this->_dir),3);
		foreach ($this->_seeds as $f){
			$ff = $this->_dir.'/'.$f;
			$seed = json_decode(file_get_contents($ff));
			$title_escaped 	 = mysqli_real_escape_string($this->_db, $seed->title);		
			$content_escaped = mysqli_real_escape_string($this->_db, $seed->content);		
			$url_escaped 	 = mysqli_real_escape_string($this->_db, $seed->uuid);
			$this->_db->query('INSERT INTO articles (uuid, title, keywords, author, source, preview, body) VALUES ("'.$seed->id.'", "'.$seed->title.'", "'.$seed->keywords.'", "'.$seed->author.'", "'.$url_escaped.'", "'.$content_escaped.'", "'.$content_escaped.'")');
			// print_r(array_keys(get_object_vars($obj)));
			//unlink($ff) or die('failed to unlink'.$ff."\n");
		}
		// print_r($this->_seeds);
	}
	
}	
?>