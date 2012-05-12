<?php
require_once( LIB_PATH.DS."class.database.php");

class SaveJob extends Job{
	protected static $table_name = TBL_SAVE_JOB;
	protected static $db_fields = array('id', 'fk_employee_id','fk_job_id', 'date_saved','is_deleted');
	
	public $id;
	public $fk_employee_id;
	public $fk_job_id=0;
	public $date_saved;
	public $is_deleted='N';
	
	//other
	public $errors=array();


	public function delete_saveJob() {
	  global $database, $db;
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " AND fk_employee_id=".$database->escape_value($this->fk_employee_id);
	  $sql .= " AND fk_job_id=".$database->escape_value($this->fk_job_id);	  
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	
	public static function find_by_user_id( $id ) {
		global $database, $db;
		if( !empty($id) ) {
			$sql = " SELECT * FROM ". self::$table_name;
			$sql .= " WHERE fk_employee_id=".$db->escape_value($id)." ";
			$sql .= " ORDER BY date_saved DESC ";
			//echo $sql;
			return self::find_by_sql( $sql );
		}
		return false;
	}
	
	
	public function already_existed(){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE fk_employee_id= '".$this->fk_employee_id."' ";
		$sql .= " AND fk_job_id =" .$this->fk_job_id ;
		$sql .= " LIMIT 1  ";
		//return self::find_by_sql( $sql );
		$result = $database->query($sql);
		return $database->num_rows($result) ? true : false;
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

$savejob 	= new SaveJob();
$savejob = &$save_job;
?>