<?php if( $session->get_recuriter() ){
	redirect_to(BASE_URL."employer/account/");
	die;
}

 if ( EMPLOYER_REG == "N" || EMPLOYER_REG == "0" || EMPLOYER_REG == false) {
	 $session->message ("<div class='error'>".format_lang('error','regNotAllowed')."</div>");
	 redirect_to(BASE_URL."employer/login/");
	die;
 }

if( isset($_POST['bt_register']) ){
	
	$employer = new Employer();
	
	$_SESSION['add_emp']['com_name'] =  $employer->company_name	 = $company_name 	= $_POST['txt_company_name'];
	
	$employer->var_name = $employer->mod_write_check ( $_POST['txt_company_name'], null );
	
	$_SESSION['add_emp']['contactName'] =  $employer->contact_name	 = $contact_name 	= $_POST['txt_contact_name'];
	$_SESSION['add_emp']['url'] =  $employer->site_link	 = $site = $_POST['txt_site'];
	$_SESSION['add_emp']['comDesc'] =$employer->company_desc=$company_desc= allowedTags( $_POST['txt_company_desc']);	
	$_SESSION['add_emp']['email'] =  $employer->email_address = $email 			= stripHTMLTags($_POST['txt_email']);
	$_SESSION['add_emp']['username'] =  $employer->username		 = $username 		= stripHTMLTags($_POST['txt_username']);
	$_SESSION['add_emp']['pass'] =  $employer->passwd		 = $pass 			= $_POST['txt_pass'];
	$_SESSION['add_emp']['confirmPass'] =  $employer->confirm_password	= $confirm_pass = $_POST['txt_confirm_pass'];
	$_SESSION['add_emp']['address'] =  $employer->address		= $address 			= $_POST['txt_address'];
	$_SESSION['add_emp']['address2'] =  $employer->address2		= $address2 		= $_POST['txt_address2'];

	$employer->city				= $_SESSION['loc']['citycode'] 					= $_POST['txtcity'];
	$employer->county			= $_SESSION['loc']['countycode']				= $_POST['txtcounty'];
	$employer->state_province	= $_SESSION['loc']['stateprovince']				= $_POST['txtstateprovince'];
	$employer->country			= $_SESSION['loc']['country']					= $_POST['txt_country'];
	
	$employer->actkey = $key = md5( time() );
	
	$_SESSION['add_emp']['pCode'] =  $employer->post_code	= $pcode 			= $_POST['txt_pcode'];
	$_SESSION['add_emp']['tel'] =  $employer->phone_number	= $tele =			$_POST['txt_tele'];
	
	if ( ENABLE_SPAM_REGISTER && ENABLE_SPAM_REGISTER == 'Y' ){
			
			 if ( strtolower($_POST['spam_code']) != strtolower($_SESSION['spam_code']) || 
		  		( !isset($_SESSION['spam_code']) || $_SESSION['spam_code'] == NULL ) )  {
					$employer->CAPTCHA = false;
					//$_SESSION['CAPTCHA'] = false;
					//$errors[] = "The security code you entered does not match the image. Please try again.";
			}
	}
		
	if( !empty($_POST['txt_terms']) && $_POST['txt_terms'] != "" ){
		$employer->terms = 1;
	}
	
	
	if( $_FILES['txt_logo']['error'] == 0 ) {
		$employer->attach_file( $_FILES['txt_logo'] );
	}
		
		if($employer->save()) {
			// Success
			$session->message ("<div class='success'>".format_lang("success", 'register_add')."</div>");
			unset($_SESSION['CAPTCHA'], $_SESSION['add_emp']);
			destroy_my_session();
			
			$email_template = get_lang('email_template', 'employer_signup');
			$subject 	= str_replace("#SiteName#", SITE_NAME, $email_template['email_subject']);
			
			$body = $email_template['email_text'];
			if( REG_CONFIRMATION == "N" ){
				//reg_key
				$reg_confirmation = $lang['email_template']['reg_confirmation'];
				$body = str_replace("#Message#", $reg_confirmation, $body );
			}
			
			$body = str_replace("#Password#", 	$pass, $body);
			$body = str_replace("#Link#", 		BASE_URL."employer/", $body);
			$body = str_replace("#FullName#", 	$employer->full_name(), $body );
			$body = str_replace("#UserId#", 	$employer->username, $body );
			$body = str_replace("#Domain#", 	$_SERVER['HTTP_HOST'], $body );
			$body = str_replace("#ContactUs#", 	ADMIN_EMAIL, $body );
			$body = str_replace("#Message#", 	"", $body );
			$body = str_replace("#SiteName#", 	SITE_NAME, $body);
			$body = str_replace("#RegKey#", 	$key, $body);
			
			$to 	= array("email" => $email, "name" => $employer->full_name() );
			$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME );
			$mail = send_mail( $body, $subject, $to, $from, "", "" );
			if( REG_CONFIRMATION == "N" ){
				redirect_to( BASE_URL."employer/confirmreg/" );
				exit;
			}else{redirect_to( BASE_URL."employer/register/" ); }

			//redirect_to('register.php');
		} else {
			// Failure
			$message = "<div class='error'> ".format_lang('following_errors')."
						<ul> <li />";
			$message .= join(" <li /> ", $employer->errors );
			$message .= " </ul> 
					   </div>";
			$session->message ( $message );				
		}
		redirect_to(BASE_URL.'employer/register/');
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

	
$smarty->assign( 'cv_max_size', size_as_text( MAX_CV_SIZE ) );
$smarty->assign( 'titles', get_lang ('select','titles') );
$html_title = SITE_NAME . " - ".format_lang('page_title','new_employer');
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('employer/register.tpl') );	
?>
