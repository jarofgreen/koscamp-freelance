<?php
require_once( LIB_PATH.DS."class.database.php");

class Experience extends DatabaseObject{
	protected static $table_name = TBL_YEAR_EXPERIENCE;
	protected static $db_fields = array('id', 'var_name', 'experience_name',  'is_active');
	
	public $id;
	public $var_name;
	public $experience_name;
	public $is_active='Y';
	
	public $errors=array();
	
	function __construct(){
		$this->find_all_not_set_var_name();
	}
	
	//this will set the ver_name
	public function find_all_not_set_var_name(){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE var_name= '' ";
		//echo $sql;
		//die;
		$result = $database->query( $sql );	
		if( $result ) {
			while ( $c = $db->fetch_object( $result ) ) {
				if( empty( $c->var_name) ||  $c->var_name == ''){
					$var_name = $this->mod_write_check( $c->experience_name, NULL );
					$sql = " UPDATE ".self::$table_name;
					$sql .= " SET var_name='".$var_name."' ";
					$sql .= " WHERE id=".$c->id;
					//echo $sql;
					//die;
					$database->query( $sql );
				}
			}
		}
	}
	
	public static function find_by_var_name( $var_name = null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE var_name= '".$db->escape_value($var_name)."'";
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public function mod_write_check( $url ){
		$mod_name = mod_url_rewriter($url);
		$does_not_existed = false;
		$i=1;
		if( self::find_by_var_name( $mod_name ) ){
				while( !$does_not_existed )
				{ 
					if( !self::find_by_var_name( $mod_name.$i ) )
					{
						$does_not_existed = true;
						$mod_name = $mod_name.$i;
					}else{
						$i++;
					}
			   }
		}
		
		return $mod_name;
	}
	
############################# Saving and Updating ##########################	
	public function save() {
		
		if( empty($this->experience_name) ){
			$this->errors[]=get_lang('errormsg', 12);
		}
		
		if( sizeof($this->errors) == 0 ){
			// A new record won't have an id yet.
			if(isset($this->id)) {
				return $this->update();
			}else{
				return $this->create();
			}
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
		$sql .= " WHERE id=".$db->escape_value($id);
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
	    $clean_attributes[$key] = $database->escape_value($value);
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
		  $attribute_pairs[] = "{$key}='{$value}'";
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

$experience 	= new Experience();
?>