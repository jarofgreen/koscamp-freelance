<?php
require_once( LIB_PATH.DS."class.database.php");

class PluginConfig extends DatabaseObject{
	protected static $table_name = TBL_PLUGIN_CONFIG;
	protected static $db_fields = array('id', 'plugin_id' ,'plugin_key' ,'plugin_title' ,'plugin_desc' ,'plugin_value' ,'data_type' ,'input_type' ,'input_options' ,'last_modified' ,'date_added');

	### list all fields
	public $id;
	public $plugin_id=0;
	public $plugin_key;
	public $plugin_title;
	public $plugin_desc;
	public $plugin_value;
	public $data_type;
	public $input_type;
	public $input_options;
	public $last_modified;
	public $date_added;
	
	
	public $errors=array();
	
	
	function __construct(){
	}
	
	public function defined_keys(){
		global $database, $db, $smarty;
		$sql = "SELECT * FROM ".self::$table_name;
		$sql .= " WHERE plugin_id=".$this->plugin_id;
		$result = $db->query($sql);
		 if( $result ) {
			while ( $row = $db->fetch_array( $result ) ){
				defined( $row['plugin_key'] ) ? null : define( $row['plugin_key'], $row['plugin_value'] );
				$smarty->assign( $row['plugin_key'], $row['plugin_value']);
		    }
		    return true;
		}
	}

	public function get_pluginconfig_by_plugin_id(){
		global $database, $db;
		$sql = "SELECT * FROM ".self::$table_name;
		$sql .=" WHERE plugin_id=".$this->plugin_id;
		$sql .=" ORDER BY id ASC ";
		return self::find_by_sql( $sql );
	}	

	public function update_plugin(){
		global $database, $db;
		$replace_value= '</?[a-z][a-z0-9]*[^<>]*>';
		$value = eregi_replace($replace_value , '', $this->plugin_value );
		$value = $db->escape_value($value);
		
		$sql = " UPDATE ". self::$table_name;
		$sql.= " SET plugin_value='".$value."' ";
		$sql.= " WHERE id=".(int)$this->id." ";
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
	}
	
	public static function plugin_value( $plugin ){
		
		$return_value="";
		$id= $plugin->id;
		$name 			= $plugin->plugin_title;
		$input_type 	= $plugin->input_type;
		$input_options 	= $plugin->input_options;
		$value 			= $plugin->plugin_value;
		$input_options	= explode( "|", $input_options );
		
		$size = ( strlen($value) > 35 ) ? strlen($value) : strlen($value)+10;
		
		/// option button 
		if( $input_type == "select" ){
			$return_value = " <select name='plugin[".$id."]' >";
				foreach ( $input_options as $input_option ):
					$return_value .= "<option";
					$return_value .= ($input_option == $value) ? " selected='selected'":"";
					$return_value .= ">".$input_option."</option>";
				endforeach;
			$return_value .= "</select>";
		}
						
		elseif( $plugin->input_type == "textarea" ){
			$return_value = "<textarea name='plugin[".$id."]' cols='40' rows='5' >".$value."</textarea>";
		}
		///text filed
		elseif( $plugin->input_type == "text" ){
			$return_value = "<input type='text' name='plugin[".$id."]' value='".$value."' size='{$size}'>";
		}
		
		/// radio button
		elseif( $input_type == "radio" ){
			foreach ( $input_options as $input_option ):
				if( $input_option != "" ) {
					if( trim($input_option) == "" ) {
						$input_option = "leave it empty";
					}
					$return_value .= "<input type='radio' name='plugin[".$id."]' ";
					$return_value .= ($input_option == $value) ? " checked='checked'":"";
					$return_value .= "value='".$input_option."' />" . $input_option ;
				}
			endforeach;
		}
		
		
		else{}
		
		return $return_value;
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

$plugin_config 	= new PluginConfig();

?>