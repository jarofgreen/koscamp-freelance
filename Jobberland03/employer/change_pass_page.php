<?php $_SESSION['direct_to_emp'] = "account/change_password/"; 	
	 include_once('sessioninc.php');
	
	$username = $session->get_username();

if( isset( $_POST['bt_submit'] ) ){		
	$error= array();		
	$old_pass     = $_POST['txt_old_pass'];
	$new_pass     = $_POST['txt_new_pass'];
	$new_pass_try = $_POST['txt_new_pass_retry'];
	$correct_user = Employer::authenticate( $username, $old_pass );
		
		/* check old password**/
		if ( !$correct_user ){
			$error[] = format_lang('errormsg',44);
		}
		/**new password*/
		if ( strlen($new_pass) != strlen($new_pass_try) ){
			$error[] = format_lang('errormsg',45);
		}
		if ( strlen($new_pass) < 6 ||  strlen($new_pass) > 20 ){
			$error[] = format_lang('errormsg',46);
		}
	
	if( sizeof($error) == 0 ){
		//if everything ok 
		$pass_change = Employer::change_password( $username, $new_pass );
		if( $pass_change ){
				$session->message ("<div class='success'>".format_lang('success', 'pass_chg_success')."</div>");
				destroy_my_session();
				redirect_to( BASE_URL."employer/account/change_password/" );
		}
		else{
			$session->message ("<div class='error'>".format_lang('errormsg',47)."</div>");
		}
	}else{
			$message = "<div class='error'> 
					".format_lang('following_errors')."
				<ul> <li />";
			$message .= join(" <li /> ", $error);
			
			$message .= " </ul> 
					   </div>";
		
		$session->message ( $message );
	}
}

$html_title = SITE_NAME . " - ".format_lang('page_title','change_password');
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('employer/change_pass.tpl') );
?>