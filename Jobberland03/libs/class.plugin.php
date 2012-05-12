<?php
require_once( LIB_PATH.DS."class.database.php");

class Plugin extends DatabaseObject{
	protected static $table_name = TBL_PLUGIN;
	protected static $db_fields = array('id', 'plugin_name', 'plugin_key','class_file','formfile', 'enabled');
	
	### list all fields
	public $id;
	public $plugin_name;
	public $plugin_key;
	public $class_file;
	public $formfile;
	public $enabled;
	
	//extra
	public $errors=array();
	
	
	function __construct(){
		$this->check_for_enable_plugin();
	}
	
	public function check_for_enable_plugin(){
		global $database, $db, $smarty;
		$setting = array();
		$sql = "SELECT * FROM ".self::$table_name;
		$sql .= " WHERE enabled='Y'";
		$result = $db->query($sql);
		if( $result ) {
			while ( $row = $db->fetch_array( $result ) ){
				//include_once(PLUGIN_PATH.DS.$row['plugin_name'].DS.$row['class_file']);
				
				defined( $row['plugin_key'] ) ? null : define( $row['plugin_key'], $row['enabled'] );
				$smarty->assign( $row['plugin_key'], $row['enabled']);
				$plugin_config 	= new PluginConfig();
				$plugin_config->plugin_id = $row['id'];
				$plugin_config->defined_keys();
			}
			return true;
		}
		else{
			die("Please import setting into your database");
		}
		return false;
	}


	public static function plugin_check( $id, $action ){
		$plugin_arr = self::find_by_id($id);
		include_once( PLUGIN_PATH . DS.strtolower($plugin_arr->plugin_name).DS."libs".DS.$plugin_arr->class_file );
		$PluginClass = new PluginClass();
		$PluginClass->plugin_id = $id;
		if( $action == 'Y' ) $PluginClass->install();
		else $PluginClass->uninstall();
	}


############################# Saving and Updating ##########################	
	public function save() {
		
		// A new record won't have an id yet.
		if(isset($this->id)) {
			return $this->update();
		}else{
			return $this->create();
		}
	}
	
/***********************************************************************/

	// Common Database Methods
	public static function find_all(){
		$sql=" SELECT * FROM " .self::$table_name;
		//echo $sql;
		return self::find_by_sql( $sql );
	}
	
	
	public static function find_by_id( $id=0 ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE id= ".$db->escape_value($id);
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public static function find_by_sql ( $sql="" ){
		global $database, $db;
		$result = $database->query( $sql );
		$object_array = array();
		while ($row = $database->fetch_array($result)) {
		  $object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	public static function count_all() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}

	private static function instantiate($record) {
		// Could check that $record exists and is an array
   	 $object = new self;

		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 

	  $attributes = array();
	  foreach(self::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitised_attributes() {
	  global $database, $db;
	  $clean_attributes = array();
	  foreach($this->attributes() as $key => $value){
		  if ( isset($value) && $value != "" ) {
	   	 	$clean_attributes[$key] = $database->escape_value($value);
		  }
	  }
	  return $clean_attributes;
	}
	
	public function create() {
		global $database, $db;
		$attributes = $this->sanitised_attributes();
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}

	public function update() {
	  global $database, $db;
		$attributes = $this->sanitised_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			if ( isset($value) && $value != "" ) {
		  		$attribute_pairs[] = "{$key}='{$value}'";
			}
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}


	public function delete() {
		global $database, $db;
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	
}

$plugin 	= new Plugin();
?>