<?php $req = return_url();	
	$var_name = $req[1];
	
if ( APPLY_WITHOUT_LOGIN && APPLY_WITHOUT_LOGIN == 'N' && !$session->get_job_seeker() ){
	$session->message ("<div class='error'>".format_lang('errormsg', 07)."</div>");
	$_SESSION['direct_to'] = BASE_URL ."apply/".$var_name."/";
	include_once('sessioninc.php');
}

//check for job
$job = new Job();
$jobs = $job->find_by_var_name_active( $var_name );
if( $jobs )
{
	$employer = Employer::find_by_id( $jobs->fk_employer_id );
	$company_name =  !empty($jobs->company_name) ? $jobs->company_name  : $employer->company_name;
	
	$job_id = $jobs->id;
	
	$job_description = strip_html ($jobs->job_description);
	$job_description = subtrack_string( $job_description, 800 );
	
	$city = City::find_by_code( $jobs->country, $jobs->state_province, $jobs->county, $jobs->city );
	$city_name = ($city) ? $city->name : $jobs->city;
	
	$smarty->assign('jobs', $jobs );
	$var_name = $jobs->var_name;
	
	$smarty->assign('var_name', 		$jobs->var_name );
	$smarty->assign('job_ref', 			strip_html ($jobs->job_ref) );
	$smarty->assign('job_title', 		strip_html ($jobs->job_title) );
	$smarty->assign('job_description', 	$job_description );
	$smarty->assign('location', 		$city_name );
	$smarty->assign('company_name', 	$company_name );
	$smarty->assign('contact_name', 	$jobs->contact_name );
	$smarty->assign('start_date', 		!empty($jobs->start_date) ? strftime(DATE_FORMAT, strtotime($jobs->start_date) ) : '' );
	
	$smarty->assign('created_at', 		strftime(DATE_FORMAT, strtotime($jobs->created_at) ) );

$html_title 		= SITE_NAME . " - ".format_lang('page_title', 'apply')." ".strip_html($jobs->job_title);
$meta_description 	= seo_words( subtrack_string($jobs->job_description, 150 ) );
$meta_keywords 		= seo_words( subtrack_string($jobs->job_description, 150 ) );
//end of job details //

	///setting fields
	$working_status_select_bx = format_lang ( 'select', "working_status");
	$smarty->assign( 'working_status', $working_status_select_bx );	

	$notice_select_bx = format_lang ( 'select',"notice");
	$smarty->assign( 'notice', $notice_select_bx );	

	$salary_select_bx = format_lang ( 'select',"salary");
	$smarty->assign( 'salary', $salary_select_bx );	
	
	$willing_to_travel_bx = format_lang ( 'select',"far_travel_work");
	$smarty->assign( 'willing_to_travel', $willing_to_travel_bx );	

//when button is press
if ( isset($_POST['submit']) ){
	
	$_SESSION['apply']['email'] 		=  $email = safe_output( $_POST['txt_email1'] );
	$_SESSION['apply']['work_status'] 	= $working_status = safe_output( $_POST['txt_working_status'] );
	///covering letter
	$_SESSION['apply']['which_letter'] 	= $_POST['txt_which_letter'];
	$_SESSION['apply']['cover_letter'] 	= $letter = empty($_POST['txt_letter']) ? "" : safe_output( $_POST['txt_letter'] );
	$_SESSION['apply']['which_cv'] 	= $_POST['txt_existed_cv'];
	
	///To further your application you may also wish to complete the following optional questions
	$_SESSION['apply']['fname'] 		= $fname = safe_output($_POST['txt_fname']);		
	$_SESSION['apply']['sname'] 		= $sname  = safe_output($_POST['txt_sname']);
	$full_name = $fname . " ".$sname;
	
	$_SESSION['apply']['address'] 		= $address = safe_output($_POST['txt_address']) ;				
	$_SESSION['apply']['home_tel'] 		= $htel = safe_output($_POST['txt_tel']);
	$_SESSION['apply']['mob_tel'] 		= $mtel = safe_output($_POST['txt_mob']);
	$_SESSION['apply']['notice'] 		= $notice = safe_output($_POST['txt_notice']);
	$_SESSION['apply']['salary'] 		= $salary = safe_output($_POST['txt_salary']);
	$_SESSION['apply']['willing_to_travel'] = $txt_willing_to_travel = safe_output($_POST['txt_willing_to_travel']);
	//end
		
	$error = array();
	$message = "";
	if(empty($email)){
		$error[] = format_lang('error','email');
	}
	if(!empty($email)){
		if( !check_email($email) ){
			$error[] = format_lang('error', 'incorrect_format_email');//"Invalid Email address e.g user@domain.com/co.uk/net";
		}
	}
	
	if( empty( $working_status ) ){
		$error[] = format_lang('error','select_work_status');
	}
//cv
$_SESSION['apply']['txt_cv_field']  = $txt_cv_field = $_POST['txt_cv_field'];
if ( trim($_POST['txt_cv_field']) == '' ||  strlen($_POST['txt_cv_field']) < 200 ){
	$txt_cv_field = "";
	$_SESSION['apply']['txt_cv_field']="";
	if( empty($_POST['txt_existed_cv']) && $_POST['txt_existed_cv'] == "" ){
		$file = array();
		$file =  $_FILES['txt_cv'];
		
		if($file['error'] != 0) {
			$error[] = $upload_errors[$file['error']];
		}
		
		if($file['size'] > $_POST['MAX_CV_FILESIZE'] ) {
			$error[] = format_lang('error', 'cv_upload_size');
		}
		
		if($file['error'] == 0) {
			$ext = end(explode(".", basename($file['name']) ));
			$ext = strtolower($ext);
			$allowed_exe = split(",",ALLOWED_FILETYPES_DOC);
			
			if( !in_array( $ext,$allowed_exe ) ){
				$error[] = format_lang('error','file_not_allowed')." ".basename($file['name']);
			}
		}
		
	}else{
		$user_id = $session->get_user_id();
		$_SESSION['apply']['cv_selected'] = $cv_selected = $_POST['txt_existed_cv'];
		$cv_setting = new CVSetting();
		$cv_setting->id = $cv_selected;
		$cv_setting->fk_employee_id = $user_id;
		$cv_info = $cv_setting->cv_review_by_employee();
		
		$cv = array();
		$cv['name'] 	=  $cv_info->cv_title;
		$target = $cv_info->cv_file_path . $cv_info->cv_file_name;
		$cv['tmp_name'] = $target;
		$cv['type'] 	= $cv_info->cv_file_type;
		$cv['size'] 	= $cv_info->cv_file_size;
	}
}
//end
		
	if( !$session->get_job_seeker() 
		&& ENABLE_SPAM_APPLY_JOB && ENABLE_SPAM_APPLY_JOB == 'Y' ){
			 if ( (strtolower($_POST['spam_code']) != strtolower($_SESSION['spam_code']) || 
		  		( !isset($_SESSION['spam_code']) || $_SESSION['spam_code'] == NULL ) ) )  {
					$error[] = get_lang('error','spam_wrong_word');
					//$errors[] = "The security code you entered does not match the image. Please try again.";
				}
	}
	
	if( sizeof($error) == 0 ){
		//all ok
		$filename   = basename($file['name']);

	###################################################	
		if( empty($_POST['txt_existed_cv']) && $_POST['txt_existed_cv'] == "" ){
			$cv = array();
			$cv = $file;
			$filename   = basename($file['name']);
		}
		
		   /* if user login add apply details to database */
			if( $session->get_job_seeker() ){
				$history = new JobHistory();
				$cv_name	= $cv['name'];
				$history->fk_employee_id = $user_id;
				$history->fk_job_id = $job_id;
				$history->cv_name = $cv_name;
				$history->cover_letter = $letter;
				$history->date_apply = strftime(" %Y-%m-%d %H:%M:%S ", time() );
				 
				if( $history->save() ){
					//$job->update_apply();
				}else{
					//$employee['email_address'] = $_POST['txt_email1'];
				}
			}

############################### APPLY_CANDIDATE #########################################
		$email_template = get_lang('email_template','apply_employee' );
		
		$subject= str_replace("#SiteName#", SITE_NAME, $email_template['email_subject']);
		$subject= str_replace("#JobTitle#", $jobs->job_title, $subject);
		$subject= str_replace("#JobRef#", 	$jobs->job_ref, $subject);
		
		$body = $email_template['email_text'];
		
		$body = str_replace("#CoverLetter#",$letter, $body);
		$body = str_replace("#CompanyName#",$employer->company_name , $body );
		$body = str_replace("#JobDetails#", $jobs->job_details() , $body );
		$body = str_replace("#PostEmail#", 	$jobs->poster_email , $body );
		$body = str_replace("#Domain#", 	$_SERVER['HTTP_HOST'], $body );
		$body = str_replace("#ContactUs#", 	ADMIN_EMAIL, $body );
		$body = str_replace("#SiteName#", 	SITE_NAME, $body );

		$body = str_replace("#UserEmail#", 	$email, $body);
		$body = str_replace("#WorkStatus#", $working_status, $body);		
		$body = str_replace("#FName#", 		$fname, $body );
		$body = str_replace("#Surname#", 	$sname, $body );
		$body = str_replace("#Address#", 	nl2br($address), $body );
		$body = str_replace("#HomeTel#", 	$htel, $body );
		$body = str_replace("#Mobile#", 	$mtel, $body );
		$body = str_replace("#Notic#", 		$notice, $body );
		$body = str_replace("#Salary#", 	$salary, $body );
		$body = str_replace("#Travel#", 	$txt_willing_to_travel, $body );
		
		if($txt_cv_field != "" ){
			$body = str_replace("#cv_field#", 	$txt_cv_field, $body );
		}
		
		
		$to 	= array("email" => $email, "name" => $full_name );
		$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME );
		
		$mail = send_mail( $body, $subject, $to, $from, $cv, null );
		unset($email_tem,  $body, $subject, $to, $from, $email_template );
############################### END_CANDIDATE #########################################

############################### APPLY_CANDIDATE #########################################
		$email_template = get_lang('email_template','apply_employer' );
		
		$subject = str_replace("#SiteName#",SITE_NAME, $email_template['email_subject']);
		$subject = str_replace("#JobTitle#",$jobs->job_title, $subject);
		$subject = str_replace("#JobRef#", 	$jobs->job_ref, $subject);
		
		$body = $email_template['email_text'];
		$body = str_replace("#ApplicantName#",	$full_name, $body );
		//$body = str_replace("#UserEmail#", 	$email, $body);
		$body = str_replace("#SiteName#", 		SITE_NAME, $body );
		$body = str_replace("#JobTitle#", 		$jobs->job_title, $body);
		$body = str_replace("#JobDetails#", 	$jobs->job_details(), $body );
		//$body = str_replace("#WorkStatus#", 	$working_status, $body);
		$body = str_replace("#CoverLetter#", 	$letter, $body);
		$body = str_replace("#Domain#", 		$_SERVER['HTTP_HOST'], $body );
		//$body = str_replace("#Message#", 		$message, $body);
		
		$body = str_replace("#UserEmail#", 	$email, $body);
		$body = str_replace("#WorkStatus#", $working_status, $body);		
		$body = str_replace("#FName#", 		$fname, $body );
		$body = str_replace("#Surname#", 	$sname, $body );
		$body = str_replace("#Address#", 	nl2br($address), $body );
		$body = str_replace("#HomeTel#", 	$htel, $body );
		$body = str_replace("#Mobile#", 	$mtel, $body );
		$body = str_replace("#Notic#", 		$notice, $body );
		$body = str_replace("#Salary#", 	$salary, $body );
		$body = str_replace("#Travel#", 	$txt_willing_to_travel, $body );
		
		$to 	= array("email" => $jobs->poster_email, "name" => $jobs->contact_name );
		$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME);
		$mail2 = send_mail( $body, $subject, $to, $from, $cv, "" );
		unset($email_tem,  $body, $subject, $to, $from, $message );
############################### END_CANDIDATE #########################################

		$jobs->update_apply();
		//die;
		if( $mail && $mail2
			){
				destroy_my_session();
				$session->message ("<div class='success'>".format_lang('success','apply_success')."</div>");
				//destroy_my_session();
				//if( $session->get_job_seeker() ){ redirect_to( BASE_URL."applications/" ); }
			redirect_to( BASE_URL."apply_suggestion/".$var_name."/" );
			die;
		}else{
			$message = "<div class='error'>".format_lang('error','apply_problem_pro_app')."</div>";
		}
	}
	else{
		$message = "<div class='error'> 
						".format_lang('following_errors')."
					<ul> <li />";
		$message .= join(" <li /> ", $error);
		
		$message .= " </ul> 
				   </div>";
		
		$session->message ( $message );
	}
	
	redirect_to( BASE_URL."apply/".$var_name."/" );
}

//if user logged in 
if( $session->get_job_seeker() ){
	
	$user_id = $session->get_user_id();
	$user = Employee::find_by_id( $user_id );
	$employee =& $user;
	
	$username 	= $session->get_username();
	$full_name = $user->full_name();

	$_SESSION['apply']['email'] = !empty($_POST['txt_email']) ? $_POST['txt_email'] : $user->email_address;
	$_SESSION['apply']['work_status'] 	= $working_status = safe_output( $_POST['txt_working_status'] );

	///To further your application you may also wish to complete the following optional questions
	$_SESSION['apply']['fname'] = $fname = !empty($_POST['txt_fname']) ? $_POST['txt_fname'] : $user->fname;
	$_SESSION['apply']['sname'] = $sname = !empty($_POST['txt_sname']) ? $_POST['txt_sname'] : $user->sname;
	$full_name = $fname . " ".$sname;

	$address 	= !empty($_POST['txt_address']) ? $_POST['txt_address'] :$user->address();
	$_SESSION['apply']['address']= str_replace(":", "\n", $address); 

	$_SESSION['apply']['home_tel'] = !empty($_POST['txt_tel']) ? $_POST['txt_tel'] : $user->phone_number;
	$_SESSION['apply']['mob_tel'] = !empty($_POST['txt_mob']) ? $_POST['txt_mob'] : $user->phone_number;

	$job_history = JobHistory::check_user_already_apply( $job_id,  $user_id );
		
	if( $job_history && isset($job_history) ){
		$message = empty($message)?"<div class='error'>".format_lang('error','already_apply')." ".strftime(DATE_FORMAT, strtotime($jobs->created_at) )."</div>":$message;
	}
	
	$letter="";
	
	//get all my cv
	$my_cvs = CVSetting::employee_find_all($user_id);
	if ( is_array($my_cvs) and !empty($my_cvs) ) {
		$cv_t = array();
		$i=1;
		foreach( $my_cvs as $my_cv ):
			if( $my_cv->default_cv == 'Y' )
			{
				$_SESSION['apply']['cv_selected'] = $my_cv->id;
			}
				$cv_t[$i]["id"]  		= $my_cv->id;
				$cv_t[$i]["cv_title"]  	= $my_cv->cv_title;
				$cv_t[$i]["default_cv"]  = empty($_SESSION['apply']['which_cv']) ? "N":$my_cv->default_cv;
				$i++;
		endforeach; 
		$smarty->assign( 'my_cv', $cv_t );
	}
	
	//get all coving letter
	$my_letters = CovingLetter::employee_find_all($user_id);	
	if ( is_array($my_letters) and !empty($my_letters) ) {
		$cl_t = array();
		$i=1;
		foreach( $my_letters as $my_letter ):
			if( $my_letter->is_defult == 'Y' )
			{
				$_SESSION['apply']['cover_letter'] = empty($_SESSION['apply']['cover_letter']) ? $my_letter->cl_text : safe_output( $_SESSION['apply']['cover_letter'] );
			}
				$cl_t[$i]["id"]  		= $my_letter->id;
				$cl_t[$i]["cl_title"]  	= $my_letter->cl_title;
				$cl_t[$i]["cl_text"]  	= $my_letter->cl_text;
				$cl_t[$i]["is_defult"]  = empty($_SESSION['apply']['which_letter']) ? 'N' : $my_letter->is_defult;
				$i++;
		endforeach; 
		$smarty->assign( 'my_letters', $cl_t );
	}
}
//end of logged in user



}else{
	//$message = "<div class='error'>Invalid URL Request</div>";
}
///end
	

$smarty->assign( 'cv_max_size', size_as_text( MAX_CV_SIZE ) );
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('apply.tpl') );
?>