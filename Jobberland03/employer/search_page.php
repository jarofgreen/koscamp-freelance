<?php  $_SESSION['direct_to_emp'] = "search/"; 	
	 include_once('sessioninc.php');

if( isset($_GET['bt_search'])){
	$query = "";
	foreach( $_REQUEST as $key => $data){
		//$data = trim($data);
		if( !empty($data) && $data != "" && $key != "page" && $key != "bt_search" && $key != "PHPSESSID"){
			if( is_array( $_GET[$key] ) ){
				foreach( $_GET[$key] as $key2 => $data2){
					$query .= "&".$key."[]=".$data2;
				}
			}else{
				$query .= "&".$key."=".$data;
			}
		}
	}
	
	$query = substr_replace($query, '', 0, 1);
	redirect_to(BASE_URL . 'employer/search_result/?'.$query);
	exit;
}

	$username = $session->get_username();
	$user_id = $session->get_user_id();
	$country_code = DEFAULT_COUNTRY;
	$employer = Employer::find_by_id( $user_id );
	$total_cv = $employer->total_cv();

	
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


//location///
	$default_county = empty($_SESSION['loc']['country']) ? DEFAULT_COUNTRY : $_SESSION['loc']['country'];
	$_SESSION['loc']['country'] = $countrycode = $default_county = $default_county;
	
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

$smarty->assign( 'salary', format_lang("select","salary") );
$smarty->assign( 'select_text', format_lang('select_text') );
$html_title 		= SITE_NAME . " - Search ";
$smarty->assign('dont_include_left', true);
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );
$smarty->assign('rendered_page', $smarty->fetch('employer/search.tpl') );	
?>