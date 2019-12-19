<?php
interface StorageInterface {
  public function set_options(array $options);
  public function get_options();
  public function get_item(string $key);
  // public function get_items(array $keys);
  public function has_item(string $key);
  // public function has_items(array $keys);
  public function set_item(string $key, string $value);
  // public function set_items(array $keyvals);
  // public function add_item(string $key, string $value);
  // public function add_items(array $keyvals);
  public function remove_item(string $key);
  // public function remove_items(array $keys);
  public function flush();
}
  
?>