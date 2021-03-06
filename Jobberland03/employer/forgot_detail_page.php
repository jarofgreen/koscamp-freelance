<?php 	/** if user already logged in take them to index page */
	if( $session->get_recuriter() ){
		redirect_to(BASE_URL."employer/account/");
		die;
	}

if( isset($_POST['bt_username']) || isset($_POST['bt_new_password']) ){
	/*** Email validation */
	$email = $_POST['txt_email'];
	
	if(empty($email)){
		$error[] = format_lang('error','email');
	}
	
	if(!empty($email)){
		if( !check_email($email) ){
			$error[] = format_lang('error','incorrect_format_email');
		}else{
			$email_found 	= Employer::check_email($email);
			if( !$email_found ){
				//$error[] = "Email address does not existed";
			}
		}
	}

	if (ENABLE_SPAM_FD && ENABLE_SPAM_FD == 'Y'  ){
		if ( (strtolower($_POST['spam_code']) != strtolower($_SESSION['spam_code']) || 
		  		( !isset($_SESSION['spam_code']) || $_SESSION['spam_code'] == NULL ) ) )  {
					$error[] = format_lang('error','spam_wrong_word');
					//$errors[] = "The security code you entered does not match the image. Please try again.";
		}
	}
	
	if( sizeof($error) == 0 ){
		/* get my username**/
		$employer = new Employer();
		$employer = Employer::find_by_email( $email );
		$url = BASE_URL."employer";
		
		if($employer){ 
			$username 	= $employer->username;
			$full_name 	= $employer->full_name();
		}
		//button
		if( isset($_POST['bt_username']) ){
		  		  
		  if($employer){ 
		  //forgot_username
			$email_template = get_lang('email_template', 'forgot_username');				

			$subject 	= str_replace("#SiteName#",SITE_NAME, $email_template['email_subject'] );
			
			$body = $email_template['email_text'];
			$body = str_replace("#FullName#", 	$full_name, $body );
			$body = str_replace("#SiteName#", 	SITE_NAME, $body);
			$body = str_replace("#UserId#", 	$username, $body );
			$body = str_replace("#Link#", 		$url , $body);
			$body = str_replace("#Domain#", 	$_SERVER['HTTP_HOST'], $body );
			
			$to 	= array("email" => $email , "name" => $full_name );
			$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME );			
			$mail = send_mail( $body, $subject, $to, $from, "", "" );
			
		  }
			$message = "<div class='success'>".format_lang('success','fd_username')."</div>";
		}
		/** end username */
		
		
		/*** password */
		if( isset($_POST['bt_new_password']) ){
			
			$new_pass = create_new_password();
			if($employer){
				$email_template = get_lang('email_template', 'reset_password');				
				$subject 	= str_replace("#SiteName#", SITE_NAME, $email_template['email_subject']);
				
				$body = $email_template['email_text'];
				$body = str_replace("#Password#", $new_pass, $body);
				$body = str_replace("#Link#", 		$url, $body);
				$body = str_replace("#FullName#", 	$full_name, $body );
				$body = str_replace("#UserId#", 	$username, $body );
				$body = str_replace("#Domain#", 	$_SERVER['HTTP_HOST'], $body );
				$body = str_replace("#SiteName#", 	SITE_NAME, $body);

				
				$to 	= array("email" => $email , "name" => $full_name );
				$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME );
				$mail = send_mail( $body, $subject, $to, $from, "", "" );
				
				$change_pass = Employer::forgot_password( $email, $new_pass );
			}
				$message ="<div class='success'>".format_lang('success','fd_password')."</div>";
		}
		/**end pass */

	}else{
		$message = "<div class='error'> 
						".format_lang('following_errors')."
					<ul> <li />";
		$message .= join(" <li /> ", $error);
		
		$message .= " </ul> 
				   </div>";
		//$message ($message);
	}
	$session->message( $message );
	redirect_to( BASE_URL."employer/forgot_details/" );
	die;
}

$html_title = SITE_NAME . " - ".format_lang('page_title','ForgotDetails');

$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('employer/forgot_detail.tpl') );
?>