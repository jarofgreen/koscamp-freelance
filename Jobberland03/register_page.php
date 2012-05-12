<?php  
	/** if user already logged in take them to index page */
	if( $session->get_job_seeker() ){
		redirect_to(BASE_URL."account/");
		die;
	}
	
	if( !$_POST && empty($_POST) ) {destroy_my_session();}
	
	//unset($_SESSION['reg']);

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

############## when post button is press ######################
	if( isset($_POST['bt_register']) ){
		global $employee;
		$employee = new Employee();
		$_SESSION['reg']['username'] = $employee->username 		= $reg_username 	= $_POST['reg_username'];
		$_SESSION['reg']['email'] 	= $employee->email_address 	= $reg_email 		= $_POST['reg_email'];
		$_SESSION['reg']['pass']  	= $employee->passwd 		= $reg_pass 		= $_POST['reg_pass'];
									  $employee->confirm_passwd = $reg_confirm_pass = $_POST['reg_confirm_pass'];
		$_SESSION['reg']['fname'] 	= $employee->fname 			= $reg_fname 		= $_POST['reg_fname'];
		$_SESSION['reg']['sname'] 	= $employee->sname 			= $reg_sname		= $_POST['reg_sname'];
									  $employee->actkey			= $reg_key 			= md5( session_id().time() );
									  
		$employee->city				= $_SESSION['loc']['citycode'] 					= $_POST['txtcity'];
		$employee->county			= $_SESSION['loc']['countycode']				= $_POST['txtcounty'];
		$employee->state_province	= $_SESSION['loc']['stateprovince']				= $_POST['txtstateprovince'];
		$employee->country			= $_SESSION['loc']['country']					= $_POST['txt_country'];
		
		if( empty($_POST['txt_terms']) && $_POST['txt_terms'] == "" ){
			$employee->terms = 1;
		}
		
		if ( ENABLE_SPAM_REGISTER && ENABLE_SPAM_REGISTER == 'Y' ){
			
			 if ( (strtolower($_POST['spam_code']) != strtolower($_SESSION['spam_code']) || 
		  		( !isset($_SESSION['spam_code']) || $_SESSION['spam_code'] == NULL ) ) )  {
					$employee->CAPTCHA = false;
					//$_SESSION['CAPTCHA'] = false;
					//$errors[] = "The security code you entered does not match the image. Please try again.";
				}
		}
		
		
		if( $employee->save() ){
			$session->message ("<div class='success'>".format_lang('success','register_add')."</div>");
			destroy_my_session();
			
			$email_template = format_lang('email_template', 'employee_signup');
			$subject 	= str_replace("#SiteName#", SITE_NAME, $email_template['email_subject']);
			
			$body = $email_template['email_text'];
			if( REG_CONFIRMATION == "N" ){
				//reg_key
				$reg_confirmation = $lang['email_template']['reg_confirmation'];
				$body = str_replace("#Message#", $reg_confirmation, $body );
			}
			
			$body = str_replace("#Password#", 	$reg_pass, $body);
			$body = str_replace("#Link#", 		BASE_URL, $body);
			$body = str_replace("#FullName#", 	$employee->full_name(), $body );
			$body = str_replace("#UserId#", 	$employee->username, $body );
			$body = str_replace("#Domain#", 	$_SERVER['HTTP_HOST'], $body );
			$body = str_replace("#ContactUs#", 	ADMIN_EMAIL, $body );
			$body = str_replace("#Message#", 	"", $body );
			$body = str_replace("#SiteName#", 	SITE_NAME, $body);
			$body = str_replace("#RegKey#", 	$reg_key, $body);
			
			$to 	= array("email" => $reg_email, "name" => $employee->full_name() );
			$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME );
			$mail = send_mail( $body, $subject, $to, $from, "", "" );
			if( REG_CONFIRMATION == "N" ){
				redirect_to( BASE_URL."confirmreg/" );
				exit;
			}else{redirect_to( BASE_URL."register/" ); }
		}
		/** errors */
		else{
			$message = "<div class='error'> 
					".format_lang('following_errors')."
				<ul> <li />";
			$message .= join(" <li /> ", $employee->errors );
			$message .= " </ul> 
					</div>";
		}
	}else{
		$reg_username 		=  "";
		$reg_email 			=  "";
		$reg_pass 			=  "";
		$reg_confirm_pass 	=  "";
		$reg_fname 			=  "";
		$reg_sname			=  "";
	}

################ end ###################
	
	
	$html_title = SITE_NAME . " - ".format_lang('page_title', 'register');
	$smarty->assign('lang', $lang);
	$smarty->assign( 'message', $message );	
	$smarty->assign('rendered_page', $smarty->fetch('register.tpl') );
?>