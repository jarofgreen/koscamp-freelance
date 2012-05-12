<?php
require_once( LIB_PATH.DS."class.database.php");

class EmailTemplate extends DatabaseObject{
	protected static $table_name = TBL_EMAIL_TEMPLATE;
	protected static $db_fields = array('id', 'template_name','template_key','from_email', 'from_name','email_subject','email_text');
	
	### list all fields
	public $id;
	public $template_name;
	public $template_key;
	public $from_email;
	public $from_name;
	public $email_subject;
	public $email_text;
	
	
	
	public $errors=array();
	
	public static function find_by_key( $key=null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE template_key= '".$db->escape_value($key)."' ";
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public function email_template_body( $employer, $employee ){
		global $job;
		global $invoice;
		$text = str_replace("#SiteName#", SITE_NAME, $this->email_text );
		
		if( sizeof($employer) > 0 ) {
			$text = str_replace("#FullName#", 	$employer->full_name(), $text );
			$text = str_replace("#FName#", 		$employer->fname, $text );
			$text = str_replace("#SName#", 		$employer->sname, $text );
			$text = str_replace("#Email#", 		$employer->email_address, $text );
			$text = str_replace("#UserId#", 	$employer->username, $text );
			$text = str_replace("#Link#", "http://".$_SERVER['HTTP_HOST']."/employer", $text);
		}
		
		if( sizeof($employee) > 0 ) {
			$text = str_replace("#FullName#", 	$employee->full_name(), $text );
			$text = str_replace("#FName#", 		$employee->fname, $text );
			$text = str_replace("#SName#", 		$employee->sname, $text );
			$text = str_replace("#Email#", 		$employee->email_address, $text );
			$text = str_replace("#UserId#", 	$employee->username, $text );
			//$text = str_replace("#UserEmail#", 	$employee->email_address, $text );
			$text = str_replace("#ApplicantName#", $employee->full_name(), $text );
		}
		
		$text = str_replace("#Domain#", $_SERVER['HTTP_HOST'], $text );
		$text = str_replace("#ContactUs#", ADMIN_EMAIL, $text );
		
		if($job){
			$text = str_replace("#JobDetails#", $job->job_details() , $text );
			$text = str_replace("#JobTitle#", $job->job_title , $text );
			$text = str_replace("#PostEmail#", $job->poster_email , $text );
		}
		
		if( $employer ) {
			if( $com = $employer->get_company_name ( $job->employer_id_fk ) ){
				$text = str_replace("#CompanyName#", $com->company_name , $text );
			}
		}
		
		$text = str_replace("#Link#", "http://".$_SERVER['HTTP_HOST'], $text);
		
		if( $invoice ){
			$text = str_replace("#InvoiceId#", $invoice->id , $text );
			$text = str_replace("#Qty#", $invoice->posts_quantity , $text );
			$text = str_replace("#Amount#", $invoice->amount , $text );
			//$text = str_replace("#PayMethod#", $packageinvoice->payment_method , $text );
		}
		return $text;
	}

	
############################# Saving and Updating ##########################	
	public function save() {
		if( empty($this->template_name) ){
			$this->errors[]="please enater email template name";
		}
		if( empty($this->template_key) ){
			$this->errors[]="Please enter email template key";
		}
		if( empty($this->from_email) ){
			$this->errors[]="Please enter from email address";
		}
		if( empty($this->from_name) ){
			$this->errors[]="Please enter from name";
		}
		if( empty($this->email_subject) ){
			$this->errors[]="Please enter subject ";
		}
		if( empty($this->email_text) ){
			$this->errors[]="Please enter body of email";
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

$email_template 	= new EmailTemplate();
?>