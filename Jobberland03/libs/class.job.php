<?php
require_once( LIB_PATH.DS."class.database.php");

class Job extends DatabaseObject{
	
	protected static $table_name = TBL_JOB;
	protected static $db_fields = array('id', 'fk_employer_id', 'job_ref', 'var_name','job_title', 'job_description','job_postion', 
		'city', 'county', 'state_province', 'country',   
		'fk_education_id', 'fk_career_id', 'fk_experience_id', 'spotlight', 
		'job_salary','salaryfreq', 'company_name','company_logo', 'contact_name','contact_telephone','site_link','poster_email',
		'views_count', 'apply_count','start_date','created_at', 'job_startdate', 'job_enddate', 'modified', 'is_active', 'job_status', 'has_been_active', 'admin_first_view', 'admin_status_date', 'admin_comments');
	
	public $id;
	public $fk_employer_id=0;
	public $job_ref;
	public $var_name;
	public $job_title;
	public $job_description;
	public $job_postion;
	public $city;
	public $county;
	public $state_province;
	public $country;  
	public $fk_education_id=0;
	public $fk_career_id=0;
	public $fk_experience_id=0;
	public $spotlight;
	public $job_salary;
	public $salaryfreq;
	public $company_name;
	public $company_logo;
	public $contact_name;
	public $contact_telephone;
	public $site_link;
	public $poster_email;
	public $views_count=0;
	public $apply_count=0;
	public $start_date;
	
	public $created_at;
	public $job_startdate;
	public $job_enddate;
	public $modified;
	
	public $is_active;
	public $job_status ="pending"; ///expired, pending, rejected, approved
	public $has_been_active;
	
	public $admin_first_view;
	public $admin_status_date;
	public $admin_comments;
	
	public $errors=array();
	public $job_type=1;
	public $j_status=1;
	public $category=1;
	
	function __construct(){
		$this->expired_jobs();
	}

	//expired
	private function expired_jobs(){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;		
		$sql .= " WHERE has_been_active='Y' AND job_status ='approved' AND DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) < NOW() ";
		$results = $db->query( $sql );
		
		if( $results ){
			while( $row = $db->fetch_object($results) ){
				$sql = "UPDATE ".self::$table_name;
				$sql.=" SET job_status='expired'";
				$db->query($sql);
			}
		}
		return false;
	}

/////	
	public static function find_by_var_name( $var_name = null, $current_url=null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE var_name= '".$db->escape_value($var_name)."'";
		if($current_url && !empty($current_url) && $current_url != '' ){
			$sql .= " AND var_name <> '".$db->escape_value($current_url)."'";
		}
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public function mod_write_check( $url, $current_url ){
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

	
	public static function find_by_var_name_active( $name=null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE var_name= '".$db->escape_value($name)."' ";
		$sql .= " AND is_active='Y' AND job_status='approved' ";
		$sql .= " AND id > 0 ";
		$sql .= " AND  DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() ";
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
		
	public static function find_active_job_by_id( $id=null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE id=".$db->escape_value($id);
		$sql .= " AND is_active='Y' AND job_status='approved' ";
		$sql .= " AND id > 0 ";
		$sql .= " AND  DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() ";
		$sql .= " LIMIT 1 ";
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}

	public function job_details(){
		
		$output_message = "  <br /><b>Reference: </b>". safe_output( $this->job_ref  ? $this->job_ref  : SITE_NAME );
		//$output_message .= "<br /><b>Company: </b>".$company_name->company_name;
		$output_message .= "  <br /><b>Title: </b>".strip_html( $this->job_title ); 
		$output_message .= "  <br /><b>Description: </b>".strip_html($this->job_description);

		$state = StateProvince::find_by_code( $this->country, $this->state_province );
		$state_name = empty($state) ? $this->state_province : $state->name;
		
		$county = County::find_by_code( $this->country, $this->state_province, $this->county );
		$county_name = empty($county) ? $this->county : $county->name;
		
		$city = City::find_by_code( $this->country, $this->state_province, $this->county, $this->city );
		$city_name = empty($city) ? $this->city : $city->name;
		
		$location = $city_name. ", ". $county_name. ", ".$state_name;
		
		$output_message .= " <br /><b>Location: </b> ".safe_output( $location );
		//$output_message .= "<br /><b>Job Type: </b>".$type;
		$output_message .= "  <br /><b>Start Date: </b>".safe_output( strftime(DATE_FORMAT, strtotime($my_cv->created_at) ));
		//date("D d M Y", strtotime($this->created_at) ) );
		$output_message .= "  <br /><b>Contact: </b>".safe_output($this->contact_name);
		$output_message .= "  <br /><b>Telephone: </b>".safe_output($this->contact_telephone);
		$output_message .= "  <br /><b>Email: </b>".safe_output($this->poster_email);
		$output_message .= "  <br /><b>Rate: </b>".safe_output($this->job_salary)." per ".safe_output($this->salaryfreq);
		
		return $output_message;
	}
	
//recommendedJob
	public static function recommendedJob( $user_id=0, $cvjob_title=null, $cvjob_title2=null,
	$cvjob_city=null, $cvjob_county=null, $cvjob_state=null, $cvjob_country=null ){
		
		global $database, $db;
		$select = " SELECT job_title, city, county, state_province, country, fk_employer_id,var_name, created_at ";
		$select .= ", match( job.job_title, job.job_description ) against ('".$cvjob_title."' '+".$cvjob_title2."' IN BOOLEAN MODE) as relevance ";  
		$from   = " FROM ". self::$table_name." AS job ";
		$where  = " WHERE job.id NOT IN ( SELECT job_h.fk_job_id from ".TBL_HISTORY." as job_h WHERE job_h.fk_employee_id={$user_id}) ";
		$where .= " AND job.is_active='Y' AND job.job_status='approved' AND job.id > 0 ";
		//$where .= " AND var_name <> '".$old."' ";
		$where .= " AND match( job.job_title, job.job_description ) against ('".$cvjob_title."' '+".$cvjob_title2."' IN BOOLEAN MODE)";
		$where .= " AND  DATE_ADD( job.created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() ";
		//$where .= " AND city='{$cvjob_city}' "; 
		$where .= " AND county='{$cvjob_county}' ";
		$where .= " AND state_province='{$cvjob_state}'";
		$where .= " AND country='{$cvjob_country}'";
		
		$order = " ORDER BY relevance, created_at DESC ";
		$limit  = " LIMIT 10 ";
	
//SELECT job.job_title, job.city, job.county, job.state_province, job.country 
//FROM jobberland_job AS job 
//WHERE job.id NOT IN (SELECT job_h.fk_job_id from jobberland_job_history as job_h WHERE fk_employer_id = 1)

		
		$sql = $select . $from . $where . $order . $limit;
		//echo $sql;
		
		$result = $database->query($sql);
		$num_rows = $database->num_rows( $result );
		
		if( $num_rows > 0 ){
			$i=1;
			$temp=array();
			while ( $row = $database->fetch_object($result) ) {
				$temp[$i]['job_title'] = $row->job_title;
				$temp[$i]['var_name'] = $row->var_name;
				$temp[$i]['created_at'] = strftime(DATE_FORMAT, strtotime($row->created_at) );
	//country
	$country_arry = Country::find_by_code( $row->country );
	$country_name = $country_arry->name;
	//states
	$state = StateProvince::find_by_code( $row->country, $row->state_province );
	$state_name = empty($state) ? $row->state_province : $state->name; 
	//county
	$county = County::find_by_code( $row->country, $row->state_province, $row->county );
	$county_name = empty($county) ? $row->county : $county->name;
	//city
	$city = City::find_by_code( $row->country, $row->state_province, $row->county, $row->city );
	$city_name = empty($city) ? $row->city : $city->name;

				$temp[$i]['location'] = $city_name. ", ".$county_name.", ". $state_name. ", ".$country_name;

	$employer = Employer::find_by_id( $row->fk_employer_id );
	$company_name = $employer->company_name;

				$temp[$i]['company_name'] = $company_name;
				//$temp[$i]['job_title'] = $row->job_title;
				//$temp[$i]['job_title'] = $row->job_title;
			   $i++;
			 }
			 
			 return $temp;
		}
		
		return false;
	}
	
//apply suggestion
	public static function apply_suggestion( $job_title=null, $old=null ){
		global $database, $db;
		$sql = " SELECT *, match( job.job_title, job.job_description ) against ('{$job_title}' IN BOOLEAN MODE) as relevance 
				 FROM ". self::$table_name . " AS job ";
		$sql .= " WHERE is_active='Y' AND job_status='approved' AND id > 0 ";
		$sql .= " AND var_name <> '".$old."' ";
		$sql .= "AND match( job.job_title, job.job_description ) against ('{$job_title}' IN BOOLEAN MODE)";
		$sql .= " AND  DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() ";
		$sql .= " LIMIT 10 ";
				
		return self::find_by_sql( $sql );
	}

	public function list_job_by_location( $country=null, $states=null, $county=null, $city=null ){
		global $database, $db;	

		$sql = " SELECT * FROM ".self::$table_name;
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
					AND is_active = 'Y' 
					AND id > 0
					AND job_status = 'approved' ";
					
		if (!empty($country) ) 	$sql .= " AND country='".$country."' ";
		if (!empty($states) ) 	$sql .= " AND state_province='".$states."' ";
		if (!empty($county) ) 	$sql .= " AND county='".$county."' ";
		if (!empty($city) ) 	$sql .= " AND city='".$city."' ";

		$sql .= " GROUP BY city ";
		
		//echo $sql;
		
		return self::find_by_sql( $sql );
	}

	public function list_job_by_location_city( $country=null, $states=null, $county=null, $city=null ){
		global $database, $db;	

		$sql = " SELECT * FROM ".self::$table_name;
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
					AND is_active = 'Y' 
					AND id > 0
					AND job_status = 'approved' ";
					
		if (!empty($country) ) 	$sql .= " AND country='".$country."' ";
		if (!empty($states) ) 	$sql .= " AND state_province='".$states."' ";
		if (!empty($county) ) 	$sql .= " AND county='".$county."' ";
		if (!empty($city) ) 	$sql .= " AND city='".$city."' ";

		//$sql .= " GROUP BY city ";
		
		//echo $sql;
		
		return self::find_by_sql( $sql );
	}
	
	public static function get_total_job_by_location( $country=null, $states=null, $county=null, $city=null ){
		global $database, $db;	

		$sql = " SELECT count(*) as total FROM ".self::$table_name;
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
					AND is_active = 'Y' 
					AND id > 0
					AND job_status = 'approved' ";
		if (!empty($country) ) 	$sql .= " AND country='".$country."' ";
		if (!empty($states) ) 	$sql .= " AND state_province='".$states."' ";
		if (!empty($county) ) 	$sql .= " AND county='".$county."' ";
		if (!empty($city) ) 	$sql .= " AND city='".$city."' ";

    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}

	public function location_top_link( $country=null, $states=null, $county=null, $city=null ){
		global $database, $db;	

		$sql = " SELECT * FROM ".self::$table_name;
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
					AND is_active = 'Y' 
					AND id > 0
					AND job_status = 'approved' ";
		
		$groupBY = " GROUP BY country ";
		
		if (!empty($country) ) 	{$sql .= " AND country='".$country."' "; $groupBY = " GROUP BY country, state_province"; }
		if (!empty($states) ) 	{$sql .= " AND state_province='".$states."' "; $groupBY = " GROUP BY country, state_province, county";}
		if (!empty($county) ) 	{$sql .= " AND county='".$county."' "; $groupBY = " GROUP BY country, state_province, county, city";}
		//if (!empty($city) ) 	{$sql .= " AND city='".$city."' "; $groupBY = " GROUP BY country, state_province, county, city";}

		$sql .= $groupBY;
		
		//echo $sql;
		return self::find_by_sql( $sql );
	}

////top ten days jobs
/*** top ten date job **/
	public static function gorup_jobs_by_dates(){
		$sql = " SELECT *, DATE_FORMAT(created_at, GET_FORMAT(DATE,'JIS')) AS just_date ";
		$sql .= " FROM " .self::$table_name;
		$sql .= "  WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW()
					   AND is_active = 'Y' 
					   AND id > 0
					   AND job_status = 'approved' 
				  GROUP BY just_date 
				  ORDER BY created_at DESC 
				  LIMIT 0, 10";//.JOB_BY_DATE_MAX;
		//echo $sql;
		return self::find_by_sql( $sql );
	}
	
	public static function get_group_job($job_date){
		//$job_date = substr($job_date, 0, -8);
		$job_date = date( "Y-m-d",strtotime($job_date) );
		$sql = "SELECT * FROM " .self::$table_name;
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW()
					   	AND is_active = 'Y'
					   	AND id > 0 
					   	AND job_status = 'approved' 
						AND DATE_FORMAT(created_at, GET_FORMAT(DATE,'JIS')) = '".$job_date."'  
				  ORDER BY created_at DESC 
				  LIMIT 0, 10";//.JOB_BY_DATE_GROUP_MAX ;
	//echo $sql;
		return self::find_by_sql( $sql );
	}





############################# Saving and Updating ##########################	
	public function save() {
		
		if( !isset($this->contact_name) || empty($this->contact_name) ){
			$this->errors[] = "Contact Name is Required";
		}
	 	
		if( isset($this->contact_telephone) && !empty($this->contact_telephone) ){
			 $this->contact_telephone = phone_number($this->contact_telephone);
			 if( !$this->contact_telephone ){
				 $this->errors[] = "Invalid phone number ". $this->contact_telephone ;
			 }
	 	}
	 
		if ( !isset($this->poster_email) || empty($this->poster_email) ){
			$this->errors[] = "Email address is Required";
		}
		
		if ( isset($this->poster_email) && !empty($this->poster_email) ){
			$this->poster_email = check_email( $this->poster_email );
			if ( $this->poster_email == "" ){
				$this->errors[] = "Invalid email address e.g user@domain.com/co.uk/net";
			}
		}
		
		if( !empty($this->site_link) ){
			if( validateURL($this->site_link ) ) {
				$this->site_link = check_http( $this->site_link );
			}else{
				$this->errors[]= "Invalid URL address e.g www.domain.com/co.uk/net";
			}
		}
	
		if( !isset($this->job_title)  || empty($this->job_title))
		{
			$this->errors[] = "Job Title is Required";
		}
		
		$allowedTags='<p><strong><em><u><img><span><style><blockquote>';
		$allowedTags.='<li><ol><ul><span><div><br><ins><del><a><span>';
	
		$this->job_description = strip_tags( stripslashes($this->job_description), $allowedTags);	
		
		if( !isset($this->job_description) || empty($this->job_description) )
		{
			$this->errors[] = "Job Description is Required";
		}
		
		if( ( !isset($this->job_type) || empty($this->job_type) ) || $this->job_type <= 0 )
		{
			$this->errors[] = "Job Type is Required";
		}
		
		if( ( !isset($this->j_status) || empty($this->j_status) ) || $this->j_status <= 0 )
		{
			$this->errors[] = "Job Status is Required";
		}
		
		if( empty($this->state_province) || empty($this->county) || (!isset($this->city) || empty($this->city)) )
		{
			$this->errors[] = "Job Location is Required";
		}
		
		if( ( !isset($this->category) || empty($this->category) ) || $this->category <= 0 )
		{
			$this->errors[] = "Job Category is Required";
		}
		
		if( $this->category > 10 )
		{
			$this->errors[] = "MAX 10 categories allowed";
		}
		
		
		if( sizeof( $this->errors) == 0){
			// A new record won't have an id yet.
			if(isset($this->id)) {
				return $this->update();
			}else{
				
				$this->var_name = $this->mod_write_check( $this->job_title, null );
				
				if( ENABLE_NEW_JOBS == "Y" || ENABLE_NEW_JOBS == "1" ){
						$this->is_active	= "Y";
				}
				
				if( APPROVE_JOB == "Y" || APPROVE_JOB == "1" ){
						$this->job_status = "approved";
				}
				
				$this->created_at = strftime(" %Y-%m-%d %H:%M:%S ", time() );
				
				if ( $this->create() ){
					return true;
				}else{
					$this->errors[]="Problem occur.Please make sure all fields have been complated";
					return false;
				}
				
			}
		}
		
	}

### get job by employee	
	public static function list_job_by_employer(){
		global $database, $db;
		$sql = " SELECT fk_employer_id FROM ".self::$table_name;
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
					AND is_active = 'Y' 
					AND id > 0 
					AND job_status = 'approved' 
					AND fk_employer_id <> '' ";
		$sql .= " GROUP BY fk_employer_id ";
		//echo $sql;
		return self::find_by_sql( $sql );
	}
	
	public static function job_by_employer( $id=0, $per_page=0, $offset=0 ){
		global $database, $db;
		$sql = " SELECT * FROM ".self::$table_name;
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
					AND is_active = 'Y' 
					AND id > 0
					AND job_status = 'approved' 
					AND fk_employer_id = '" .$db->escape_value( $id ) ."' ";
		
		if( $per_page != 0 )
		{$sql .= " LIMIT ".$per_page." OFFSET ".$offset;}
		
		//echo $sql;
		return self::find_by_sql( $sql );
	}

	public function list_spotlight($var_name=null){
		global $database, $db;
		$sql=" SELECT * FROM " .self::$table_name;
		$sql.=" WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW()
					  AND var_name <> '".$db->escape_value($var_name)."' 
					  AND id > 0
					  AND is_active = 'Y'
					  AND job_status = 'approved' 
					  AND (spotlight = 'Y') ";
		$sql.=" ORDER BY RAND() LIMIT 0, ".SPOTLIGHT_JOBS." ";
		
		//echo $sql;
		
		return self::find_by_sql( $sql );
	}
	
	/**latest job */
	public function latest_job($var_name=null){
		global $database, $db;
		$sql=" SELECT * FROM " .self::$table_name;
		$sql .=" WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW()
					   AND is_active = 'Y'
					   AND var_name <> '".$db->escape_value($var_name)."' 
					   AND id > 0
					   AND job_status = 'approved' 
				 ORDER by created_at DESC LIMIT 0, ". LATEST_JOBS ; 
		return self::find_by_sql( $sql );
	}

	public static function total_job_by_employer ( $id=0 ){
		global $database, $db;
		$sql = " SELECT Count(id) as total_job  FROM ".self::$table_name;
		$sql .= " WHERE DATE_ADD( created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
						AND fk_employer_id =".$db->escape_value( $id )."
						AND is_active ='Y'
						AND id > 0
						AND job_status = 'approved'";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}

/**number of views */
	public function views_count(){
		global $database, $db;
		$sql = "SELECT views_count FROM ".self::$table_name;
		$sql .= " WHERE id =".(int)$this->id . " AND is_active ='Y' AND job_status = 'approved' LIMIT 1 ";
		$result = $database->query ( $sql );
		$found 	= $database->fetch_array( $result );
		$row 	= $database->num_rows( $result );
		return ( $row == 1 ) ? $found['views_count'] : false;
	}
	/* update views */
	public function update_views(){
		global $database, $db;
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET views_count = views_count + 1";
		$sql .= " WHERE id =".(int)$this->id . " AND is_active ='Y' AND job_status = 'approved' LIMIT 1 ";

		if($database->query($sql)) {
	    	return true;
	  	} else {
	    	return false;
	  	}
	}
	
	/**num of apply for job **/
	public function apply_count(){
		global $database, $db;
		$sql = "SELECT apply_count FROM ".self::$table_name;
		$sql .= " WHERE id =".(int)$this->id . " AND job_status = 'approved' LIMIT 1 ";
		$result = $database->query ( $sql );
		$found 	= $database->fetch_array( $result );
		$row 	= $database->num_rows( $result );
		return ( $row == 1 ) ? $found['apply_count'] : false;
	}
	
	public function update_apply(){
		global $database, $db;
		$sql = " UPDATE ".self::$table_name;
		$sql .= " SET apply_count = apply_count + 1";
		$sql .= " WHERE id =".(int)$this->id . " AND is_active ='Y' AND job_status='approved' LIMIT 1 ";
		
		//echo $sql;
		
		if($database->query($sql)) {
	    	return true;
	  	} else {
	    	return false;
	  	}
	}
	
	
	/* active job */
	public function active_job(){
		global $database, $db;
		$sql = " UPDATE " . self::$table_name;
		$sql .= " SET is_active = 'Y' WHERE id=".(int)$this->id;
		//echo $sql;
		$database->query( $sql );
		return ( $database->affected_rows() == 1 ) ? true : false;
	}
	
	public function deactive_job(){
		global $database, $db;
		$sql = " UPDATE " . self::$table_name;
		$sql .= " SET is_active = 'N' WHERE id=".(int)$this->id;
		$database->query( $sql );
		return ( $database->affected_rows() == 1 ) ? true : false;
	}
	
	/**spotlight**/
	public function spotlight_activate(){
		global $database, $db;
		$sql = " UPDATE " . self::$table_name;
		$sql .= " SET spotlight = 'Y' WHERE id=".(int)$this->id;
		$result = $database->query( $sql );
		return ( $database->affected_rows() == 1 ) ? true : false;
	}
	
	public function spotlight_deactivate(){
		global $database, $db;
		$sql = " UPDATE " . self::$table_name;
		$sql .= " SET spotlight  = 'N' WHERE id=".(int)$this->id;
		$result = $database->query( $sql );
		return ( $database->affected_rows() == 1 ) ? true : false;
	}

/********************************* 	EMPLOYER *************************************/
	public function get_list_of_jobs_by_employer_id(){
		global $database, $db;
		$sql = " SELECT * FROM " . self::$table_name;
		$sql .= " WHERE fk_employer_id=".(int)$this->fk_employer_id ;
		return self::find_by_sql( $sql );
	}

	public function deactive_job_by_user(){
		global $database, $db;
		$sql = " UPDATE " . self::$table_name;
		$sql .= " SET is_active = 'N' ";
		$sql .= " WHERE id=".(int)$this->id;
		$sql .= " AND fk_employer_id=".$this->fk_employer_id;
		$sql .= " LIMIT 1";
		$database->query( $sql );
		return ( $database->affected_rows() == 1 ) ? true : false;
	}

	public function active_job_by_user(){
		global $database, $db;
		$sql = " UPDATE " . self::$table_name;
		$sql .= " SET is_active = 'Y' ";
		$sql .= " WHERE id=".(int)$this->id;
		$sql .= " AND fk_employer_id=".$this->fk_employer_id;
		$sql .= " LIMIT 1";
		$database->query( $sql );
		return ( $database->affected_rows() == 1 ) ? true : false;
	}
	
	public function delete_by_user(){
		global $database, $db;
		$sql = "DELETE FROM ".self::$table_name;
		$sql .= " WHERE id=". $database->escape_value($this->id);
		$sql .= " AND fk_employer_id=" .$db->escape_value( $this->fk_employer_id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}

	public function find_by_employer(){
		global $database, $db;
		$sql = " SELECT * FROM " . self::$table_name;
		$sql .= " WHERE id=".(int)$this->id;
		$sql .= " AND fk_employer_id=".$this->fk_employer_id;
		$sql .= " LIMIT 1 ";
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}

	public function clone_job( $id=0, $user_id ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE id= ".$db->escape_value($id);
		$sql .= " AND fk_employer_id=".$db->escape_value($user_id);
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
/**************************** ADMIN *******************************************/
	public function approve_job(){
		global $database, $db;
		$sql = " UPDATE " . self::$table_name;
		$sql .= " SET job_status = 'approved' ";
		$sql .= " WHERE id=".(int)$this->id;
		$sql .= " LIMIT 1";
		$database->query( $sql );
		return ( $database->affected_rows() == 1 ) ? true : false;
	}
	
	/** reject the job and enter comments */
	public function reject_job(){
		global $database, $db;
		$sql = " UPDATE " . self::$table_name;
		$sql .= " SET job_status = 'rejected', 
					admin_comments = '".$db->escape_value( $this->admin_comments )."'";
		$sql .= " WHERE id=".(int)$this->id;
		$sql .= " LIMIT 1";
		$database->query( $sql );
		return ( $database->affected_rows() == 1 ) ? true : false;
	}
	
	public function list_all_approve_jobs(){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE job_status='approved' ";
		return self::find_by_sql( $sql );
	}
	
	public function list_all_rejected_jobs(){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE job_status='rejected' ";
		return self::find_by_sql( $sql );
	}
	
	public function list_all_pending_jobs(){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE job_status='pending' ";
		return self::find_by_sql( $sql );
	}
	
	public function repost(){
		global $database, $db;
		$sql = " UPDATE " . self::$table_name;
		$sql .= " SET created_at = '".$this->created_at."'";
		$sql .= " WHERE id=".(int)$this->id;
		$sql .= " LIMIT 1";
		$database->query( $sql );
		return ( $database->affected_rows() == 1 ) ? true : false;
	}
	
###################################### approved ##############################################################
	/****** count jobs ******/
	public static function count_all_active_approved() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'approved' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_approved() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'approved' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	/*** approval today */
	public static function count_all_active_approval_today() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'approved' AND date(created_at) = curdate() ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_approval_today() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'approved' AND date(created_at) = curdate() ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	/*** approval this week */
	public static function count_all_active_approval_week() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'approved' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 WEEK) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_approval_week() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'approved' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 WEEK) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}	
	
	/*** approval this month */
	public static function count_all_active_approval_month() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'approved' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_approval_month() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'approved' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
############################################################################################################


############################################ pending ################################################################
	/****** count jobs ******/
	public static function count_all_active_pending() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'pending' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_pending() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'pending' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	/*** approval today */
	public static function count_all_active_pending_today() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'pending' AND date(created_at) = curdate() ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_pending_today() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'pending' AND date(created_at) = curdate() ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	/*** pending this week */
	public static function count_all_active_pending_week() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'pending' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 WEEK) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_pending_week() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'pending' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 WEEK) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}	
	
	/*** pending this month */
	public static function count_all_active_pending_month() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'pending' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_pending_month() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'pending' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
############################################################################################################
	
############################################ Rejected ################################################################
	/****** count jobs ******/
	public static function count_all_active_rejected() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'rejected' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_rejected() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'rejected' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	/*** approval today */
	public static function count_all_active_rejected_today() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'rejected' AND created_at = curdate() ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_rejected_today() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'rejected' AND date(created_at) = curdate() ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	/*** rejected this week */
	public static function count_all_active_rejected_week() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'rejected' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 WEEK) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_rejected_week() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'rejected' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 WEEK) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}	
	
	/*** rejected this month */
	public static function count_all_active_rejected_month() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'rejected' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_rejected_month() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'rejected' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
############################################################################################################
	
############################################ Expired ################################################################
	/****** count jobs ******/
	public static function count_all_active_expired() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'expired' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_expired() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'expired' ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	/*** approval today */
	public static function count_all_active_expired_today() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'expired' AND created_at = curdate() ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_expired_today() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'expired' AND date(created_at) = curdate() ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	/*** expired this week */
	public static function count_all_active_expired_week() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'expired' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 WEEK) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_expired_week() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'expired' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 WEEK) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}	
	
	/*** expired this month */
	public static function count_all_active_expired_month() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'Y' AND job_status = 'expired' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
	
	public static function count_all_not_active_expired_month() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
		$sql .= " WHERE is_active = 'N' AND job_status = 'expired' AND created_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ";
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}
############################################################################################################
	
	
	
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

$job 	= new Job();
?>