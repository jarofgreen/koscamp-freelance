<?php
require_once( LIB_PATH.DS."class.database.php");

class JobCategory extends DatabaseObject{
	protected static $table_name = TBL_JOB_2_CAT;
	protected static $db_fields = array('category_id', 'job_id');
	
	public $category_id;
	public $job_id;
	
	public $errors=array();


	function __construct(){
		$this->delete_invalid_records();
	}
	
	/** DELETE RECORD IF JOB DOES NOT EXISTED **/
	private function delete_invalid_records(){
		global $database, $db;
		//delete job type if job does not existed
		$sql = " DELETE jc FROM ".self::$table_name." AS jc ";
		$sql .= " LEFT JOIN ".TBL_JOB." AS job ON jc.job_id = job.id ";
		$sql .= " WHERE job.id IS NULL ";
		//echo $sql;
		//DELETE jc FROM jobs2categories AS jc LEFT OUTER JOIN job ON jc.job_id = job.id WHERE job.id IS NULL
		
		$database->query( $sql );
		return ($database->affected_rows() >= 1) ? true : false;
	}
	
	
/*****************************************************************/

	public static function make( $category_id="", $job_id="" ){
		global $database, $db;
		
		$category_id = $db->escape_value( $category_id );
		
		if( !empty($category_id) && $category_id != "" ){
			$cat = new 	JobCategory();
			$cat->category_id = $category_id;
			$cat->job_id = $job_id;
			//print_r($cat);
			return $cat;
		}else{
			return false;
		}
	}
	
	public function get_job_by_category(){
		global $database, $db;
		$sql = " SELECT * FROM ".self::$table_name;
		$sql .= " GROUP BY category_id ";
		return self::find_by_sql( $sql );
	}
	
	public function find_active_category(){
		global $database, $db;
		$sql = " SELECT * FROM ".self::$table_name. ", ".TBL_JOB." AS job";
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
						AND job.id = job_id
						AND is_active ='Y'
						AND job_status = 'approved' 
					GROUP BY category_id ";
		return self::find_by_sql( $sql );
	}
	
	
	public static function get_total_job_by_cat ( $id=0 ){
		global $database, $db;
		$sql = " SELECT Count(job_id) as total_job  FROM ".self::$table_name. ", ".TBL_JOB." AS job";
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
						AND job.id = job_id
						AND job_status = 'approved' 
						AND category_id = '".$db->escape_value( $id )."'
						AND is_active ='Y'";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	
	public static function list_job_by_cat_search_total ( $id=0 ){
		global $database, $db;
		$sql = " SELECT job_id FROM ".self::$table_name. ", ".TBL_JOB." AS job";
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
						AND job.id = job_id
						AND category_id = '".$db->escape_value( $id )."'
						AND is_active ='Y' 
						AND job_status = 'approved' ";	
		 return self::find_by_sql( $sql );
	}

	public static function list_job_by_cat ( $id=0, $per_page=null, $offset=null ){
		global $database, $db;
		$sql = " SELECT job_id FROM ".self::$table_name. ", ".TBL_JOB." AS job";
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
						AND job.id = job_id
						AND category_id = '".$db->escape_value( $id )."'
						AND is_active ='Y' 
						AND job_status = 'approved' ";
		  $sql .= " LIMIT ".$per_page." OFFSET ".$offset;
		
		 return self::find_by_sql( $sql );
	}

	
	public static function top_ten_cat( $cat_id ){
		global $database, $db;
		$sql = " SELECT count(category_id) maxnum, category_id, job_id, cat.var_name ";
		$sql .= "FROM ".TBL_JOB." AS job, ".self::$table_name .", ". TBL_CATEGORY ." AS cat ";
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW()
				  AND job.id = job_id
				  AND job.is_active = 'Y'
				  AND job_status = 'approved' 
				  AND cat.var_name <> '{$cat_id}'
				  AND cat.id = category_id  
				  GROUP BY category_id
				  ORDER BY maxnum DESC 
				  LIMIT 0, ".MAX_CATEGORY;
		//echo $sql;
		return self::find_by_sql( $sql );
	}

	
################################################################
	public function get_cat_by_job_id(){
		global $database, $db;
		$sql  =" SELECT category_id FROM ".self::$table_name;
		$sql .=" WHERE job_id=".$this->job_id;
		return self::find_by_sql( $sql );
	}
################################################################
	

#################deleteing jobs from cat job by job id (all jobs ) ###################
	public function delete_all_on_update(){
		global $database, $db;
		$sql = " DELETE ".self::$table_name;
		$sql .= " FROM ".self::$table_name;
		$sql .= " LEFT JOIN ".TBL_JOB." AS job ON job.id=".self::$table_name.".job_id ";
		$sql .= " WHERE job.id=".$this->job_id;
		
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

$jobcategory 	= new JobCategory();
?>