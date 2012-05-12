<?php
require_once( LIB_PATH.DS."class.database.php");

class Job2Type extends Job {
	protected static $table_name = TBL_JOB_2_TYPE;
	protected static $db_fields = array('fk_job_id', 'fk_job_type_id');
	
	public $fk_job_id;
	public $fk_job_type_id;
	
	
	function __construct(){
		$this->clean_db();
	}
	
	
	private function clean_db(){
		global $database, $db;
		
		$sql = " DELETE jt FROM ".self::$table_name." AS jt ";
		$sql .= " LEFT JOIN ".TBL_JOB." as j ON jt.fk_job_id = j.id ";
		$sql .= " WHERE j.id IS NULL ";
		$database->query( $sql );
	}
	

	
	public static function make ( $fk_job_id=0, $fk_job_type_id=0 ){
		$fk_job_id 		= (int)$fk_job_id; 
		$fk_job_type_id	= (int)$fk_job_type_id; 
		
		if ( $fk_job_type_id != "" && $fk_job_id != "" ) {
			$new_record = new Job2Type();
			$new_record->fk_job_id 		= (int)$fk_job_id;
			$new_record->fk_job_type_id = (int)$fk_job_type_id;
			return $new_record;
		}else{
			return false;
		}
	}
	
	
	public static function find_all_type_by_jobid( $id=0 ){
		$sql = "SELECT * FROM ".self::$table_name." WHERE fk_job_id =".$id;
		
		return self::find_by_sql( $sql );
	}
	
	
#################deleteing jobs from job type as need to update ###################
	public function delete_all_on_update(){
		global $database, $db;
		$sql = " DELETE ".self::$table_name;
		$sql .= " FROM ".self::$table_name;
		$sql .= " LEFT JOIN ".TBL_JOB." AS job ON job.id=".self::$table_name.".fk_job_id ";
		$sql .= " WHERE job.id=".$this->fk_job_id;
		
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
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

$job2type 	= new Job2Type();
?>