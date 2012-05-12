<?php
require_once( LIB_PATH.DS."class.database.php");

class Employee extends DatabaseObject{
	protected static $table_name = TBL_EMPLOYEE;
	protected static $db_fields 	= array( 'id', 'extra_id','email_address', 'username', 'passwd',
										 	 'title', 'fname', 'sname', 'address', 'address2', 
										 	 'city', 'county', 'state_province', 'country', 
											 'post_code', 'phone_number', 'fk_career_degree_id', 
											 'date_register', 'last_login', 'actkey' , 'admin_comments', 
											 'employee_status', 'is_active'
											);	
	
	/** why not save because of id */
	public $id;
	public $extra_id;
	public $email_address;
	public $username;
	public $passwd;
	public $title;
	public $fname;
	public $sname;
	public $address;
	public $address2;
	public $city;
	public $county;
	public $state_province;
	public $country;
	public $post_code;
	public $phone_number;
	public $fk_career_degree_id;
	public $date_register='2009-10-21 00:00:00';
	public $last_login='0000-00-00 00:00:00';
	public $actkey;
	public $admin_comments;
	public $employee_status;
	public $is_active;
	
	public $errors=array();
	public $confirm_passwd;
	public $terms=2;
	public $CAPTCHA=true;
	
	public function address(){
		$address="";
		if( isset($this->address) && !empty($this->address) ){
			$address .= $this->address.":";
		}
		if( isset($this->address2) && !empty($this->address2) ){
			$address .= $this->address2.":";
		}
		
		if( isset($this->city) && !empty($this->city) ){
			$city = City::find_by_code( $this->country, $this->state_province, $this->county, $this->city );
			$address .= $city->name.":";
		}
		
		//county
		if( isset($this->county) && !empty($this->county) ){
			$county = County::find_by_code( $this->country, $this->state_province, $this->county );
			$address .= $county->name.":";
		}
		
		//states
		if( isset($this->state_province) && !empty($this->state_province) ){
			$state_province = StateProvince::find_by_code( $this->country, $this->state_province );
			$address .= $state_province->name.":";
		}
		
		//post code		
		if( isset($this->post_code) && !empty($this->post_code) ){
			$address .= $this->post_code.":";
		}
		
		//country
		if( isset($this->country) && !empty($this->country) ){
			$country = Country::find_by_code( $this->country );
			$address .= $country->name.":";
		}

		else {
			return "";
		}
		
		return $address;
	}
	
	/**login */
	public static function authenticate($username="", $password="") {
		global $database, $db;
		$username = $database->escape_value($username);
		$password = $database->escape_value(md5($password));
	
		$sql  = "SELECT * FROM ".self::$table_name;
		$sql .= " WHERE username = '{$username}' ";
		$sql .= " AND passwd = '{$password}' ";
		$sql .= " LIMIT 1";
		$result_array = self::find_by_sql($sql);
		
		if( !empty($result_array) ){ self::login_update( $username ); }
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	//login with email address
	public static function authenticate_email($email="", $password="") {
		global $database, $db;
		$username = $database->escape_value($username);
		$password = $database->escape_value(md5($password));
	
		$sql  = "SELECT * FROM ".self::$table_name;
		$sql .= " WHERE email_address = '{$email}' ";
		if( !empty($password)){
			$sql .= " AND passwd = '{$password}' ";
		}		
		$sql .= " LIMIT 1";
		$result_array = self::find_by_sql($sql);
		
		//if( !empty($result_array) ){ self::login_update( $username ); }
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	/** change password **/
	public static function change_password( $username, $new_pass ){
		global $database, $db;
		$username = $database->escape_value( $username);
		$new_pass = $database->escape_value(md5($new_pass));
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET passwd = '".$new_pass."' 
				  WHERE username = '".$username."' ";
		$sql .= " LIMIT 1";
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
	}
	
	/** change email address */
	public static function change_email_address( $username, $email_address ){
		global $database, $db;
		$email_address = $database->escape_value( $email_address);
		$username = $database->escape_value( $username);
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET email_address = '".$email_address."'
				  WHERE username = '".$username."' ";
		$sql .= " LIMIT 1";
		
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
	}
		
	/** check to see if email not already exited in the database */
	public static function check_email( $email ){
		global $database, $db;
		if( !empty($email) ){
			$email = $database->escape_value($email);
			$sql = " SELECT email_address FROM ".self::$table_name ;
			$sql .= " WHERE email_address = '{$email}' LIMIT 1 ";			
			$result = $database->query( $sql );
			$row = $database->num_rows($result);
			if( $row == 1) {return true;}
		}
		return false;
	}
	
	/** check to see if username not already exited in the database */
	public static function check_username( $username ){
		global $database, $db;
		if( !empty($username) ) {
			$username = $database->escape_value($username);
			$sql = " SELECT username FROM ".self::$table_name ;
			$sql .= " WHERE username = '{$username}' LIMIT 1 ";
			$result = $database->query( $sql );
			$row = $database->num_rows($result);
			if( $row == 1) {return true;}
		}
		return false;
	}
	
	/** forgot password **/
	public static function forgot_password( $email, $new_pass){
		global $database, $db;
		$email = $database->escape_value( $email);
		$new_pass = $database->escape_value(md5($new_pass));
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET passwd = '".$new_pass."' 
				  WHERE email_address = '{$email}' ";
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
	}
	
	public static function get_username( $email ){
		global $database, $db;
		$email = $database->escape_value( $email);
		$sql = " SELECT username FROM ".self::$table_name;
		$sql .= " WHERE email_address = '{$email}' LIMIT 1 ";
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public static function login_update($username){
		global $database, $db;
		$sql = "UPDATE ".self::$table_name." SET last_login = NOW() ";
		$sql .= " WHERE username='". $database->escape_value($username)."' LIMIT 1 ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}

  public function active_user(){
	  global $database, $db;
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET is_active = 'Y' 
				  WHERE id=".$this->id." LIMIT 1 ";
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
  }
  
  public function deactive_user(){
	  global $database, $db;
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET is_active = 'N'  
				  WHERE id=".$this->id." LIMIT 1 ";
		//echo $sql;
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
  }
  
  public function delete_user(){
	  global $database, $db;
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET is_active = 'N',
				      employee_status = 'deleted'  
				  WHERE id=".$this->id." AND username='".$this->username."' LIMIT 1 ";
		//echo $sql;
		
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
  }
  
  public static function user_by_username( $username ){
	  global $database, $db;
		$sql = " SELECT * FROM ".self::$table_name;
		$sql .= " WHERE username='".$username."' LIMIT 1 ";
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
  }
  
  public static function find_by_username( $username=null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE username= '".$db->escape_value($username)."' ";
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
  }
  
  public static function find_by_email( $email=null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE email_address= '".$db->escape_value($email)."' ";
		$sql .= " LIMIT 1 ";
		//echo $sql;
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
  }
  
  public function full_name() {
    if(isset($this->fname) && isset($this->sname)) {
      return ucfirst($this->fname) . " " . ucfirst($this->sname);
    } else {
      return "";
    }
  }
  
  
  public static function complete_registration( $key ){
		global $database, $db;
		
		$sql = " SELECT * FROM ".self::$table_name." WHERE actkey = '$key' ";
		$result = self::find_by_sql( $sql );
		
		if( $result ) {
			$sql = " UPDATE ".self::$table_name." SET is_active ='Y' WHERE actkey = '$key' ";
			$database->query($sql);
			//return ($database->affected_rows() == 1) ? true : false;
		} else {
			return false;
		}
		return !empty($result) ? array_shift($result) : false;
  }
  
  public static function change_key( $username ){
	  global $database, $db;
	   $key = md5( session_id().time() );
	   $sql = " UPDATE ".self::$table_name." SET is_active ='N', actkey = '$key' ";
	   $sql .= " WHERE username='".$username."' LIMIT 1 ";
	   
	   $database->query($sql);
	   return ($database->affected_rows() == 1) ? true : false;
  }
  

/************************* ADMIN **************/
 public function approved_account(){
	  global $database, $db;
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET employee_status = 'active', is_active = 'Y' 
				  WHERE id=".$this->id." LIMIT 1 ";
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
 }
 
 /**************************************/
 
 	public static function count_all_active() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active ='Y' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
 
  	public static function count_all_deactive() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active ='N' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
  
   	public static function count_all_pending() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE employee_status ='pending' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
  ##########################################################
  
	public function save() {
				
		if( empty($this->fname) )
		{
			$this->errors[]=get_lang('error','fname');
		}
		
		if( empty($this->sname) )
		{
			$this->errors[]=get_lang('error','sname');
		}
		
		if( empty($this->country) || $this->country == "AA"){
			$this->errors[]=get_lang('error','country');
		}
		
		// A new record won't have an id yet.
		if ( isset($this->id) ){
			
			if( empty($this->title) )
			{
				$this->errors[]=get_lang('error', 'title');
			}
			
			if( empty($this->phone_number) )
			{
				$this->errors[]=get_lang('error', 'phone_number');
			}

			if( sizeof($this->errors) == 0 )
			{
				if( $this->update() ){
					return true;
				}else{
					$this->errors[]=get_lang('error', 'reg_no_changes' );
				}
			}
		}
		// add new records
		else{
			if( empty($this->email_address) ){
				$this->errors[]=get_lang('error','email');
			}
			
			if ( !empty($this->email_address) )
			{
				$username_found = self::check_email( $this->email_address );
				if( $username_found ){
					$this->errors[] =get_lang('error','email_already_existed');
				}
				$email = check_email( $this->email_address );
				if ($email == ""){
					$this->errors[]=get_lang('error','incorrect_format_email');
				}
			}

			if( empty($this->username) ){
				$this->errors[]=get_lang('error','username');
			}
			if( !empty($this->username) ){
				$username_found = self::check_username( $this->username );
				if( $username_found ){
					$this->errors[] =get_lang('error','user_already_existed');
				}
				if (!check_username( $this->username ) ){
					$this->errors[]=get_lang('error','format_username');
				}
				if( strlen($this->username) < 4 || strlen($this->username) > 30 ){
					$this->errors[]=get_lang('error','username_length');
				}
			}
			
			if( empty($this->passwd)  )
			{
				$this->errors[]=get_lang('error','password');
			}
			
			if( strlen($this->passwd) < 6 ||  strlen($this->passwd) > 20 )
			{
				 $this->errors[]=get_lang('error','format_password');
			}
			
			if( $this->confirm_passwd != $this->passwd  )
			{
				$this->errors[]=get_lang('error','password_not_match');
			}
			
			if( !$this->CAPTCHA )
			{
				$this->errors[] = get_lang('error','spam_wrong_word');
				//$this->errors[] = "The reCAPTCHA wasn't entered correctly.";
			}
			
			if( $this->terms == 1 )
			{
				$this->errors[] =get_lang('error','terms_of_use');
			}
			
			if( sizeof($this->errors) == 0 ){
				$this->passwd = md5($this->passwd);
				$this->date_register = date("Y-m-d H:i:s", time());
				//does user need to confirm they account by clicking
				// on link in they email.
				if( REG_CONFIRMATION && (REG_CONFIRMATION == "Y" || REG_CONFIRMATION == 1)  ){
					$this->is_active = "Y";
				}else{
					$this->is_active = "N";
				}
				
				//does admin need to confirm they reg account
				if ( ACTIVE_EMPLOYEE_AUTO && ACTIVE_EMPLOYEE_AUTO == "Y"){
					$this->employee_status = "active";
				}else{
					$this->employee_status = "pending";
				}
								
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
	  //echo $sql;
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

$employee 	= new Employee();
$job_seeker = &$employee;
?>