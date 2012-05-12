<?php $_SESSION['direct_to'] = BASE_URL."curriculum_vitae/"; 	
	 include_once('sessioninc.php');
	 
	$username = $session->get_username();
	$user_id = $session->get_user_id();
	$country_code = DEFAULT_COUNTRY;
	
	$cv_setting = new CVSetting();
	$_SESSION['resume']['id'] = $cv_setting->id  = $cv_id = $id;
	$cv_setting->fk_employee_id = $user_id;	

	
	$experiences = Experience::find_all();
	if ( is_array($experiences) and !empty($experiences) ) {
		$experience_t = array();
		foreach( $experiences as $experience ):
			$experience_t[ $experience->id ] = $experience->experience_name;
		endforeach; 
		$smarty->assign( 'experience', $experience_t );

	}
	
	$educations	= Education::find_all();
	if ( is_array($educations) and !empty($educations) ) {
		$education_t = array();
		foreach( $educations as $education ):
			$education_t[ $education->id ] = $education->education_name;
		endforeach; 
		$smarty->assign( 'education', $education_t );
	}

	$categories	= Category::find_all();
	if ( is_array($categories) and !empty($categories) ) {
		$category_t = array();
		foreach( $categories as $category ):
			$category_t[ $category->id ] = $category->cat_name;
		endforeach; 
		$smarty->assign( 'category', $category_t );
	}
	
	$careers	= CareerDegree::find_all();
	if ( is_array($careers) and !empty($careers) ) {
		$career_t = array();
		foreach( $careers as $career ):
			$career_t[ $career->id ] = $career->career_name;
		endforeach; 
		$smarty->assign( 'career', $career_t );		
	}

	
	$job_status = JobStatus::find_all();
	if ( is_array($job_status) and !empty($job_status) ) {
		$statu_t = array();
		foreach( $job_status as $job_statu ):
			$statu_t[ $job_statu->id ] = $job_statu->status_name;
		endforeach; 
		$smarty->assign( 'job_status', $statu_t );
	}

	$job_types	= JobType::find_all();
	if ( is_array($job_types) and !empty($job_types) ) {
		$job_t = array();
		foreach( $job_types as $job_type ):
			$job_t[ $job_type->id ] = $job_type->type_name;
		endforeach; 
		$smarty->assign( 'job_type', $job_t );
	}

//when button is press 	
	if( isset($_POST['bt_save']) ){
		//about your self
		$_SESSION['resume']['status'] 	= $cv_setting->cv_status			= $cv_status= $_POST['txt_status'];
		$_SESSION['resume']['exper'] 	= $cv_setting->year_experience 		= $exper 	= $_POST['txt_experience'];
		$_SESSION['resume']['educ'] 	= $cv_setting->highest_education 	= $educ 	= $_POST['txt_education'];
		$_SESSION['resume']['salary'] 	= $cv_setting->salary_range 		= $salary 	= $_POST['txt_salary'];
		$_SESSION['resume']['availabe'] = $cv_setting->availability 		= $availabe	= $_POST['txt_availabe'];
		
		if( !empty($_POST['txt_start_date_Month']) && !empty($_POST['txt_start_date_Day']) && !empty($_POST['txt_start_date_Year']) ){
			$str_date = mktime(0,0,0,
				$_SESSION['resume']['month']=$str_date_m=$_POST['txt_start_date_Month'],
				$_SESSION['resume']['day']=$str_date_d=$_POST['txt_start_date_Day'], 
				$_SESSION['resume']['year']=$str_date_y=$_POST['txt_start_date_Year']);
			//$_SESSION['resume']['start_date'] = $str_date_y."-".$str_date_m."-".$str_date_d;
			$smarty->assign( 'defult_date', $str_date_y."-".$str_date_m."-".$str_date_d );
			$cv_setting->start_date 			= date("Y-m-d H:i:s",$str_date); //$_POST['txt_start_date'];
		}
		
		$_SESSION['resume']['position'] =$cv_setting->positions 				= $position = $_POST['txt_position'];
		//recent job details
		$_SESSION['resume']['rjt']=$cv_setting->recent_job_title 		= $rjt 		= $_POST['txt_recent_job_title'];
		$_SESSION['resume']['re']=$cv_setting->recent_employer 		= $re		= $_POST['txt_recent_employer'];
		$_SESSION['resume']['riw']=$cv_setting->recent_industry_work 	= $riw		= $_POST['txt_recent_industry'];
		$_SESSION['resume']['rcl']=$cv_setting->recent_career_level 	= $rcl 		= $_POST['txt_recent_career'];
		//what are you looking for
		$_SESSION['resume']['ljt'] =$cv_setting->look_job_title 		= $ljt 		= $_POST['txt_look_job_title'];
		$_SESSION['resume']['ljt2'] =$cv_setting->look_job_title2 		= $ljt2 	= $_POST['txt_look_job_title2'];
		
		if( sizeof($_POST['category']) != 0 && isset($_POST['category'])){
			$cv_details->look_industries="not empty";
		}
		
		if( sizeof($_POST['category']) > 10 ){
			$cv_setting->errors[]=format_lang('errormsg', 43);
		}
		
		$_SESSION['resume']['ljs'] = $cv_setting->look_job_status 		= $ljs 	= $_POST['txt_job_statu'];
		$_SESSION['resume']['job_type'] = $cv_setting->look_job_type = $job_type = $_POST['txt_job_type'];
		
		//where do you wont to work
		$_SESSION['resume']['lw'] = $cv_setting->city = $_SESSION['loc']['citycode'] = $_POST['txtcity'];
		$cv_setting->county	 = $_SESSION['loc']['countycode'] = $_POST['txtcounty'];
		$cv_setting->state_province	= $_SESSION['loc']['stateprovince']	= $_POST['txtstateprovince'];
		$cv_setting->country = $_SESSION['loc']['country'] = $_POST['txt_country'];
		
		$_SESSION['resume']['aya'] =$cv_setting->are_you_auth			= $aya = $_POST['txt_authorised_to_work'];
		$_SESSION['resume']['wtr'] =$cv_setting->willing_to_relocate 	= $wtr = $_POST['txt_relocate'];
		$_SESSION['resume']['wtt'] =$cv_setting->willing_to_travel 		= $wtt = $_POST['txt_travel'];
		$_SESSION['resume']['notes'] = $cv_setting->additional_notes 		= $notes = $_POST['txt_notes'];
		
		//$cv_setting->fk_employee_id			= $user_id;
		
		if( $cv_setting->save() ){
			$sql = " DELETE FROM ".TBL_CV_CAT. " WHERE cv_id=".(int)$id;
			$db->query( $sql );

			if( sizeof($_POST['category']) != 0 && isset($_POST['category'])){
				foreach ( $_POST['category'] as $key => $value ):
					if( isset($value) && $value != "" ){
						$sql = " INSERT INTO ".TBL_CV_CAT. " ( cv_id, category_id ) VALUES ( ". (int)$cv_id . ", ".(int)$value.") ";
						$db->query( $sql );
					}
				endforeach;
			}
						
			destroy_my_session();
			
			
			$message ="<div class='success'>";
			if($cv_status == 'private')	: $message .= format_lang('cv','cv_info_1');
			else : $message .= format_lang('cv','cv_info_2'); endif;
			$message .="</div>";
			
			$message2 ="<div class='success'>CV Visibility is set to public<br />
							  This CV is currently set to <strong>PUBLIC</strong> and is 
							  <strong>SEARCHABLE</strong> by employers.</div>";
					   
			$session->message( $message );
			redirect_to( BASE_URL."curriculum_vitae/" );
		}else{
			$message = "<div class='error'> 
							".format_lang('following_errors')."
						<ul> <li />";
			$message .= join(" <li /> ", $cv_setting->errors );
			$message .= " </ul> 
						</div>";
		}
	
	//if button is not press	
	}else{
		$cv_details = $cv_setting->cv_review_by_employee();

		if( !$cv_details && !is_array($cv_details) ){
			$session->message("<div class='error'>".format_lang("error",'cv_not_found')."</div>");
			redirect_to(BASE_URL . 'curriculum_vitae/');
			exit;
		}
		
		$_SESSION['resume']['status'] 	= $cv_status	= strtolower($cv_details->cv_status);
		$_SESSION['resume']['exper'] 	= $exper 		= $cv_details->year_experience;
		$_SESSION['resume']['educ'] 	= $educ		= $cv_details->highest_education;
		$_SESSION['resume']['salary'] 	= $salary 	= trim($cv_details->salary_range);
		$_SESSION['resume']['availabe'] = $availabe 	= $cv_details->availability;
		$str_date 	= $cv_details->start_date;
		if( $cv_details->start_date != "0000-00-00 00:00:00" && $cv_details->start_date != NULL){
			$_SESSION['resume']['str_date_d'] =$str_date_d	= date("d",strtotime($str_date));
			$_SESSION['resume']['str_date_m'] =$str_date_m	= date("m",strtotime($str_date));
			$_SESSION['resume']['str_date_y'] =$str_date_y	= date("Y",strtotime($str_date));
			$smarty->assign( 'defult_date', $str_date_y."-".$str_date_m."-".$str_date_d );
		}
		$_SESSION['resume']['position'] = $position	= $cv_details->positions;
		//recent job details
		$_SESSION['resume']['rjt'] 		= $rjt 		= $cv_details->recent_job_title;
		$_SESSION['resume']['re'] 		= $re			= $cv_details->recent_employer;
		$_SESSION['resume']['riw'] 		= $riw		= $cv_details->recent_industry_work;
		$_SESSION['resume']['rcl'] 		= $rcl		= $cv_details->recent_career_level;
		
		//what are you looking for
		$_SESSION['resume']['ljt'] =$ljt		= $cv_details->look_job_title;
		$_SESSION['resume']['ljt2'] =$ljt2		= $cv_details->look_job_title2;
		
		$sql = " SELECT * FROM ".TBL_CV_CAT. " WHERE cv_id=".$id;
		$cv_cat = $db->query( $sql );
		$cv_cat_array = array();
		while ($row = $db->fetch_object( $cv_cat ) ) {
		  	$cv_cat_array[] = $row->category_id;
		}
		$_SESSION['resume']['cat'] = $cv_cat_array;
		$smarty->assign( 'category_selected', $cv_cat_array );
		
		
		$_SESSION['resume']['ljs'] =$ljs		= $cv_details->look_job_status;
		$_SESSION['resume']['job_type'] = $job_type = $cv_details->look_job_type;
		
		//where do you wont to work
		$_SESSION['loc']['citycode'] = $cv_details->city;
		$_SESSION['loc']['countycode'] = $cv_details->county;
		$_SESSION['loc']['stateprovince'] = $cv_details->state_province;
		$_SESSION['loc']['country'] = $cv_details->country;

	//location where he like to work in
	$default_county = empty($_SESSION['loc']['country']) ? DEFAULT_COUNTRY : $_SESSION['loc']['country'];
	$_SESSION['loc']['country'] = $countrycode = $default_county = !empty( $default_county ) ? $default_county : "GB";
	
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
	
	$lang['states'] = $state->get_stateOptions( $countrycode, 'Y' );

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
		
		$_SESSION['resume']['aya'] =$aya		= $cv_details->are_you_auth;
		$_SESSION['resume']['wtr'] =$wtr		= $cv_details->willing_to_relocate;
		$_SESSION['resume']['wtt'] =$wtt		= $cv_details->willing_to_travel;
		$_SESSION['resume']['notes'] =$notes		= $cv_details->additional_notes;
	}




$smarty->assign( 'authorised_to_work', format_lang("select","authorised_to_work") );
$smarty->assign( 'willing_to_travel', format_lang("select","willing_to_travel") );
$smarty->assign( 'salary', format_lang("select","salary") );
$smarty->assign( 'NoYes', format_lang('select', 'NoYes' ) );
$smarty->assign( 'month', format_lang("select","month") );
$smarty->assign( 'id', $id );
$smarty->assign( 'select_text', format_lang('select_text') );
	
$html_title 		= SITE_NAME . " - " .format_lang('page_title','cvfor').chr(10). $employee->full_name();
$smarty->assign( 'message', $message );	
$smarty->assign('lang', $lang);
$smarty->assign('rendered_page', $smarty->fetch('resume_change.tpl') );
?>