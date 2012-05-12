<?php  	/** if user already logged in take them to index page */
if( $session->get_recuriter() ){
		redirect_to(BASE_URL."employer/account/");
		die;
}
	
if( isset($_POST['bt_resend']) ){
	$email = safe_output( $_POST['txtresend'] );
	
	if( empty($email) || !check_email($email) )
	{
		$message = "<div class='error'>".format_lang("error",'email')."</div>";
	}
	
	elseif ( ENABLE_SPAM_RSC && ENABLE_SPAM_RSC == 'Y' ){
		if ( (strtolower($_POST['spam_code']) != strtolower($_SESSION['spam_code']) || 
		  	( !isset($_SESSION['spam_code']) || $_SESSION['spam_code'] == NULL ) ) )  {
			$message = "<div class='error'>".format_lang('error','spam_wrong_word')."</div>";
		}
	}
	
	else{
		
		$employer = Employer::find_by_email( $email );
		if( $employer->is_active == "Y" ){
			$session->message ("<div class='error'>".format_lang('errormsg', 60)."</div>");
			redirect_to( BASE_URL. "employer/login/" );
			exit;
		}
		else{	
			// if found 
			 if( $employer ){
				$reg_email 	= $employer->email_address;
				$reg_key	= $employer->actkey;
				$username 	= $employer->username;
								
				// generate the verication code 
				$reg_pass = $new_pass = create_new_password();
				$password_change = Employer::change_password( $username, $new_pass );
				
				if ($password_change){
					$email_template = get_lang('email_template', 'employer_signup');
					$subject 	= str_replace("#SiteName#", SITE_NAME, $email_template['email_subject']);
					
					$body = $email_template['email_text'];
					if( REG_CONFIRMATION == "N" ){
						//reg_key
						$reg_confirmation = $lang['email_template']['reg_confirmation'];
						$body = str_replace("#Message#", $reg_confirmation, $body );
					}
				
					$body = str_replace("#Password#", 	$reg_pass, $body);
					$body = str_replace("#Link#", 		BASE_URL."employer/", $body);
					$body = str_replace("#FullName#", 	$employer->full_name(), $body );
					$body = str_replace("#UserId#", 	$employer->username, $body );
					$body = str_replace("#Domain#", 	$_SERVER['HTTP_HOST'], $body );
					$body = str_replace("#ContactUs#", 	ADMIN_EMAIL, $body );
					$body = str_replace("#Message#", 	"", $body );
					$body = str_replace("#SiteName#", 	SITE_NAME, $body);
					$body = str_replace("#RegKey#", 	$reg_key, $body);
					
					$to 	= array("email" => $reg_email, "name" => $employer->full_name() );
					$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME );
					$mail = send_mail( $body, $subject, $to, $from, "", "" );
				
					if($mail){
						$session->message ("<div class='success'>".format_lang('success','rc_confirm')."</div>");
					}else{
						$session->message ("<div class='error'>".format_lang('errormsg',59)."</div>");
					}
				}else{
					$session->message ("<div class='error'>".format_lang('errormsg',53)."</div>");
				}
			 }
			 else{
				$session->message ("<div class='success'>".format_lang('success','rc_confirm')."</div>");
			 }
			 	redirect_to( BASE_URL."employer/confirmreg/" );
				exit;
		}
	}
}

	$html_title = SITE_NAME . " - ".format_lang('page_title','Resendconfemail');
	
	$smarty->assign('lang', $lang);
	$smarty->assign( 'message', $message );	
	$smarty->assign('rendered_page', $smarty->fetch('employer/resend_conflink.tpl') );
?>