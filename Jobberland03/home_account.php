<?php
	include_once("layout/search_inc.php");

 destroy_my_session();
 
$username = $session->get_username();
$user_id = $session->get_user_id();
	
//my profile
$employee = Employee::find_by_id( $user_id );
$smarty->assign( 'full_name', $employee->full_name() );
$address = split( ":",$employee->address() );
$smarty->assign( 'address', join( "<br />", $address ) );

//$smarty->assign( 'employee', $employee);
//$smarty->assign( 'employee', $employee);

///cv
//list of cover letter
//$my_cvs = CVSetting::employee_find_all($user_id);
$mySingleCV = CVSetting::employee_find_public_cv($user_id);
if ( !empty($mySingleCV) ) {
	$cvid  		= $mySingleCV->id;
	$smarty->assign( 'cvid', $cvid );	
	$cv_status  = $mySingleCV->cv_status;
	$smarty->assign( 'cv_status', $cv_status );
	$cvno_views = $mySingleCV->no_views;
	$smarty->assign( 'cvno_views', $cvno_views );
	$cv_title  	= $mySingleCV->cv_title;
	$smarty->assign( 'cv_title', $cv_title );
	$cvmodified_at = strftime(DATE_FORMAT, strtotime($mySingleCV->modified_at) );
	$smarty->assign( 'cvmodified_at', $cvmodified_at );
	$smarty->assign( 'mySingleCV', $mySingleCV );

$cvjob_title = $mySingleCV->look_job_title;
$cvjob_title2 = $mySingleCV->look_job_title2;
$cvjob_city	   = $mySingleCV->city;
$cvjob_county  = $mySingleCV->county;
$cvjob_state   = $mySingleCV->state_province;
$cvjob_country = $mySingleCV->country;
$cvrecommand_status  = $mySingleCV->cv_status;

}else{
	$my_cvs = CVSetting::employee_find_all($user_id);
	if ( !empty($my_cvs) ) {
		$cv_t = array();
		$i=1;
		foreach( $my_cvs as $my_cv ):
				$cv_t[$i]["id"]  			= $my_cv->id;
				$cv_t[$i]["fk_employee_id"] = $my_cv->fk_employee_id;
				$cv_t[$i]["cv_title"]  		= $my_cv->cv_title;
				$cv_t[$i]["cv_status"]  	= $my_cv->cv_status;
				$cv_t[$i]["no_views"]  		= $my_cv->no_views;
				$cv_t[$i]["created_at"]  	= strftime(DATE_FORMAT, strtotime($my_cv->created_at) );
				$cv_t[$i]["modified_at"]  	= strftime(DATE_FORMAT, strtotime($my_cv->modified_at) );
				$cv_t[$i]["default_cv"]  	= $my_cv->default_cv;
				$i++;
		endforeach;
		$smarty->assign( 'my_cvs', $cv_t );
	}else{
		
		/**
		CV Status: No CV uploaded
		Help Store your CV on Jobsite now, and applying for jobs will only take seconds.
		You can also distribute your CV to hundreds of relevant recruiters at the touch of a button.
		
		Click here to:
		**/

	}
}

//recommendedJob
//View All Recommended Jobs
if( strtolower($cvrecommand_status) == "public" ){
	global $cvjob_title, $cvjob_title2, $cvjob_city, $cvjob_county, $cvjob_state, $cvjob_country;
	
	$smarty->assign( 'cvJob_city', $cvjob_city );
	$smarty->assign( 'cvJob_title', $cvjob_title );
	
	$recommendedJobs = Job::recommendedJob($user_id, $cvjob_title, $cvjob_title2, 
											$cvjob_city, $cvjob_county, $cvjob_state, $cvjob_country );
	
	if( $recommendedJobs ){
		$smarty->assign( 'recommendedJobs', $recommendedJobs );	
	}
}else{
	
	$cv_not_set_to_public = format_lang('error','');
	$smarty->assign( 'cv_not_set_to_public', $cv_not_set_to_public );
}

//history
$my_apps = JobHistory::home_application_history( $user_id );
if ( !empty( $my_apps ) ){	
	$smarty->assign( 'application', $my_apps );		
}

	
	$smarty->assign( 'message', $message );	
	$smarty->assign('rendered_page', $smarty->fetch('home_account.tpl') );
?>