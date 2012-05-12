<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	$employer_id = (int)$_REQUEST ['employer_id'];
	$username = $_REQUEST['username'];
	$smarty->assign( 'employer_id', $employer_id );	
	$smarty->assign( 'username', $username );	
	
	$employer = Employer::find_by_id( $employer_id );
	if($employer) $smarty->assign( 'employer_fullname', $employer->full_name() );
	
	//unset($_SESSION['add_job']);
	///when button is press run this 
	if ( isset($_POST['bt_add']) ){
		$job->fk_employer_id = $employer_id;
		
		$_SESSION['add_job']['job_ref'] =  $job->job_ref 			= $_POST['txt_ref_code'];
		$job->var_name 			= $job->mod_write_check ( $_POST['txt_job_title'], null );
		
		$_SESSION['add_job']['job_title'] =$job->job_title 		= $_POST['txt_job_title'];
		$_SESSION['add_job']['job_desc'] =$job->job_description 	= $_POST['txt_job_desc'];
		$_SESSION['add_job']['job_postion'] =$job->job_postion 		= $_POST['txt_position'];
		
		$_SESSION['add_job']['salary'] = $job->job_salary		= $_POST['txt_salary'];
		$_SESSION['add_job']['freq'] =$job->salaryfreq 		= $_POST['txt_salaryfreq'];
		
		$_SESSION['add_job']['cname'] = $job->contact_name 		= $_POST['txt_contact_name'];
		$_SESSION['add_job']['tn'] = $job->contact_telephone = $_POST['txt_telephone'];
		$_SESSION['add_job']['sl'] = $job->site_link 		= $_POST['txt_site_link'];
		$_SESSION['add_job']['email'] = $job->poster_email 		= $_POST['txt_email'];
		$_SESSION['add_job']['jsd'] =$job->start_date 		= $_POST['txt_start_date'];
		
		
		if ( is_array($_POST['txt_job_type']) && !empty($_POST['txt_job_type']) ) {
			$type_selected =array();
			foreach ( $_POST['txt_job_type'] as $key => $value ):
				$type_selected[] = $value;
			endforeach;
		}
		$job->job_type=sizeof($_POST['txt_job_type']);
		$smarty->assign( 'type_selected', $type_selected );

		if ( is_array($_POST['txt_job_status']) && !empty($_POST['txt_job_status']) ) {
			$selected =array();
			foreach ( $_POST['txt_job_status'] as $key => $value ):
				$_SESSION['add_job']['job_status'] = $selected[] = $value;
			endforeach;
		}
		$job->j_status=sizeof($_POST['txt_job_status']);
		$smarty->assign( 'status_selected', $selected );
		
		
		if ( is_array($_POST['txt_education']) && !empty($_POST['txt_education']) ) {
			$education_selected =array();
			foreach ( $_POST['txt_education'] as $key => $value ):
				$education_selected[] = $value;
				$job->fk_education_id 	= (int)$value;
			endforeach;
		}
		$smarty->assign( 'education_selected', $education_selected );


		if ( is_array($_POST['txt_career']) && !empty($_POST['txt_career']) ) {
			$career_selected =array();
			foreach ( $_POST['txt_career'] as $key => $value ):
				$career_selected[] = $value;
				$job->fk_career_id 	= (int)$value;
			endforeach;
		}
		$smarty->assign( 'career_selected', $career_selected );


		if ( is_array($_POST['txt_experience']) && !empty($_POST['txt_experience']) ) {
			$experience_selected =array();
			foreach ( $_POST['txt_experience'] as $key => $value ):
				$experience_selected[] = $value;
				$job->fk_experience_id 	= (int)$value;
			endforeach;
		}
		$smarty->assign( 'experience_selected', $experience_selected );


###############localtion ///////////////
		$job->country = $_POST['txt_country'];
		$_SESSION['add_job']['city'] = $job->city= $_POST['txtcity'];
		$_SESSION['add_job']['county'] = $job->county=$_POST['txtcounty'];
		$_SESSION['add_job']['state'] = $job->state_province=$_POST['txtstateprovince'];
		
		if ( is_array($_POST['txt_category']) && !empty($_POST['txt_category']) ) {
			$category_selected =array();
			foreach ( $_POST['txt_category'] as $key => $value ):
				$category_selected[] = $value;
			endforeach;
		}
		$job->category 	= (int)sizeof($_POST['txt_category']);
		$smarty->assign( 'category_selected', $category_selected );	
		
		
		if( $job->save() )
		{
			$job_id = (int)$database->insert_id();
			
			if ( is_array($_POST['txt_job_type']) && !empty($_POST['txt_job_type']) ) {
				foreach ( $_POST['txt_job_type'] as $key => $value ):
					$type_added = Job2Type::make(  $job_id, $value );
					$type_added->save();
				endforeach;
			}
			
			if ( is_array($_POST['txt_job_status']) && !empty($_POST['txt_job_status']) ) {
				foreach ( $_POST['txt_job_status'] as $key => $value ):
					$status_added = Job2Status::make(  $job_id, $value );
					$status_added->save();
				endforeach;
			}
			
			/**adding cat */
			foreach ( $_POST['txt_category'] as $key => $value ):
				$cat_added = JobCategory::make( $value, $job_id );
				$cat_added->save();
			endforeach;
			
			
			if($status_added && $cat_added && $type_added )
			{
				unset($_SESSION['add_job']);
				$message ="<div class='success'>Successfully Added<br>Job has been added! it will last for 30 days!</div>";
				//$clint->username = $username;
			}else{
				$message = "<div class='error'>Unable to save data into database</div>";
			}
			redirect_to ( $_SERVER['PHP_SELF'] );
		}
		else
		{
			$message = "<div class='error'> 
							following error(s) found:
						<ul> <li />";
			$message .= join(" <li /> ", $job->errors);
			$message .= " </ul> 
						</div>";
		}
	$session->message ($message);
}


	$job_types	= JobType::find_all();
	if ( is_array($job_types) and !empty($job_types) ) {
		$job_t = array();
		foreach( $job_types as $job_type ):
			$job_t[ $job_type->id ] = $job_type->type_name;
		endforeach; 
		$smarty->assign( 'job_type', $job_t );
	}
	
	$job_status = JobStatus::find_all();
	if ( is_array($job_status) and !empty($job_status) ) {
		$statu_t = array();
		foreach( $job_status as $job_statu ):
			$statu_t[ $job_statu->id ] = $job_statu->status_name;
		endforeach; 
		$smarty->assign( 'job_status', $statu_t );
	}
	

////location/////////////
	$countrycode = DEFAULT_COUNTRY;
	$countrycode = !empty( $countrycode ) ? $countrycode : "GB";
	
	$smarty->assign( 'countrycode', $countrycode );	
	
	$state = new StateProvince();
	$county 	= new County();
	$city = new City();
	
	$lang['states'] = $state->get_stateOptions( $countrycode, 'N' );

	if (count($lang['states']) == 1) {
		foreach ($lang['states'] as $key => $val) {
			$_SESSION['add_job']['state'] = $key;
		}
	} 

	//status 
	$_SESSION['add_job']['state'] = ($_SESSION['add_job']['state']!= '') ? $_SESSION['add_job']['state'] : "";
	if ($_SESSION['add_job']['state'] != '') {
		$lang['counties'] = $county->get_countyOptions( $countrycode, $_SESSION['add_job']['state'], 'N' );	
		if (count($lang['counties']) == 1) {
			foreach ($lang['counties'] as $key => $val) {
				$_SESSION['add_job']['county'] = $key;
			}
		}
		//county
		$_SESSION['add_job']['county'] = ($_SESSION['add_job']['county']!= '') ? $_SESSION['add_job']['county'] : "";
		if ($_SESSION['add_job']['county'] != '') {
			$lang['cities'] = $city->get_cityOptions($countrycode, $_SESSION['add_job']['state'], $_SESSION['add_job']['county'], 'N');
			if (count($lang['cities']) == 1) {
				foreach($lang['cities'] as $key => $val) {
					$_SESSION['add_job']['city'] = $key;
				}
			}
			//city
			$_SESSION['add_job']['city'] =  ($_SESSION['add_job']['city']!= '') ? $_SESSION['add_job']['city'] : "";
		}
	}
//end//
	
	$educations	= Education::find_all();
	if ( is_array($educations) and !empty($educations) ) {
		$education_t = array();
		foreach( $educations as $education ):
			$education_t[ $education->id ] = $education->education_name;
		endforeach; 
		$smarty->assign( 'education', $education_t );
	}
	
	$careers	= CareerDegree::find_all();
	if ( is_array($careers) and !empty($careers) ) {
		$career_t = array();
		foreach( $careers as $career ):
			$career_t[ $career->id ] = $career->career_name;
		endforeach; 
		$smarty->assign( 'career', $career_t );		
	}
	
	$experiences = Experience::find_all();
	if ( is_array($experiences) and !empty($experiences) ) {
		$experience_t = array();
		foreach( $experiences as $experience ):
			$experience_t[ $experience->id ] = $experience->experience_name;
		endforeach; 
		$smarty->assign( 'experience', $experience_t );

	}
	
	$categories	= Category::find_all();
	if ( is_array($categories) and !empty($categories) ) {
		$category_t = array();
		foreach( $categories as $category ):
			$category_t[ $category->id ] = $category->cat_name;
		endforeach; 
		$smarty->assign( 'category', $category_t );
	}
	
	$html_title 		= SITE_NAME . " - Add new job";
	
	$smarty->assign('lang', $lang);
	$smarty->assign( 'message', $message );
	$smarty->assign('rendered_page', $smarty->fetch('admin/new_job.tpl') );
	$smarty->display('admin/index.tpl');
	unset($_SESSION['message']);
?>