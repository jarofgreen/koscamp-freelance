<?php
require_once( LIB_PATH.DS."class.database.php");

class SaveSearch extends Job{
	protected static $table_name = TBL_SAVE_SEARCH;
	protected static $db_fields = array('id', 'fk_employee_id','reference_name','reference', 'date_save','is_deleted');
	
	public $id;
	public $fk_employee_id;
	public $reference_name;
	public $reference=false;
	public $date_save="";
	public $is_deleted='N';

	public $errors = array();
	
/**
	public static function make( $employee_id, $reference ){
		global $database, $db;
		if( !empty($username) && !empty($ref_search) ){
			$employee_id 		= $database->escape_value( $employee_id );
			$reference		= $database->escape_value( $reference );
			$save_search = new SaveSearch();
			$save_search->fk_employee_id	= $employee_id;
			$save_search->ref_search 		= $reference;
			$save_search->date_saved		= strftime(" %Y-%m-%d %H:%M:%S ", time() );			
			return $save_search;
		}else{
			return false;
		}
	}
**/	
	public static function find_by_user_id( $employee_id=0 ) {
		global $database, $db;
		if( !empty($employee_id) ) {
			$sql = " SELECT * FROM ". self::$table_name;
			$sql .= " WHERE fk_employee_id=".(int)$db->escape_value($employee_id);
			$sql .= " ORDER BY date_save DESC ";
			return self::find_by_sql( $sql );
		}
		return false;
	}
	
	
	public static function already_existed( $emp_id=0, $reference=null){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE fk_employee_id='".(int)$emp_id."' ";
		$sql .= " AND reference ='" .$reference."' " ;
		$sql .= " LIMIT 1  ";
		$result = $database->query($sql);
		return $database->num_rows($result) ? true : false;
	}
	
	public function delete_saveSearch(){
		global $database, $db;
		$sql = "DELETE FROM ".self::$table_name;
		$sql .= " WHERE id=". $database->escape_value($this->id);
		$sql .= " AND fk_employee_id=".$database->escape_value($this->fk_employee_id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;	
	}

############################# Saving and Updating ##########################	
	public function save() {
		
		if( empty($this->fk_employee_id) ){
			$this->errors[] = "No User found";
		}
		
		if( empty($this->reference) ){
			$this->errors[]="No Reference";
		}
		
		if ( sizeof( $this->errors) == 0 ){
			// A new record won't have an id yet.
			if(isset($this->id)) {
				return $this->update();
			}else{
				$this->date_save = strftime(" %Y-%m-%d %H:%M:%S ", time() );	
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

$savesearch 	= new SaveSearch();
?>