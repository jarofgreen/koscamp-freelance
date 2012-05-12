<?php $_SESSION['direct_to_emp'] = "addjob/"; 	
	 include_once('sessioninc.php');

	$page = return_url();
	$action = $page[1];
	$spotlight = $page[2];
	
	$user_id = $session->get_user_id();
	$employer = Employer::find_by_id( $user_id );
	$total_post			  = $employer->total_job_post();
	define('TEMP_TOTAL_POST', $total_post);
	
	$total_spotlight_post = $employer->total_spotlight_job_post();
	define('TEMP_TOTAL_SPOTLIGHT_POST', $total_spotlight_post);
	
	if ( FREE_SITE == "N" || FREE_SITE == "0" || FREE_SITE == false ){
		if( $total_post <= 0 && !isset($spotlight)  ):
			$session->message( '<div class="error">'.format_lang('total_jobpost').'</div>');
			redirect_to(BASE_URL."employer/credits/");
			die;			
		elseif( $total_spotlight_post <=0  && (isset($spotlight) && $spotlight == "spotlight") ):
			$session->message( "<div class='error'>".format_lang('total_spotlight_post')."</div>");
			redirect_to(BASE_URL."employer/credits/");
			die;
		else:
			if( isset($spotlight) && $spotlight == "spotlight" ) {
				$info =  "<p>".format_lang('total_spotlight_post')."</p>";
			}else{
				$info =  "<p>".format_lang('total_jobpost')."</p>";
			}
			$smarty->assign( 'credit_remaining', $info );
		endif;
	}
	
	///when button is press run this 
	if ( isset($_POST['bt_add']) ){
		$job = new Job;
		$job->fk_employer_id=(int)$user_id;
		
		$_SESSION['add_job']['job_ref'] =  $job->job_ref 	= $_POST['txt_ref_code'];
		$job->var_name 			= $job->mod_write_check ( $_POST['txt_job_title'], null );
		
		$_SESSION['add_job']['job_title'] =$job->job_title 		= stripHTMLTags($_POST['txt_job_title']);
		$_SESSION['add_job']['job_desc'] =$job->job_description = allowedTags($_POST['txt_job_desc']);
		$_SESSION['add_job']['job_postion'] =$job->job_postion 	= stripHTMLTags($_POST['txt_position']);
			
		$_SESSION['add_job']['salary'] = $job->job_salary		= stripHTMLTags($_POST['txt_salary']);
		$_SESSION['add_job']['freq'] =$job->salaryfreq 		= $_POST['txt_salaryfreq'];

		$_SESSION['add_job']['cname'] = $job->contact_name 		= stripHTMLTags($_POST['txt_contact_name']);
		$_SESSION['add_job']['tn'] = $job->contact_telephone = stripHTMLTags($_POST['txt_telephone']);
		$_SESSION['add_job']['sl'] = $job->site_link 		= $_POST['txt_site_link'];
		$_SESSION['add_job']['email'] = $job->poster_email 		= stripHTMLTags($_POST['txt_email']);
		$_SESSION['add_job']['jsd'] =$job->start_date 		= $_POST['txt_start_date'];
		
		if( isset($spotlight) && $spotlight == "spotlight" ) : $job->spotlight = "Y";
		else: $job->spotlight= "N"; endif;
		
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


###############localtion

		$_SESSION['loc']['citycode']	= $job->city 			= stripHTMLTags($_POST['txtcity']);
		$_SESSION['loc']['countycode'] 	= $job->county 		= stripHTMLTags($_POST['txtcounty']);
		$_SESSION['loc']['stateprovince']= $job->state_province = stripHTMLTags($_POST['txtstateprovince']);
		$_SESSION['loc']['country'] 	= $job->country 		= stripHTMLTags($_POST['txt_country']);
		
		if ( is_array($_POST['txt_category']) && !empty($_POST['txt_category']) ) {
			$category_selected =array();
			foreach ( $_POST['txt_category'] as $key => $value ):
				$category_selected[] = $value;
			endforeach;
		}
		$job->category 	= (int)sizeof($_POST['txt_category']);
		$smarty->assign( 'category_selected', $category_selected );	
		
		//try to save data
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
			if( is_array($_POST['txt_category']) && !empty($_POST['txt_category']) ){
				foreach ( $_POST['txt_category'] as $key => $value ):
					$cat_added = JobCategory::make( $value, $job_id );
					$cat_added->save();
				endforeach;
			}
			
			
			if($status_added && $cat_added && $type_added )
			{
				if ( FREE_SITE == "N" ){	
					if( $spotlight == "spotlight" ) {
						$employer->update_spotlight_job_post();
					}else{
						$employer->update_job_post();
					}
				}
			
				unset($_SESSION['add_job']);
				$message ="<div class='success'>".format('success', 'job_added')."</div>";
				destroy_my_session();
			}else{
				$message = "<div class='error'>".format_lang('error','jobSaveFail')."</div>";
			}
			$session->message ($message);
		}
		else
		{
			$message = "<div class='error'> 
							".format_lang('following_errors')."
						<ul> <li />";
			$message .= join(" <li /> ", $job->errors);
			$message .= " </ul> 
						</div>";
		}
	$session->message ($message);
	redirect_to ( BASE_URL. "employer/addjob/".$spotlight );
}
//end of button

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
	
	$salaryfreq = get_lang('select', 'salaryfreq');
	$smarty->assign( 'salaryfreq', $salaryfreq );
		
////location

	$default_county = empty($_SESSION['loc']['country']) ? DEFAULT_COUNTRY : $_SESSION['loc']['country'];
	$_SESSION['loc']['country'] = $countrycode = $default_county = $default_county;
	$smarty->assign( 'countrycode', $countrycode );
	
	$country 	= Country::find_all_order_by_name();
	if ( is_array($country) && !empty($country) ) {
		$country_t = array();
		$country_t['AA'] = 'All Countries';
		foreach( $country as $co ):
			if ($val['code'] != 'AA') {
				$country_t[ $co->code ] = $co->name;
			}
		endforeach; 
		$smarty->assign( 'country', $country_t );
	}
	
	$state = new StateProvince();
	$county 	= new County();
	$city = new City();
	
	$lang['states'] = $state->get_stateOptions( $countrycode, 'N' );
	if (count($lang['states']) == 1) {
		foreach ($lang['states'] as $key => $val) {
			$_SESSION['loc']['stateprovince'] = $key;
		}
	}
	//status 
	$_SESSION['loc']['stateprovince'] = ($_SESSION['loc']['stateprovince']!= '') ? $_SESSION['loc']['stateprovince'] : "";
	if ($_SESSION['loc']['stateprovince'] != '') {
		$lang['counties'] = $county->get_countyOptions( $countrycode, $_SESSION['loc']['stateprovince'], 'N' );
		if (count($lang['counties']) == 1) {
			foreach ($lang['counties'] as $key => $val) {
				$_SESSION['loc']['countycode'] = $key;
			}
		}
		//county
		$_SESSION['loc']['countycode'] = ($_SESSION['loc']['countycode']!= '') ? $_SESSION['loc']['countycode'] : "";
		if ( $_SESSION['loc']['countycode'] != '') {
			$lang['cities'] = $city->get_cityOptions($countrycode, $_SESSION['loc']['stateprovince'], $_SESSION['loc']['countycode'], 'N');
			if (count($lang['cities']) == 1) {
				foreach($lang['cities'] as $key => $val) {
					$_SESSION['loc']['citycode'] = $key;
				}
			}
			//city
			$_SESSION['loc']['citycode'] = ($_SESSION['loc']['citycode']!= '') ? $_SESSION['loc']['citycode'] : "" ;
		}
	}
//end of location 
	
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
	
	$html_title 		= SITE_NAME . " - ".format_lang('page_title','AddNewJob');
	
	$smarty->assign('lang', $lang);
	$smarty->assign( 'message', $message );
	$smarty->assign('rendered_page', $smarty->fetch('employer/addjob.tpl') );
?>