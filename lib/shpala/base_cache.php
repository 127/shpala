<?php
abstract class BaseCache {
  protected static $adapters = null;
  private static $_defaults = [
    'adapter'=>'files', 
    'options'=>[
      'live'=>3600, 
      'path'=>'/tmp/cache/'
    ]
  ];
  private static $_convention = 'Storage';
  
  public static function factory($config=null){
    static::$_defaults['options']['path'] = $GLOBALS['APP_DIR'].static::$_defaults['options']['path'];
    $options = static::$_defaults['options'];
    $adapter_name = static::$_defaults['adapter'];
    if(is_string($config)) {
      $adapter_name = $config;
    }
    if(is_array($config)){
      $adapter_name = isset($config['adapter']) ? $config['adapter'] : $adapter_name;
      $options = isset($config['options']) ? array_merge($options, $config['options']) : $options;
    }
    if ($adapter_name=='') {
      die('Missing adapter');
    }
    if (static::$adapters === null) {
      $_n = static::$_convention.ucfirst($adapter_name);
      static::$adapters = new $_n($options);
    }
    return static::$adapters;
  }
}

?>