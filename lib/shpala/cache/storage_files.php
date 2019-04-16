<?php
class StorageFiles implements StorageInterface {
	
	private $options=[];

	public function __construct(array $options) {
		$this->options = $options;
		if (!is_readable($this->options['path'])) {
			die("Cache dir is not readable");
		}
		if (!is_writable($this->options['path'])) {
			die("Cache dir is not writable");
		}
	}
	
	public function set_options(array $options){
		$this->options = array_merge($this->options, $options);
	}

	public function get_options(){
		return $this->options;
	}

	public function get_item(string $key){
		return $this->_read($key);
	}
		
	// public function get_items(array $keys){
	//
	// }
		
	public function has_item(string $key){
		$file = $this->options['path'].$key;
		$status = file_exists($file);
		if($status==true){
			if($this->_invalidate($file)==true){
				return false;
			}
		}
		return $status;
	}
		
	// public function has_items(array $keys){
	//
	// }
		
    public function set_item(string $key, string $value){
    	// if($this->has_item($key)==true){
		return $this->_write($key, $value);
		//     	}
		// return false;
    }
		
    // public function set_items(array $keyValuePairs){
    //
    // }
		
		//     public function add_item(string $key, string $value){
		//     	if($this->has_item($key)==false){
		// 	return $this->_write($key, $value);
		//     	}
		// return false;
    // }

    // public function add_items(array $keyValuePairs){
    //
    // }
		
    public function remove_item(string $key){
    	$this->_delete($key);
    }
		
    // public function remove_items(array $keys){
    //
    // }

    public function flush(){
    	
    }
	
 	private function _read(string $key){
		$file = $this->options['path'].$key;
		if(file_exists($file)){
			if($this->_invalidate($file)==true){
				return false;
			}
		}
		if (!is_readable($file)) {
			die("File is not readable $file");
		} 
		return file_get_contents($file);
 	}
	
 	private function _write(string $key, string $value){
		$file = $this->options['path'].$key;
		if(file_exists($file)){
			if($this->_invalidate($file)==true){
				return false;
			}
		}
	    if (!$handle = fopen($file, 'w')) {
	        die("Cannot open/create file ($file)");
	    }
	    if (fwrite($handle, $value) === false) {
	        die("Cannot write to file ($filename)");
	    }
	    fclose($handle);
		return true;
 	}
	
 	private function _delete(string $key){
		return unlink($this->options['path'].$key);
 	}
	
	private function _invalidate(string $file){
		if( (time()-filectime($file)) > $this->options['live']){
			return unlink($file);
		}
		return false;
	}
	
}
?>