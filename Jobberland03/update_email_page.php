<?php
$user = Employee::find_by_id( $user_id );	
$email 			= $user->email_address;
$validated 		= $user->is_active;
$username = $user->username;

$smarty->assign( 'current_email', $email );
$smarty->assign( 'is_validated', $validated );


if( isset($_POST['bt_email']) ){
	$error= array();
	
	$email_address = trim($_POST['txt_email_address']);
	$con_email = trim($_POST['txt_confirm_email_address']);
		if( !check_email($email_address) ){
			$error[] = format_lang('error', 'incorrect_format_email');
		}
		
		$email_found 	= Employee::check_email($email_address);
		if( $email_found ){
			$error[] = format_lang('error','email_already_existed');
		}
		
		if( sizeof($error) == 0 ){
			$user = Employee::change_email_address( $username, $email_address );
			
			if( $user ){
				
				$change_key = Employee::change_key( $username );
				
				if($change_key)
				{
					$mess = "<p>To confirm your profile addition, please click the link below. Or, 
								if the link is not clickable, copy and paste it into address bar of your 
								web browser, to directly access it.</p><p>&nbsp;</p>";
					
					$mess .= "<p>#Link#/confirm_reg/$reg_key/</p><p>&nbsp;</p>";
					
					$mess .= "<p>If you still have the final step of the registration wizard open, 
					you can input your confirmation code on that screen.</P><p>&nbsp;</p>";
					
					$mess .= "<p>Your confirmation code is: $reg_key</p><p>&nbsp;</p>";

				}
				
				$message = "<div class='success'>".format_lang('success','update_email')."</div>";
				
			}else{
				$message = "<div class='error'>".format_lang('errormsg',61)."</div>";
			}
		}else{
			$message = "<div class='error'> 
					".format_lang('following_errors')."
				<ul> <li />";
			$message .= join(" <li /> ", $error);
			
			$message .= " </ul> 
					   </div>";
		}
		$session->message ( $message );
		redirect_to( BASE_URL."account/update_email/" );
}

	$html_title = SITE_NAME . " - ".format_lang('page_title','ChangeEmailAddress');
	$smarty->assign('lang', $lang);
	$smarty->assign( 'message', $message );	
	$smarty->assign('rendered_page', $smarty->fetch('update_email.tpl') );
?>