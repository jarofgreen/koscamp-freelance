<?php
require_once( LIB_PATH.DS."class.database.php");

class Employer extends DatabaseObject{
	protected static $table_name = TBL_EMPLOYER;
	protected static $db_fields = array('id', 'extra_id','company_name',  'var_name', 'contact_name', 'site_link', 'company_logo', 
										'company_desc','email_address', 'username', 'passwd', 'title', 'fname', 'sname', 
										'address', 'address2', 
										'city', 'county', 'state_province', 'country', 
										'post_code', 'phone_number', 'job_qty','cv_qty','spotlight_qty',
										'date_register', 'last_login', 'actkey' , 'admin_comments', 'employer_status', 'is_active');
	
	public $id;
	public $extra_id;
	public $company_name;
	public $var_name;
	public $contact_name;
	public $site_link;
	public $company_logo;
	public $company_desc;
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
	public $job_qty;
	public $cv_qty;
	public $spotlight_qty;
	public $date_register;
	public $last_login;
	public $actkey;
	public $admin_comments;
	public $employer_status;
	public $is_active;
	
	/** file upload settings */
	public $confirm_password=false;
	private $temp_path;
	private $filename;
	private $type;
	private $size;
	private $exe="";
 	protected $upload_dir="images/company_logo";
 	public $errors=array();
	public $CAPTCHA=true;
	public $terms;
	protected $upload_errors = array(
		// http://www.php.net/manual/en/features.file-upload.errors.php
		UPLOAD_ERR_OK 			=> "No errors.",
		UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
		UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
		UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
		UPLOAD_ERR_NO_FILE 		=> "No file was uploaded.",
		UPLOAD_ERR_NO_TMP_DIR 	=> "No temporary directory.",
		UPLOAD_ERR_CANT_WRITE 	=> "Can't write to disk.",
		UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
	);
	
	function __construct(){
		
		$this->spotlight_qty_less_then_zero();
		$this->standard_job_less_then_zero();
		$this->cv_less_then_zero();
		/**
		if ( !is_dir(COM_IMAGES_PATH .DS. $this->upload_dir) ) {
			mkdir( COM_IMAGES_PATH .DS. $this->upload_dir ,0777);	
		}
		**/
		if ( !is_dir(COM_IMAGES_PATH ) ) {
			mkdir( COM_IMAGES_PATH  ,0777);	
		}
	}
	

	public static function find_by_var_name( $var_name=null, $current_url=null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE var_name= '".$db->escape_value($var_name)."'";
		if($current_url && !empty($current_url) && $current_url != '' && $current_url != null){
			$sql .= " AND var_name <> '".$db->escape_value($current_url)."'";
		}
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public function mod_write_check( $url=null, $current_url=null ){
		$mod_name = mod_url_rewriter($url);
		$does_not_existed = false;
		$i=1;
		if( self::find_by_var_name( $mod_name, $current_url ) ){
				while( !$does_not_existed )
				{ 
					if( !self::find_by_var_name( $mod_name.$i, $current_url ) )
					{
						$does_not_existed = true;
						$mod_name = $mod_name.$i;
					}else{
						$i++;
					}
			   }
		}
		
		return $mod_name;
	}


//get full name
	public function full_name() {
		if(isset($this->company_name) ){
			return ucfirst($this->company_name);
		}else if(isset($this->fname) && isset($this->sname)) {
			return ucfirst($this->fname) . " " . ucfirst($this->sname);
		} else {
			return "";
		}
	}	

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
	
 // Pass in $_FILE(['uploaded_file']) as an argument
  public function attach_file( $file) {
	  	$allowed_files = split(",", ALLOWED_FILE_TYPES_IMG);
		// Perform error checking on the form parameters
		if(!$file || empty($file) || !is_array($file)) {
		  // error: nothing uploaded or wrong argument usage
		  $this->errors[] = "No file was uploaded.";
		  //return false;
		} elseif($file['error'] != 0) {
		  // error: report what PHP says went wrong
		  $this->errors[] = $this->upload_errors[$file['error']];
		  //return false;
		} else {
					$ext = end(explode(".", basename($file['name']) ));
					$ext = strtolower($ext);

				if( !in_array($ext, $allowed_files) )
      			{
					$this->errors[] = " File ".basename($file['name'])." is not allowed";
				}
			// Set object attributes to the form parameters.
		  	$this->temp_path  = $file['tmp_name'];
		  	$this->filename   = basename($file['name']);
		 	//$this->company_logo= basename($file['name']);
			$this->exe 		  = $ext;
		  	$this->type       = $file['type'];
		 	$this->size       = $file['size'];
			if($file['size'] > MAX_CV_SIZE ) {
				$this->errors[] = "File size must not be bigger than ".size_as_text( MAX_CV_SIZE );
			}
			return true;
		}
	}

	public static function authenticate($username="", $password="") {
		global $database, $db;
		$username = $database->escape_value($username);
		$password = $database->escape_value(md5($password));
		
		$sql  = "SELECT * FROM ".self::$table_name;
		$sql .= " WHERE username = '{$username}' ";
		$sql .= " AND passwd = '{$password}' ";
		$sql .= " LIMIT 1";
		$result_array = self::find_by_sql($sql);
		
		if( !empty($result_array) ){ self::setLoginUpdate( $username ); }
		
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function setLoginUpdate($username){
		global $database, $db;
		$sql = "UPDATE ".self::$table_name." SET last_login = NOW() ";
		$sql .= " WHERE username='". $database->escape_value($username)."' LIMIT 1 ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	/** change password **/
	public static function change_password( $username, $new_pass ){
		global $database, $db;
		$username = $database->escape_value( $username);
		$new_pass = $database->escape_value(md5($new_pass));
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET passwd = '".$new_pass."' 
				  WHERE username = '{$username}' ";
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

  public static function complete_registration( $key ){
		global $database, $db;
		
		$sql = " SELECT * FROM ".self::$table_name." WHERE actkey = '$key' ";
		$result = self::find_by_sql( $sql );
		
		if( $result ) {
			$sql = " UPDATE ".self::$table_name." SET is_active ='Y' WHERE actkey = '$key' ";
			$database->query($sql);
		} else {
			return false;
		}
		return !empty($result) ? array_shift($result) : false;
  }
  
  public static function change_key( $username ){
	  global $database, $db;
	   $key = md5( session_id() );
	   $sql = " UPDATE ".self::$table_name." SET is_active ='N', actkey = '$key' ";
	   $sql .= " WHERE username='".$username."' LIMIT 1 ";
	   
	   $database->query($sql);
	   return ($database->affected_rows() == 1) ? true : false;
  }
  
	public static function getUsername( $email ){
		global $database, $db;
		$email = $database->escape_value( $email);
		$sql = " SELECT username FROM ".self::$table_name;
		$sql .= " WHERE email_address = '{$email}' LIMIT 1 ";
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
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
	
	public function save() {
			
		   	/** company_name **/
			if( empty($this->company_name) ){
				$this->errors[] =  "Please enter company name";
			}
							
			if( !empty( $this->temp_path) && !empty($this->filename) ) {
				 $this->company_logo = $this->username.".".$this->exe; 
				// Determine the target_path
				$target_path = COM_IMAGES_PATH .DS. $this->company_logo;
				$size = getimagesize( $this->temp_path );
				
				$width = $size[0];
				$height = $size[1];
				
				if( $width > PIC_WIDTH || $height > PIC_HEIGHT ){
					$this->errors[] = "File size needs to be smaller then ".PIC_WIDTH."x".PIC_HEIGHT;
				}
				
				// Make sure a file doesn't already exist in the target location
				if(file_exists($target_path)) {
					$this->errors[] = "The file {$this->filename} already exists.";
					//return false;
				}
			}
			
			if( !empty($this->site_link) ){
				if( validateURL( $this->site_link ) ){
					$this->site_link = check_http( $this->site_link );
				}else{
					$this->errors[] = "Please enter valid URL e.g. http://wwww.domain.com/uk/org";
				}
			}
			
			if( empty($this->country) || $this->country == 'AA' ){
				$this->errors[] =  "Please select country from list";
			}
			
			if( !empty($this->phone_number) ){
				$this->phone_number = phone_number( $this->phone_number );
				if( !$this->phone_number ){
					$this->errors[] =  "Please enter vaild phone number";
				}
			}
			
	  // A new record won't have an id yet.
	   if( isset($this->id) ) {
		   
		   if(empty($this->contact_name) ){
			   $this->errors[] = "Please enter contact name";
		   }
		   
		   if( empty($this->address	) )
		   {
			   $this->errors[] = "Please enter first line of address";
		   }
		   
		   if( empty($this->state_province) ){
			   $this->errors[] = "Please select state from list";
		   }
		   
		   if( empty($this->county) ){
			   $this->errors[] = "Please select county from list";
		   }
		   
		   if( empty($this->city) ){
			   $this->errors[] = "Please select city from list";
		   }
		   
		   if( empty($this->phone_number) ){
		   		$this->errors[] = "Please enter contact telephone number";
		   }
		   
		   if( !empty($this->phone_number) ){
			   $this->phone_number = phone_number($this->phone_number);
				if( !$this->phone_number ){
					$this->errors[] =  "Please enter vaild phone number";
				}
		   }
		   		   
			if(sizeof($this->errors) == 0 ){ 
				
				if( !empty( $this->temp_path) && !empty($this->filename) ) {
					// Attempt to move the file 
					if(!move_uploaded_file( $this->temp_path, $target_path)){
						$this->errors[] = "Unable to save company logo";
						return false;
					}
				}
				// if no errors update 
					if( $this->update() ){
						// We are done with temp_path, the file isn't there anymore
						unset($this->temp_path);
						return true;
					}else{
						// File was not moved.
						$this->errors[] = "Problem try to update your details. Please make sure all fields have been complated";
						return false;
					}
			}
			
		//add new record
	   }else{
		   
		   if(empty($this->username)){
				$this->errors[] = "Please enter username";
		   }
			
			//if username enter check username 
			if(!empty($this->username)){
					$username_found = self::check_username( $this->username );
					if( $username_found && ($username_found->username != $_SESSION['uname'] ) ){
						$this->errors[] = "Username already existed";
					}
					if (!check_username( $this->username ) ){
						$this->errors[]="The username should contain only letters, numbers and underscores";
					}
					if( strlen($this->username) < 4 || strlen($this->username) > 30 ){
						$this->errors[]="The username must be between 4 - 30 characters";
					}
			}
			
			/*** Email validation */
			if(empty($this->email_address)){
				$this->errors[] =  "Please enter email address";
			}			
			
			/* email**/
			if(!empty($this->email_address)){
				if( !check_email($this->email_address) ){
					$this->errors[] =  "Invalid Email address e.g user@domain.com/co.uk/net";
				}else{
					$email_found 	= self::check_email( $this->email_address );
					if( $email_found && ( $email_found->email_address != $_SESSION['email'] ) ){
						$this->errors[] =  "Email address already existed";
					}
				}
			}
			
			/** check password and conform password **/
			if( $this->passwd !=  $this->confirm_password || empty($this->passwd) ){
				$this->errors[] =  "Password and Confirm Password does not match";
			}
				if( strlen($this->passwd) < 6 ||  strlen($this->passwd) > 20 ){
					$this->errors[] =  "Password must be between 6 - 20 characters ";
				}

			/*** check code */
			if( !$this->CAPTCHA ){
				$this->errors[] = "The security code you entered does not match the image.";
			}
		
		   if( $this->terms == "" || empty($this->terms) ){
			   $this->errors[] = "Please accept <a href='".BASE_URL."employer/page/terms/'>Terms of Use</a>";
		   }
		   
		   
			if(sizeof($this->errors) == 0 ){ 
				
				if( !empty( $this->temp_path) && !empty($this->filename) ) {
					// Attempt to move the file 
					if(!move_uploaded_file( $this->temp_path, $target_path)){
						$this->errors[] = "Unable to save company logo";
						return false;
					}
				}
				
				/** add credits to user account */
				$this->job_qty 			= START_CREDIT_POST;
				$this->cv_qty 			= START_CREDIT_CV_SEARCH;
				$this->spotlight_qty 	= START_CREDIT_SPOTLIGHT;
				$this->is_active 		= ACTIVE_EMPLOYER_AUTO;
				
				$this->passwd 			= md5($this->passwd);
				$this->date_register	= strftime(" %Y-%m-%d %H:%M:%S ", time() );
				$this->actkey			= md5(session_id());
				
					if( $this->create() ){
						// We are done with temp_path, the file isn't there anymore
						unset($this->temp_path);
						return true;
					}else{
						// File was not moved.
						$this->errors[] = "Problem try to register your details. 
										Please make sure all fields have been complated";
						return false;
					}
  			}
	   }
	}
	
	/** check to see if email not already exited in the database */
	public static function check_email( $email ){
		global $database, $db;
		if( !empty($email) ){
			$email = $database->escape_value($email);
			$sql = " SELECT email_address FROM ".self::$table_name ;
			$sql .= " WHERE email_address = '{$email}' LIMIT 1 ";			
			$result = self::find_by_sql( $sql );
			return !empty($result) ? array_shift($result) : false;
			/*$result = $database->query( $sql );
			$row = $database->num_rows($result);
			if( $row == 1) {return true;}
			*/
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
			$result = self::find_by_sql( $sql );
			return !empty($result) ? array_shift($result) : false;
			
			//$result = $database->query( $sql );
			//$row = $database->num_rows($result);
			//if( $row == 1) {return true;}
		}
		return false;
	}
	
	public static function getCompanyName ( $username ){
		global $database, $db;
		if ( !empty($username) ){
			$username = $database->escape_value($username);
			$sql = " SELECT * FROM ".self::$table_name ;
			$sql .= " WHERE username = '{$username}' LIMIT 1 ";
			$result = self::find_by_sql( $sql );
			return !empty($result) ? array_shift($result) : false;
		}
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
	

########################### delete logo ####################################
	public function destroy_logo() {
		// First remove the database entry
		global $database, $db;
		
		$sql=" UPDATE ".self::$table_name." SET company_logo='' 
				WHERE username = '".$this->username."' LIMIT 1 ";
		
		$database->query($sql);
		if ($database->affected_rows() == 1) {
			$target_path = COM_IMAGES_PATH.DS.$this->company_logo;
			return unlink($target_path) ? true : false;
		}else{
			return false;
		}
		/*
		if($this->delete()) {
			$target_path = CLINT_DIR.DS.'images'.DS."company_logo".DS.$this->company_logo;
			return unlink($target_path) ? true : false;
		} else {
			// database delete failed
			return false;
		}
		*/
	}

/************************* ADMIN **************/
 public function approved_account(){
	  global $database, $db;
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET employer_status = 'Active', is_active = 'Y' 
				  WHERE id=".$this->id." LIMIT 1 ";
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
 }

	/********************** EMPLOYER BUY JOB CREDITS ************************/
	
	public function job_posting(){
		global $database, $db;
		
		
	}
	
	public static function find_by_username( $username=null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE username= '".$db->escape_value($username)."' ";
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}

	public static function find_by_user_id( $user_id=0 ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE id=".$db->escape_value($user_id);
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


##################### Total Job #####################################

	public function total_job_post(){
		global $database, $db;
		$sql= " SELECT job_qty FROM ".self::$table_name ;
		$sql.= " WHERE username = '".$this->username."' ";
		$result = $database->query( $sql );
		$row = $database->num_rows($result);
		$record = $database->fetch_array($result);
		if( $row == 1) {return $record['job_qty'];}
		return false;
	}
	
	public function total_spotlight_job_post(){
		global $database, $db;
		$sql= " SELECT spotlight_qty FROM ".self::$table_name ;
		$sql.= " WHERE username = '".$this->username."' ";
		$result = $database->query( $sql );
		$row = $database->num_rows($result);
		$record = $database->fetch_array($result);
		if( $row == 1) {return $record['spotlight_qty'];}
		return false;
	}

	public function total_cv(){
		global $database, $db;
		$sql= " SELECT cv_qty FROM ".self::$table_name ;
		$sql.= " WHERE username = '".$this->username."' ";
		$result = $database->query( $sql );
		$row = $database->num_rows($result);
		$record = $database->fetch_array($result);
		if( $row == 1) {return $record['cv_qty'];}
		return false;
	}
	
############### STANDARD JOB OIST #########################
	public function add_more_job_post(){
		global $database, $db;
		$sql = "update ".self::$table_name;
		$sql .= " set job_qty = job_qty + ".$this->job_qty." 
				WHERE username='".$this->username."' LIMIT 1 ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	public function update_job_post(){
		global $database, $db;
		$sql = "update ".self::$table_name;
		$sql .= " set job_qty = job_qty -1 WHERE username='".$this->username."' LIMIT 1 ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
#################### spotlight #################################
	public function add_more_spotlight_job_post(){
		global $database, $db;
		$sql = "update ".self::$table_name;
		$sql .= " set spotlight_qty = spotlight_qty + ".$this->spotlight_qty." 
				  WHERE username='".$this->username."' LIMIT 1 ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	public function update_spotlight_job_post(){
		global $database, $db;
		$sql = "update ".self::$table_name;
		$sql .= " set spotlight_qty = spotlight_qty -1 
				  WHERE username='".$this->username."' LIMIT 1 ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}

############### CV  #########################
	public function add_cvs(){
		global $database, $db;
		$sql = "update ".self::$table_name;
		$sql .= " set cv_qty = cv_qty + ".$this->cv_qty." 
				WHERE username='".$this->username."' LIMIT 1 ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	public function update_cvs(){
		global $database, $db;
		$sql = "update ".self::$table_name;
		$sql .= " set cv_qty = cv_qty -1 WHERE username='".$this->username."' LIMIT 1 ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}

######################### SET TO ZERO #############################
	private function spotlight_qty_less_then_zero(){
		global $database, $db;
		$sql = "update ".self::$table_name;
		$sql .= " set spotlight_qty=0 
				  WHERE spotlight_qty < 0 OR spotlight_qty IS NULL ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	private function standard_job_less_then_zero(){
		global $database, $db;
		$sql = "update ".self::$table_name;
		$sql .= " set job_qty =0 
				  WHERE job_qty  < 0 OR job_qty IS NULL ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}

	private function cv_less_then_zero(){
		global $database, $db;
		$sql = "update ".self::$table_name;
		$sql .= " set cv_qty =0 
				  WHERE cv_qty  < 0 OR cv_qty IS NULL ";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
/*
	public static function member_join_today(){
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE DATE_ADD( date_register, INTERVAL 1 DAY ) < NOW()";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}

	public static function member_join_week(){
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE DATE_ADD( date_register, INTERVAL 7 DAY ) < NOW()";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}

	public static  function member_join_today(){
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE DATE_ADD( date_register, INTERVAL 30 DAY ) < NOW()";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
*/


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

$employer 	= new Employer();
$clint 	= &$employer;
$recruiter = &$employer;
?>