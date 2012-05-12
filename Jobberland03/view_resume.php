<?php $_SESSION['direct_to'] = BASE_URL."curriculum_vitae/"; 	
	 include_once('sessioninc.php');
	 destroy_my_session();
	 
	$username = $session->get_username();
	$user_id = $session->get_user_id();
	$country_code = DEFAULT_COUNTRY;
	
		$cv_setting = new CVSetting();
		//$cv_setting->id = $cv_id = $id;
		$_SESSION['resume']['id'] = $cv_setting->id  = $cv_id = $id;
		$cv_setting->fk_employee_id = $user_id;
		$cv_details = $cv_setting->cv_review_by_employee();
		
		if( !$cv_details && !is_array($cv_details) ){
			$session->message("<div class='error'>".format_lang('errormsg', 09)."</div>");
			redirect_to(BASE_URL . 'curriculum_vitae/');
			exit;
		}
		
		if( $cv_details->modified_at == '' || empty($cv_details->modified_at)){
			//$session->message("<div class='error'>CV has not been modified</div>");
			redirect_to(BASE_URL . 'curriculum_vitae/resume/'.$id.'/change/');
			exit;
		}
		
		$cv_status	= strtolower($cv_details->cv_status);
		$smarty->assign( 'cv_status', $cv_status );
			
		$ye = empty($cv_details->year_experience) ? 0 : $cv_details->year_experience;
		$experiences = Experience::find_by_id( $ye );
		$exper 		= !empty( $experiences ) ? $experiences->experience_name : format_lang('none');
		$smarty->assign( 'exper', $exper );	
		
		$he = empty($cv_details->highest_education) ? 0 : $cv_details->highest_education;
		$educations	= Education::find_by_id( $he );
		$educ		= !empty($educations) ? $educations->education_name : format_lang('none') ;
		$smarty->assign( 'educ', $educ );	
		
		$get_salary = format_lang('select','salary');
		$salary 	= !empty($cv_details->salary_range) ? $get_salary[$cv_details->salary_range] : format_lang('none');
		$smarty->assign( 'salary', $salary );	
		
		$get_NoYes = format_lang('select','NoYes');
		$availabe 	= !empty($cv_details->availability) ? $get_NoYes[$cv_details->availability] : format_lang('none');
		$smarty->assign( 'availabe', $availabe );
		
		$str_date 	= $cv_details->start_date;
		if( $cv_details->start_date != "0000-00-00 00:00:00" && $cv_details->start_date != NULL){
			$str_date_d	= date("d",strtotime($cv_details->start_date));
			$str_date_m	= date("m",strtotime($cv_details->start_date));
			$str_date_y	= date("Y",strtotime($cv_details->start_date));
			$str_date 	= $str_date_y . "-".$str_date_m."-".$str_date_d . " 00:00:00";
			$str_date = strftime(DATE_FORMAT, strtotime( $str_date ) );
		}
		$smarty->assign( 'str_date', $str_date );
		
		$position	= $cv_details->positions;
		$smarty->assign( 'position', $position );	
		
		//recent job details
		$rjt 		= $cv_details->recent_job_title;
		$smarty->assign( 'rjt', $rjt );	
		
		$re			= $cv_details->recent_employer;
		$smarty->assign( 're', $re );	
		
		$cat = empty($cv_details->recent_industry_work) ? 0 : $cv_details->recent_industry_work;
		$categories	= Category::find_by_id( $cat );
		$riw		= $categories ? $categories->cat_name : format_lang('none');
		$smarty->assign( 'riw', $riw );	
		
		$cl = empty($cv_details->recent_career_level) ? 0 : $cv_details->recent_career_level;
		$careers	= CareerDegree::find_by_id( $cl );
		$rcl		= $careers ? $careers->career_name : format_lang('none');
		$smarty->assign( 'careers', $rcl );	
		
		//what are you looking for
		$ljt		= $cv_details->look_job_title;
		$smarty->assign( 'ljt', $ljt );	
		
		$ljt2		= $cv_details->look_job_title2;
		$smarty->assign( 'ljt2', $ljt2 );	
		
		
		$sql = " SELECT * FROM ".TBL_CV_CAT. " WHERE cv_id=".$id;
		$cv_cat = $db->query( $sql );
		$cv_cat_array = array();
		while ($row = $db->fetch_object( $cv_cat ) ) {
			$categories	= Category::find_by_id( $row->category_id );
			$cv_cat_array[] = $categories->cat_name;
		}
		$smarty->assign( 'li', join("<br />",$cv_cat_array ) );
		
		//job states
		$js= empty($cv_details->look_job_status) ? 0 : $cv_details->look_job_status;
		$job_status = JobStatus::find_by_id( $js );
		$ljs		= $job_status ? $job_status->status_name : format_lang('none') ;
		$smarty->assign( 'ljs', $ljs );
		
		//job type
		$job_t = empty($cv_details->look_job_type) ? 0 : $cv_details->look_job_type;
		$job_type_arr = JobType::find_by_id( $job_t );
		//print_r( $job_type_arr);
		$job_types	= $job_type_arr ? $job_type_arr->type_name : format_lang('none') ;
		$smarty->assign( 'job_type', $job_types );
		
		
		//where do you wont to work
		//country 
		$country_arry = Country::find_by_code( $cv_details->country );
		$country_var_name = $country_arry->var_name;
		$country_name = $country_arry->name;
		$smarty->assign('country', $country_name );
	
		//states
		$state = StateProvince::find_by_code( $cv_details->country, $cv_details->state_province );
		$state_name = empty($state) ? $cv_details->state_province : $state->name; 
		$state_var_name = ($state) ? $state->var_name : $cv_details->state_province;
		$smarty->assign('state', $state_name );
		$smarty->assign('state_url', $country_var_name . "/".$state_var_name."/" );
		
		//county
		$county = County::find_by_code( $cv_details->country, $cv_details->state_province, $cv_details->county );
		$county_name = empty($county) ? $cv_details->county : $county->name;
		$county_var_name = ($county) ? $county->var_name : $cv_details->county;
		$smarty->assign('county', $county_name );
		$smarty->assign('county_url', $country_var_name . "/". $state_var_name."/".$county_var_name."/" );
		
		$city = City::find_by_code( $cv_details->country, $cv_details->state_province, $cv_details->county, $cv_details->city );
		$city_name = empty($city) ? $cv_details->city : $city->name;
		$city_var_name = empty($city) ? $cv_details->city : $city->var_name;		
		$smarty->assign('city', $city_name );
		$smarty->assign('city_url', $country_var_name . "/".$state_var_name."/".$county_var_name."/".$city_var_name."/" );
		//end of location
		
		$authorised_to_work = format_lang('select','authorised_to_work');
		$aya		= !empty($cv_details->are_you_auth) ? $authorised_to_work[$cv_details->are_you_auth] : format_lang('none');
		$smarty->assign( 'aya', $aya );	
		
		$wtr		= !empty($cv_details->willing_to_relocate) ? $get_NoYes[$cv_details->willing_to_relocate] : format_lang('none');
		$smarty->assign( 'wtr', $wtr );	
		
		$wtt		= $cv_details->willing_to_travel;
		$smarty->assign( 'wtt', $wtt );	
		
		$notes		= $cv_details->additional_notes ? $cv_details->additional_notes : format_lang('none');
		$smarty->assign( 'notes', $notes );	
		
$smarty->assign( 'id', $id );

$html_title 		= SITE_NAME . " - ".format_lang('page_title', 'cv_view'). " ". $employee->full_name();
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('view_resume.tpl') );
?>