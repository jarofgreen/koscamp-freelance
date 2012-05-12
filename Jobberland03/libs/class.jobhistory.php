<?php
require_once( LIB_PATH.DS."class.database.php");

class JobHistory extends Job{
	protected static $table_name = TBL_HISTORY;
	protected static $db_fields = array('id', 'fk_employee_id','fk_job_id', 'cv_name', 'cover_letter', 'date_apply','is_deleted');
	
	public $id;
	public $fk_employee_id;
	public $fk_job_id=0;
	public $cv_name;
	public $cover_letter;
	public $date_apply ;//= strftime(" %Y-%m-%d %H:%M:%S ", time() );
	public $is_deleted='N';
		
		
	function __construct(){
		//$this->change_status_expired();
		//$this->clean_db();
	}
		
		
	private function clean_db(){
		global $database, $db;
		$sql = " DELETE js FROM ".self::$table_name." AS js ";
		$sql .= " LEFT JOIN job as cj ON  cj.fk_job_id = js.id ";
		$sql .= " WHERE js.id IS NULL ";
		//$database->query( $sql );
		
	}
	
	public static function get_total_applicants( $id=0 ){
		global $database, $db;
		$sql = "SELECT count(*) as total FROM ".self::$table_name;
		$sql .= " WHERE fk_job_id = ".(int)$id;
		$sql .= " AND is_deleted = 'N' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	
	public static function find_by_user_id( $id=0 ){
		global $database, $db;
		if( !empty($id) ) {
			$sql = " SELECT * FROM ". self::$table_name;
			$sql .= " WHERE fk_employee_id= '".$db->escape_value($id)."'";
			$sql .= " ORDER BY date_apply DESC ";
			return self::find_by_sql( $sql );
		}
		return false;
	}
	
	public static function home_application_history( $id ){
		global $database, $db;
		
		$sql = " SELECT id, fk_job_id, date_apply FROM ". self::$table_name;
		$sql .= " WHERE fk_employee_id=".$db->escape_value($id);
		$sql .= " ORDER BY date_apply DESC ";
		$sql .= " LIMIT 5 ";
		$result = $db->query( $sql );
		
		if ( $db->num_rows( $result ) > 0  ){	
			$apps = array();
			$i=1;
			while( $app = $db->fetch_object( $result ) ):
			  $job_id = $app->fk_job_id;
			  $job = Job::find_active_job_by_id ( $job_id );
			  $apps[$i]['job_id'] = $job_id;
		
			  if ($job){
				$apps[$i]['job_title'] = $job->job_title;
				$apps[$i]['created_at'] = strftime(DATE_FORMAT, strtotime($job->created_at) );
				$apps[$i]['job_url'] = "job/".$job->var_name."/";
			  }
			  
				$apps[$i]['date_apply'] = strftime(DATE_FORMAT, strtotime($app->date_apply) );
				$apps[$i]['id'] = $app->id;
			  
			  $i++;
			endwhile;
			
			return $apps;	
		}
		
		return false;
	}
	
	
	public static function check_user_already_apply( $fk_job_id, $username ){
		global $database, $db;
		$sql = " SELECT * FROM ".self::$table_name;
		$sql .= " WHERE fk_employee_id= '".$db->escape_value($username)."'";
		$sql .= " AND fk_job_id=".(int)$fk_job_id;
		return self::find_by_sql( $sql );
	}
	
	public function delete_job(){
		global $database, $db;
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id = ".$this->id."
	  				 AND fk_employee_id = '". $database->escape_value($this->fk_employee_id) ."'
	  				 AND fk_job_id=". $database->escape_value($this->fk_job_id);
	  $sql .= " LIMIT 1";
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

$jobhistory 	= new JobHistory();
?>