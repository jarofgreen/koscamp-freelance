<?php
require_once( LIB_PATH.DS."class.database.php");

class CovingLetter extends DatabaseObject{
	protected static $table_name = TBL_CL;
	protected static $db_fields = array('id', 'fk_employer_id', 'cl_title', 'cl_text', 'created_at', 'modified_at','is_defult' );
	
	### list all fields
	public $id;
	public $fk_employer_id;
	public $cl_title;
	public $cl_text;
	public $created_at;
	public $modified_at;
	public $is_defult;
	
	public $errors=array();
	
	
	
	function __construct(){
		//$this->change_status_expired();
		$this->clean_db();
	}
	
	
	private function clean_db(){
		global $database, $db;
		
		$sql = " DELETE jt FROM ".self::$table_name." AS jt ";
		$sql .= " LEFT JOIN ".TBL_EMPLOYEE." as emp ON jt.fk_employer_id = emp.id ";
		$sql .= " WHERE emp.id IS NULL ";
		$database->query( $sql );
	}
	
	
	public static function find_by_id_username( $id=0, $username=null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE id= ".$db->escape_value($id);
		$sql .= " AND fk_employer_id=".$db->escape_value($username);
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
###################### account all #########################
	public static function count_all_by_employee( $id ) {
	  	global $database, $db;
		$id = (int)$id;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql.=" WHERE fk_employer_id=".$id;
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function employee_find_all($id){
		global $database, $db;
		$id = (int)$id;
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" WHERE fk_employer_id=".$db->escape_value($id);
		//echo $sql;
		return self::find_by_sql( $sql );
	}
	
	public function make_defult(){
		global $database, $db;
		$sql="UPDATE ".self::$table_name;
		$sql.=" SET  is_defult='N' ";
		$sql.=" WHERE fk_employer_id='".$this->fk_employer_id."' ";
		$database->query($sql);
		unset($sql);
		$sql="UPDATE ".self::$table_name;
		$sql.=" SET is_defult='Y' ";
		$sql.=" WHERE fk_employer_id='".$this->fk_employer_id."' AND id=".$this->id;
		//echo $sql;
		$database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	
	
	public function delete_by_user(){
	  global $database, $db;
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " AND fk_employer_id= '". $database->escape_value($this->fk_employer_id)."'";
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	

############################# Saving and Updating ##########################	
	public function save() {
		
		if( empty($this->fk_employer_id) ){
			$this->errors[] = get_lang('errormsg', 14);
		}
		
		if( empty($this->cl_title) ) {
			$this->errors[] = get_lang('errormsg', 15);
		}
		
		if( empty($this->cl_text) ) {
			$this->errors[] = get_lang('errormsg', 16);
		}
		
		
		// A new record won't have an id yet.
		if(isset($this->id)) {
			
			if( sizeof($this->errors) == 0 ) {
				$this->modified_at 	= date("Y-m-d H:i:s",time() );
				return $this->update();
			}
			
		}else{
			if( sizeof($this->errors) == 0 ) {
				$this->created_at 	= date("Y-m-d H:i:s",time() );
				//$this->modified_at 	= date("Y-m-d H:i:s",time() );
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

$covingletter 	= new CovingLetter();
$coving_letter &= $covingletter;

?>