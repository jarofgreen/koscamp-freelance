<?php
require_once( LIB_PATH.DS."class.database.php");

class CVSetting extends DatabaseObject{
	protected static $table_name = TBL_CV;
	protected static $db_fields = array('id', 'fk_employee_id', 'cv_title','cv_description','cv_file_name','cv_file_type','cv_file_exe','cv_file_size','cv_file_path','original_name','cv_status','default_cv','year_experience','highest_education','salary_range','availability','start_date','positions','recent_job_title','recent_employer','recent_industry_work','recent_career_level','look_job_title','look_job_title2','look_job_type','look_job_status','city','county', 'state_province','country','are_you_auth','willing_to_relocate','willing_to_travel','additional_notes','no_views','created_at','modified_at');
	
	public $id;
	public $fk_employee_id;
	public $cv_title;
	public $cv_description;
	public $cv_file_name;
	public $cv_file_type;
	public $cv_file_exe;
	public $cv_file_size;
	public $cv_file_path;
	public $original_name;
	public $cv_status;
	public $default_cv;
	//yourself
	public $year_experience;
	public $highest_education;
	public $salary_range;
	public $availability;
	public $start_date;
	public $positions;
	//privaus
	public $recent_job_title;
	public $recent_employer;
	public $recent_industry_work;
	public $recent_career_level;
	//next
	public $look_job_title;
	public $look_job_title2;
	public $look_job_type;
	public $look_job_status;
	//loc
	public $city;
	public $county;
	public $state_province;
	public $country;
	public $are_you_auth;
	public $willing_to_relocate;
	public $willing_to_travel;
	//others
	public $additional_notes;
	public $no_views;
	public $created_at;
	public $modified_at;

	public $errors=array();
	public $look_industries;
	private $temp_path;
	private $filename;
	private $type;
	private $size;
	private $ext="";
 	protected $upload_dir = SITE_ROOT;
	
	private $upload_errors = array(
		UPLOAD_ERR_OK 			=> "No errors.",
		UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
		UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
		UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
		UPLOAD_ERR_NO_FILE		=> "No file has been selected.",
		UPLOAD_ERR_NO_TMP_DIR 	=> "No temporary directory.",
		UPLOAD_ERR_CANT_WRITE 	=> "Can't write to disk.",
		UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
	);

	function __construct(){
		$this->delete_older_already_view_cv();
		$this->delete_inactive_cv();
	}
	
	
	/** if user does not exist then delete all the cv or documents */
	private function delete_inactive_cv(){
		global $database, $db;
		$sql = " SELECT * FROM ".self::$table_name;
		$sql .= " WHERE fk_employee_id NOT IN ( SELECT id FROM ".TBL_EMPLOYEE." )";
		$result = $database->query($sql);
		$rows = $db->db_result_to_object($result);
		if ( $db->num_rows($result) > 0 ){
			foreach( $rows as $row ):
				unset($sql);
				$target_path = $row->cv_file_path . DS . $row->cv_file_name;
				if (unlink($target_path) ){
					$sql=" DELETE FROM ".self::$table_name ." WHERE id=".$row->id;
					$database->query($sql);
				}
			endforeach;
			return true;
		} else {
			return false;
		}
	}
	
	public static function find_by_user_and_id( $id=0, $employer_id=0 ){
		global $database, $db;
		$sql="SELECT * FROM ".self::$table_name;
		$sql.=" WHERE id=".(int)$id ;
		$sql.=" AND fk_employee_id=".(int)$employer_id;
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public static function download_by_employee( $id=0, $employer_id=0 ){
		global $database, $db;
		$sql="SELECT * FROM ".self::$table_name;
		$sql.=" WHERE id=".(int)$id ;
		$sql.=" AND fk_employee_id=".$employer_id;
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public static function download_by_employer( $id, $employee_id ){
		global $database, $db;
		$sql="SELECT * FROM ".self::$table_name;
		$sql.=" WHERE id=".(int)$id ;
		$sql.=" AND cv_status='Public' ";
		$sql.=" AND fk_employee_id=".$employee_id;
		$sql .= " LIMIT 1";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public function cv_review_by_employee(){
		global $database, $db;
		$sql=" SELECT * FROM ".self::$table_name;
		$sql.=" WHERE fk_employee_id=".(int)$this->fk_employee_id ." AND id=".$this->id;
		//echo $sql;
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public function cv_review_by_employer(){
		global $database, $db;
		$sql=" SELECT * FROM ".self::$table_name;
		$sql.=" WHERE cv_status='Public' AND id=".$this->id;
		$sql.=" AND fk_employee_id=".$this->fk_employee_id;
		//echo $sql;
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	
	public function update_no_views(){
		global $database, $db;
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET no_views = no_views + 1 WHERE id=".$this->id;
		$database->query($sql);
	   	return ($database->affected_rows() == 1) ? true : false;
	}

	
	public function copy_cv( $employee_id=0, $id=0 ){
		global $database, $db;
		
		$sql = "SELECT * FROM ". self::$table_name;
		$sql .= " WHERE fk_employee_id =".(int)$employee_id." AND id=".$id;
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}

	public function select_cv(){
		global $database, $db;
		$sql=" SELECT * FROM ".self::$table_name;
		$sql.=" WHERE fk_employee_id=".(int)$this->fk_employee_id." AND id=".$this->id;
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public function make_defult(){
		global $database, $db;
		$sql="UPDATE ".self::$table_name;
		$sql.=" SET  default_cv='N' ";
		$sql.=" WHERE fk_employee_id='".$this->fk_employee_id."' ";
		$database->query($sql);
		unset($sql);
		$sql="UPDATE ".self::$table_name;
		$sql.=" SET  default_cv='Y' ";
		$sql.=" WHERE fk_employee_id='".$this->fk_employee_id."' AND id=".$this->id;
		
		$database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	
	private function make_cv_private(){
		global $database, $db;
		$sql="UPDATE ".self::$table_name;
		$sql.=" SET  cv_status='private' ";
		$sql.=" WHERE fk_employee_id='".$this->fk_employee_id."' ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}

###################### account all #########################
	public static function count_all_by_employee( $id ) {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql.=" WHERE fk_employee_id=".$id;
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}

################################
	public static function employee_find_all( $username=null ){
		global $database, $db;
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" WHERE fk_employee_id=".$db->escape_value($username);
		return self::find_by_sql( $sql );
	}

	public static function employee_find_public_cv( $user_id=null){
		global $database, $db;
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" WHERE fk_employee_id=".$db->escape_value($user_id);
		$sql.=" AND  cv_status='public' ";
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}


	public function destroy() {
		// First remove the database entry
		if($this->delete_emp()) {
			// then remove the file
		  // Note that even though the database entry is gone, this object 
			// is still around (which lets us use $this->image_path()).
			//$target_path = SITE_ROOT.DS.'public'.DS.$this->image_path();
			$target_path=$this->upload_dir . DS . FILE_UPLOAD_DIR . DS . $this->cv_file_name;
			return unlink($target_path) ? true : false;
		} else {
			// database delete failed
			return false;
		}
	}
	
	public function delete_emp() {
		global $database, $db;
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " AND fk_employee_id='".$this->fk_employee_id."' ";
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

########################### SAVEING CV #####################################	
	
	// Pass in $_FILE(['uploaded_file']) as an argument
	public function attach_file( $file) {
		$allowed_files = split(",", ALLOWED_FILETYPES_DOC);
		//$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); 
		// Get the extension from the filename.
	
		//echo $check_files;
		//print_r($file);
		// Perform error checking on the form parameters
		if(!$file || empty($file) || !is_array($file)) {
		  // error: nothing uploaded or wrong argument usage
		  $this->errors[] = get_lang('errormsg', 05);
		  //return false;
		} elseif($file['error'] != 0) {
		  // error: report what PHP says went wrong
		  $this->errors[] = $this->upload_errors[$file['error']];
		  //return false;
		} else {
					$this->ext = end(explode(".", basename($file['name']) ));
					$this->ext = strtolower($this->ext);
	
				if( !in_array($this->ext, $allowed_files) )
				{
					$this->errors[] = " File ".basename($file['name'])." is not allowed";
				}
			// Set object attributes to the form parameters.
			$this->temp_path 		= $file['tmp_name'];
			$this->cv_file_name   	= $this->fk_employee_id."_".time().".".$this->ext;
			$this->original_name	= basename($file['name']);
			$this->cv_file_exe  	= $this->ext;
			$this->cv_file_type 	= $file['type'];
			$this->cv_file_size 	= $file['size'];
			// Don't worry about saving anything to the database yet.
			return true;
	
		}
	}
	
	public function save() {
		
		// A new record won't have an id yet.
		if( isset($this->id) ){
			
			if( !is_numeric($this->id) ){
				$this->errors[] = get_lang('errormsg', 21);
				//return false;
			}
			
			if( empty($this->recent_job_title) ){
				$this->errors[] = get_lang('errormsg', 22);
			}
			
			if( empty($this->recent_employer) ){
				$this->errors[] = get_lang('errormsg', 23);
			}
			
			if( empty($this->recent_industry_work) ){
				$this->errors[] = get_lang('errormsg', 24);
			}
			
			if( empty($this->recent_career_level) ){
				$this->errors[] = get_lang('errormsg', 25);
			}
			
			if( empty($this->look_job_title) && empty($this->look_job_title) ){
				$this->errors[] = get_lang('errormsg', 26);
			}
			
			if( empty($this->look_industries) ){
				//$this->errors[] = get_lang('errormsg', 27);
			}
			
			if( empty($this->look_job_status) ){
				$this->errors[] = get_lang('errormsg', 28);
			}
			
			if( empty($this->city) ){
				$this->errors[] = get_lang('errormsg', 29);
			}
			
			if( empty($this->are_you_auth) ){
				$this->errors[] = get_lang('errormsg', 30);
			}
			
			if( empty($this->willing_to_relocate) ){
				$this->errors[] = get_lang('errormsg', 31);
			}
			
			if( empty($this->willing_to_travel) ){
				$this->errors[] = get_lang('errormsg', 32);
			}
			
			if( empty($this->fk_employee_id) ){
				$this->errors[] = get_lang('errormsg', 33);
			}
			
			if( empty($this->cv_status) ){
				$this->cv_status 	= "private";
			}
			
			if( sizeof($this->errors) == 0 ) {
				$this->modified_at 	= date("Y-m-d H:i:s",time() );
				//$this->cv_status 	= "public";
				if( $this->cv_status == "public" ){
					$this->make_cv_private();
				}
				return $this->update();
			}
		}else{
			
			//if( $this->count_all_by_employer() <= MAX_CV ){
				if( empty($this->cv_title) ){
					$this->errors[] = get_lang('errormsg', 34);
				}
				
				if( $this->cv_file_size > MAX_CV_SIZE ) {
					$this->errors[] = get_lang('errormsg', 35);
				}
				
				if( empty($this->cv_description) ){
				//	$this->errors[] = get_lang('errormsg', 36);
				}
				
				
				if( sizeof($this->errors) == 0 ) {
					if( !empty( $this->temp_path) && !empty($this->cv_file_name) ) {
						$target_path=$this->upload_dir . DS . FILE_UPLOAD_DIR .  $this->cv_file_name;
						// Attempt to move the file 
						if(!move_uploaded_file( $this->temp_path, $target_path)){
							$this->errors[] = get_lang('errormsg', 37);
							//$this->id = $db->insert_id();
							//$this->delete();
							return false;
						}
					}
					
					$this->created_at 	= date("Y-m-d H:i:s",time() );
					//$this->modified_at 	= date("Y-m-d H:i:s",time() );
					$this->cv_file_path	= $this->upload_dir . DS . FILE_UPLOAD_DIR;
					$this->cv_status 	= "private";
					return $this->create();
				}
		}
		return  false;
	}

#######################################################################################
############################### CLIENT EMPLOYER VIEW ##################################
#######################################################################################
	
	public function save_cv_view( $client_id, $num_view ){
		global $database, $db;
		$sql = sprintf("INSERT INTO ".TBL_CLINT_CVVIEW." (id, fk_cv_id, fk_employer_id, view_for, created_at)
						 VALUES (NULL , '%s', '%s', '%s', '%s');",
							$db->escape_value( $this->id ),
							$db->escape_value( $client_id ),
							$db->escape_value( $num_view ),
							date("Y-m-d H:i:s", time() )
					);
		if($database->query($sql)) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function list_client_cv_view( $client_id ){
		global $database, $db;
		$sql=" SELECT * FROM ".TBL_CLINT_CVVIEW." WHERE client_id ='".$client_id."' ";
		$result = $database->query($sql);
		$row = $db->db_result_to_object($result);
		if ( $db->num_rows($result) >0 ){
			return $row;
		} else {
			return false;
		}	
	}
	
	
	public function already_view_cv( $client_id, $cv_id ){
		global $database, $db;
		$sql=" SELECT * FROM ".TBL_CLINT_CVVIEW." WHERE fk_employer_id=".$client_id." AND fk_cv_id=".$cv_id;
		$result = $database->query($sql);
		$row = $db->db_result_to_object($result);
		if ( $db->num_rows($result) > 0 ){
			return true;
		} else {
			return false;
		}
	}
	
	private function delete_older_already_view_cv(){
		global $database, $db;
		$sql=" SELECT * FROM ".TBL_CLINT_CVVIEW." WHERE DATE_ADD( created_at, INTERVAL 8 DAY ) < NOW() ";
		$result = $database->query($sql);
		$rows = $db->db_result_to_object($result);
		if ( $db->num_rows($result) > 0 ){
			foreach( $rows as $row ):
				unset($sql);
				$sql=" DELETE FROM ".TBL_CLINT_CVVIEW." WHERE id=".$row->id;
				$database->query($sql);
			endforeach;
			return true;
		} else {
			return false;
		}
	}
	
/***********************************************************************/
########################################################################

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

$cv_setting 	= new CVSetting();

?>