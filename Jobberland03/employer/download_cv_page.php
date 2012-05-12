<?php  $_SESSION['direct_to_emp'] = "review_cv/"; 	
	 include_once('sessioninc.php');
	 destroy_my_session();
	$id=$_GET['id'];

if( !isset($id) || empty($id) ){ redirect_to(BASE_URL."employer/account/");  }

	$username = $session->get_username();
	$user_id = $session->get_user_id();
	$country_code = DEFAULT_COUNTRY;
	
	$cv_setting = new CVSetting();	
	$employee_id = $_GET['u'];
	$cv_setting->id = $id;
	$cv_setting->fk_employee_id = $employee_id;

	$already_view = $cv_setting->already_view_cv( $user_id , $id );
	if( !$already_view ){
		$employer = new Employer;
		$employer->username = $username;
		$total_cv	= $employer->total_cv();
		define('TEMP_TOTAL_CV', $total_cv);
		if ( FREE_SITE == "N" ){	
			if( $total_cv <= 0 ){
				$session->message("<div class='error'>".format_lang('error','cv_zero')."</div>");
				redirect_to(BASE_URL."employer/credits/");
				die;
			}
		}
		$employer->update_cvs();
		$cv_setting->save_cv_view( $user_id, 7 );
	}
	
if(isset($id) && $id != "" ) {
	$download = CVSetting::download_by_employer( $id, $employee_id );
	$file_name 		= $download->cv_file_name;
	$orginal_name 	= $download->original_name;
	$file_type		= $download->cv_file_type;
	$file_size		= $download->cv_file_size;
	$file_path		= $download->cv_file_path;
	
	$location = $file_path.$file_name;

	header("Content-Disposition: attachment; filename=\"".$orginal_name."\"");
	header("Content-length: $file_size");
	header("Content-type: $file_type");
	
	readfile( $location );
	exit;
}
?>