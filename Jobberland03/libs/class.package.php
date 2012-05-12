<?php
require_once( LIB_PATH.DS."class.database.php");

class Package extends DatabaseObject{
	protected static $table_name = TBL_PACKAGE;
	protected static $db_fields = array('id', 'package_name',  'package_desc', 'package_price', 'package_job_qty', 'standard', 'spotlight', 'cv_views','is_active', 'date_inactive');
	
	public $id;
	public $package_name;
	public $package_desc;
	public $package_price ;
	public $package_job_qty ;
	public $standard;
	public $spotlight;
	public $cv_views;
	public $is_active ;
	public $date_inactive ;
	
	
	public $errors=array();
	
	
	public function find_all_active_spotlight(){
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" WHERE is_active = 'Y' AND spotlight='Y' AND standard='N' AND cv_views='N' ";
		//echo $sql;
		return self::find_by_sql( $sql );
	}
	
	public function find_all_active_standard(){
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" WHERE is_active = 'Y' AND standard='Y' AND spotlight='N' AND cv_views='N' ";
		//echo $sql;
		return self::find_by_sql( $sql );
	}
	
	public function find_all_active_cv(){
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" WHERE is_active = 'Y' AND cv_views='Y' ";
		return self::find_by_sql( $sql );
	}

	public function find_all_active(){
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" WHERE is_active = 'Y' ";
		//echo $sql;
		return self::find_by_sql( $sql );
	}

	public function find_all_active_spotlight_standard(){
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" WHERE is_active = 'Y' AND spotlight='Y' AND standard='Y' AND cv_views='N' ";
		//echo $sql;
		return self::find_by_sql( $sql );
	}

	public function find_all_active_spotlight_cv(){
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" WHERE is_active = 'Y' AND spotlight='Y' AND standard='N' AND cv_views='Y' ";
		//echo $sql;
		return self::find_by_sql( $sql );
	}
	
	public function find_all_active_standard_cv(){
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" WHERE is_active = 'Y' AND spotlight='N' AND standard='Y' AND cv_views='Y' ";
		//echo $sql;
		return self::find_by_sql( $sql );
	}


############################# Saving and Updating ##########################	
	public function save() {
	  // A new record won't have an id yet.
	  
	  if( empty($this->package_name) ){
	  	$this->errors[] = "Please enter package name";
	  }
	  
	  if( empty($this->package_desc) ){
		  $this->errors[] = "Please enter package description";
	  }
	  
	  if( empty($this->package_price) ){
		  $this->errors[] = "Please enter package price";
	  }
	  
	  if( empty($this->package_job_qty) ){
		  $this->errors[] = "Please enter package qty";
	  }
	  
	  if( empty($this->spotlight) && empty($this->cv_views) && empty($this->standard) ){
		  $this->errors[] = "Please enter one of the standard or spotlight or cv views";
	  }
	  
	  if( $this->spotlight == 'N' && $this->cv_views == 'N' && $this->standard == 'N' ){
		  $this->errors[] = "Please select standard or spotlight or cv views";
	  }
	  
	  if( sizeof($this->errors) == 0 ){
				
		  if( isset($this->id) ){
			  return $this->update();
		  }else{
			  return $this->create();
		  }
		  
	  }
	  return false;
	}
	
	
	
/***********************************************************************/

	// Common Database Methods
	public static function find_all(){
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" ORDER BY id DESC ";
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

$package 	= new Package();
?>