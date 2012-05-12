<?php 
	/** if user already logged in take them to index page */
	if( $session->get_recuriter() ){
		redirect_to(BASE_URL."employer/account/");
		die;
	}

	if ( !isset($_GET['error']) ) unset($_SESSION['direct_to_emp']);


/** login */
if( isset($_POST['bt_login']) ){
	$username 	= trim($_POST['useranme_txt']);
	$pass 		= trim($_POST['pass_txt']);
	
	$errors=array();
	
	if( $username == "" || $pass == "" ){
		$errors[] = format_lang ( 'error', 'empty_user_pass' );
	}if ( ENABLE_SPAM_LOGIN && ENABLE_SPAM_LOGIN == 'Y' ){
		if ( ( strtolower($_POST['spam_code']) != strtolower($_SESSION['spam_code']) || 
		( !isset($_SESSION['spam_code']) || $_SESSION['spam_code'] == NULL ) ) )  {
			$errors[] = format_lang('error', 'spam_wrong_word');
		}
	}
	if(sizeof($errors) == 0 ){
		$user_found = Employer::authenticate( $username, $pass );
		//print_r($user_found);
		//die;
		
		if( $user_found )
		{
			//check employee status
			if($user_found->employer_status == 'pending' ){
				$message = "<div class='error'>".format_lang('error', 'approve_account')."</div>";
			}
			elseif($user_found->employer_status == 'deleted' ){
				$message = "<div class='error'>".format_lang('error', 'status_deleted_account')."</div>";
			}
			elseif($user_found->employer_status == 'suspended' ){
				$message = "<div class='error'>".format_lang('error', 'status_suspended_account')."</div>";
			}
			elseif($user_found->employer_status == 'declined' ){
				$message = "<div class='error'>".format_lang('error', 'status_declined_account')."</div>";
			}
			else{
				//if( $user_found->is_active == 'Y' ) {
					$access = "Recuriter";
					$session->login ( $user_found, $access );
					if( $_SESSION['direct_to_emp'] != "" ){
						$page = $_SESSION['direct_to_emp'];
						unset($_SESSION['direct_to_emp']);
						redirect_to(BASE_URL."employer/".$page);
						die;
					}else{
						redirect_to(BASE_URL."employer/account/");
						die;
					}
				//}else{
				//	$session->message ("<div class='error'>Your account is not active, 
				//						Please active your account</div>");
				//}
			}
			
			$session->message ( $message );
			redirect_to ( BASE_URL. "employer/login/" );
		}else{
			$message = "<div class='error'>Incorrect username or password.</div>";
		}
	}
	else{
		$message = "<div class='error'><ul style='margin:0; padding:0; list-style:none;'>";
			$message .= join(" <li /> ", $errors );
			$message .= " </ul> </div>";
	}
}
	
	/** end here **/
$html_title 		= SITE_NAME . " - ".format_lang('page_title', 'login');
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('employer/login.tpl') );
?>