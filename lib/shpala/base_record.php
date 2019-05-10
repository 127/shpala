<?php
// TODO CRUD methods
// TODO refactor run() fetchAll
// TODO or/in/and methods 
class BaseRecord {
	/* DI public variables */
	public static $_db_di;
	public static $_prefix_di;
	
	/*  MODEL basics*/
	protected $_db;
	protected $_prefix = '';
	protected $_postfix = 'Model';
	protected $_table;
	protected $_columns = [];
	protected $_pkey = 'id';
	
	/* SQL request builder*/
	private $_proirity = [
		['select','update','delete'], //,'insert'
		['from'],
		['join'],
		['where'],
		['group','having'],
		['order', 'limit', 'offset']
	];
	private $_sql_params  = [];
	private $_sql_string  = '';
	private $_sql_binds	  = [];
	
	public function __construct() {
		$this->_db = self::$_db_di;
		$this->_prefix = self::$_prefix_di;
		if(!$this->_table){
			$this->_table = $this->_prefix.$this->_decamelize(substr(get_class($this), 0, -(strlen($this->_postfix)))).'s';
		}	
		foreach ($this->_db->query('DESCRIBE '.$this->_table)  as $row) {
			$p = $row['Field'];
			array_push($this->_columns, $p);
			$this->$p = null;
		}
		$this->call_init();
		return $this;
	}
	
    protected function call_init(){
        if(method_exists($this, 'init')){
            $this->init();
        }
    }
	
	public function set_db(&$db){
		$this->_db = $db;
	}
	
	public function get_db(){
		return $this->_db;
	}
	
	public function get_table(){
		return $this->_table;
	}
	
	public function set_pkey(string $key){
		$this->_pkey = $key;
	}
	
	public function get_pkey(){
		return $this->_pkey;
	}
	
	public function set_table(string $table, bool $autoprefix=true){
		$this->_table = ($autoprefix==true) ? $this->_prefix.$table : $table;
	}
	
	public function get_sql_string(){
		return isset($this->_sql_string_debug) ? $this->_sql_string_debug : false;
	}
	
	public function get_sql_binds(){
		return isset($this->_sql_binds_debug) ? $this->_sql_binds_debug : false;
	}

	// return int rowCount|0
	// TODO ->where & ->order
	public function delete($ids=null){
		$this->_sql_params['delete'] = 'DELETE ';
		if(is_numeric($ids)){
			$this->where([$this->_pkey=>$ids]);
		}
		if(is_array($ids)){
			$this->in($this->_pkey, array_map('intval', $ids));
		}
		return $this;
	}
	
	//return int lastInsertId
	public function create(array $params, bool $ignore=false){
		$s  = 'INSERT ';
		$s .= ($ignore==false ? '' : 'IGNORE ');
		$s .= 'INTO '.$this->_table.' (';
		$s .= implode(', ', array_keys($params)).') VALUES (';
		$s .= implode(', ', array_map(function($k){ 
			return ':'.$k;
		}, array_keys($params))).')';
		$this->_set_debug_and_clean($s, $params);
		$stmnt = $this->_db->prepare($s);
		$this->_bind_values($stmnt, $params);
		$stmnt->execute();
		return (int) $this->_db->lastInsertId();
	}
	
	// can be used with where and order
	public function update(array $params, bool $ignore=false){
		$this->_sql_params['update']  = 'UPDATE ';
		$this->_sql_params['update'] .= ($ignore==false ? '' : 'IGNORE ');
		$this->_sql_params['update'] .= $this->_table.' SET ';
		if($this->_is_assoc($params)){
			$this->_sql_params['update'] .=  implode(', ', array_map(function($c, $v){ 
				$k = $this->_get_alias();
				$this->_sql_binds[$k] = $v;
				return $c.'='.$k; 
			}, array_keys($params), $params) );
		} else {
			$tpl = array_shift($params);
			foreach($params as $p){
				$k = $this->_get_alias();
				$tpl = preg_replace('/\?/', $k, $tpl, 1);
				$this->_sql_binds[$k] = $p;
			}
			$this->_sql_params['update'] .= $tpl;
		}
		return $this;
	}
	
	public function find($params){
		if(is_numeric($params)){
			$this->select()->where([$this->_pkey=>$params]);
		}
		if(is_array($params) && count($params)>0){
			$this->select();
			$s = [];
			foreach($params as $v){
				$k = $this->_get_alias();
				$this->_sql_binds[$k] = $v;
				$s[]=$k;
			}
			$this->_sql_params['where'] = 'WHERE '.$this->_pkey.' IN ('.implode(', ', $s).')';
		}
		return $this;
	}
	
	public function first(){
		$this->select()->order([$this->_pkey])->limit(1);
		return $this;
	}
	
	public function take(int $limit){
		$this->select()->limit($limit);
		return $this;
	}
	
	public function select($params=null){
		if($params===null){
			$this->_sql_params['select'] = 'SELECT *';
		}
		if(is_string($params)) {
			$this->_sql_params['select'] = 'SELECT ' . $params;
		}
		if(is_array($params) && count($params)>0) {
			$this->_sql_params['select'] = 'SELECT ' . implode(', ', $params);
		}
		return $this;
	}
	
	public function count(string $params, string $as=''){
		if($as!=''){
			$as = ' as '.$as;
		} 
		$this->select('COUNT('.$params.')'.$as);
		return $this;
	}
	
	public function distinct(){
		if(isset($this->_sql_params['select'])){
			if(stristr($this->_sql_params['select'], 'COUNT')){
				$this->_sql_params['select'] = preg_replace('/^SELECT COUNT\((\w+)\)/', "SELECT COUNT(DISTINCT $1) ", $this->_sql_params['select']);
			} else {
				$this->_sql_params['select'] = str_replace('SELECT ', 'SELECT DISTINCT ', $this->_sql_params['select']);
			}
		} else {
			
		}
		return $this;		
	}
	
	public function from(array $tables=null){
		$this->_sql_params['from'] = 'FROM '.($tables!==null ? implode(', ', $tables) : $this->_table);
		return $this;
	}
		
	public function joins($params, $type='INNER'){
		if (is_string($params)) {
			if(stristr($params, 'JOIN') === false){
				$this->_sql_params['join'] = $type.' JOIN ';
			}
			$this->_sql_params['join'] .= $params;
		}
		if(is_array($params) && count($params)>0){
			foreach($params as $table){
				$join_table = $this->_prefix.$table;
				$this->_sql_params['join'] .= $type.' JOIN '.$join_table.' ON '.$this->_table.'.'.$this->_pkey.'='.$join_table.'.'.$this->_pkey; 
			}
		}
		return $this;
	}
	
	public function in(string $column, array $params){
		if(count($params)>0){
			$_s=[];
			foreach($params as $p){
				$k   = $this->_get_alias();
				$this->_sql_binds[$k] = $p;
				$_s[] = $k; 
			}
			$this->where($column.' IN ('.implode(', ', $_s).')');
		}
		return $this;
	}


	public function not($params){
		//User.where.not("name = 'Jon'")
		// # SELECT * FROM users WHERE NOT (name = 'Jon')
		if(is_string($params)){
			$this->where('NOT ('.$params.')');
		}
		if(is_array($params)){
			$_cnt = count($params);
			if($_cnt==1){
				$column = (array_keys($params))[0];
			}
			// User.where.not(name: %w(Ko1 Nobu))
			// # SELECT * FROM users WHERE name NOT IN ('Ko1', 'Nobu')
			if($_cnt==1 && is_array($params[$column])){
				$_s=[];
				foreach($params[$column] as $p){
					$k   = $this->_get_alias();
					$_s[]=$k;
					$this->_sql_binds[$k] = $p;
				}
				$this->where($column.' NOT IN ('.implode(', ', $_s).')');
			}
			
			// User.where.not(name: nil)
			// # SELECT * FROM users WHERE name IS NOT NULL
			if($_cnt==1 && $params[$column]==null){
				$this->where($column.' IS NOT NULL');
			}
			
			// User.where.not(name: "Jon")
			// # SELECT * FROM users WHERE name != 'Jon'
			if($_cnt==1 && !is_array($params[$column]) && $params[$column]!=null){
				$k   = $this->_get_alias();
				$this->_sql_binds[$k] = $params[$column];
				$this->where($column.'!='.$k);
			}
			
			// User.where.not(name: "Jon", role: "admin")
			// # SELECT * FROM users WHERE name != 'Jon' AND role != 'admin'
			if($_cnt>1){
				$_s = [];
				foreach($params as $k=>$v){
					$n   = $this->_get_alias();
					$this->_sql_binds[$n] = $v;
					$_s[] = $k.'!='.$n;
				}
				$this->where(implode(' AND ', $_s));	
			}
		}
		return $this;
	}
	
	public function or(){
		return $this;
	}
	
	public function where($params=null){
		if(!isset($this->_sql_params['where'])){
			$this->_sql_params['where'] = 'WHERE ';
		} else {
			$this->_sql_params['where'] .= ' AND ';  
		}
		if(!isset($params)) {
			return $this;
		}
		if (is_string($params)){
			$this->_sql_params['where'] .= $params;
		}
		if(is_array($params) && count($params)>0){
			if($this->_is_assoc($params)){
				$this->_sql_params['where'] .=  implode(', ', array_map(function($c, $v){ 
					$k = $this->_get_alias();
					$this->_sql_binds[$k] = $v;
					return $c.'='.$k; 
				}, array_keys($params), $params) );
			} else {
				$tpl = array_shift($params);
				foreach($params as $p){
					$k = $this->_get_alias();
					$tpl = preg_replace('/\?/', $k, $tpl, 1);
					$this->_sql_binds[$k] = $p;
				}
				$this->_sql_params['where'] .= $tpl;
			}
		}
		return $this;
	}
	
	//PDO fails to pass symols on order
	public function order($params){
		$this->_sql_params['order'] = 'ORDER BY ';
		if(is_string($params)){
			$this->_sql_params['order'] .= $params;
		}
		if(is_array($params) && count($params)>0) {
			$this->_sql_params['order'] .= implode(', ', array_map(function($k, $v){ 
				$key = is_numeric($k) ? $v : $k;
				$val = is_numeric($k) ? 'ASC' : $v;
				return $key.' '.$val;
			}, array_keys($params), $params) );
		}
		return $this;
	}
	
	public function group($params){
		$this->_sql_params['group'] = 'GROUP BY ';
		if(is_string($params)){
			$this->_sql_params['group'] .= $params;
		}
		if(is_array($params) && count($params)>0){
			$this->_sql_params['group'] .= implode(', ', $params);
		}
		return $this;
	}
	
	public function having($params){
		// if(!isset($this->_sql_params['group']) check if order section isset
		$this->_sql_params['having'] = 'HAVING ';
		if(is_string($params)){
			$this->_sql_params['having'] .= $params;
		}
		if(is_array($params) && count($params)>0){
			$tpl = array_shift($params);
			foreach($params as $p){
				$k = $this->_get_alias();
				$tpl = preg_replace('/\?/', $k, $tpl, 1);
				$this->_sql_binds[$k] = $p;
			}
			$this->_sql_params['having'] .= $tpl;
		}
		return $this;
	}
	
	public function limit(int $limit){
		$k = $this->_get_alias();
		$this->_sql_params['limit'] = 'LIMIT '.$k;
		$this->_sql_binds[$k] = $limit;
		return $this;
	}
	
	public function offset(int $offset){
		$k = $this->_get_alias();
		$this->_sql_params['offset'] = 'OFFSET '.$k;
		$this->_sql_binds[$k] = $offset;
		return $this;
	}
	
	public function run(){
		if(count(array_intersect($this->_proirity[0], array_keys($this->_sql_params)))==0){
			$this->select();
		}
		if(!isset($this->_sql_params['from']) && !isset($this->_sql_params['update'])){
			$this->from();
		}
		foreach($this->_proirity as $part){
			foreach($part as $v){
				if(isset($this->_sql_params[$v])){
					$this->_sql_string .= $this->_sql_params[$v].' ';
				}
			}
		}
		try {
			$stmnt = $this->_db->prepare($this->_sql_string);
			$this->_bind_values($stmnt, $this->_sql_binds);
			$stmnt->execute();
			if(isset($this->_sql_params['update']) || isset($this->_sql_params['delete'])){
				$r = $stmnt->rowCount();	
			} else {
				$r = $stmnt->fetchAll(PDO::FETCH_ASSOC);		
			}
			$this->_cleanup();
			return $r;
		} catch(PDOException $e) { 
			print_r($e->getMessage()); 
			$this->_cleanup();
		}

	}
	
	private function _bind_values(PDOStatement &$stmnt, array $values){
		if(count($values)==0){
			return $stmnt;
		}
		foreach($values as $k=>$v){
            switch( true ) {
                case is_numeric($v):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($v):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($v):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
             }
			 $stmnt->bindValue($k, $v, $type);
		}
		return $stmnt;
	}
	
	private function _get_alias(){
		return ':'.count($this->_sql_binds);
	}
	
	private function _is_assoc(array $arr){
	    if(array()===$arr){
			return false;
		}
	    return array_keys($arr) !== range(0, count($arr) - 1);
	}
	
	private function _cleanup(){
		$this->_sql_params_debug = $this->_sql_params;
		$this->_sql_string_debug = $this->_sql_string;
		$this->_sql_binds_debug  = $this->_sql_binds;
		$this->_sql_params  = [];
		$this->_sql_string  = '';
		$this->_sql_binds	= [];
	}
	
	private function _set_debug_and_clean(string $string, $params){
		$this->_sql_string  = $string;
		$this->_sql_binds	= is_array($params) ? $params : [$params];
		$this->_cleanup();
	}
	
	private function _decamelize(string $input){
		return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
	}
}
	
?>