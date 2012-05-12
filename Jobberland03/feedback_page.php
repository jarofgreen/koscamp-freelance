<?php 
if (strstr( $_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === false){
	die("Hack attempt.");
}

$question_comment = get_lang('select','question_comments');
$smarty->assign( 'question_comment', $question_comment );	

if( isset($_POST['bt_send']) ){
		
		$error = array();
		$_SESSION['feedback'] = array();
		$_SESSION['feedback']['name'] = $name		= safe_output( $_POST['txt_first_name1'] );
		$_SESSION['feedback']['email'] = $email		= safe_output( $_POST['txt_email1'] );
		$_SESSION['feedback']['subject'] = $subject	= safe_output( $_POST['txt_subject'] );
		$_SESSION['feedback']['query'] = $cbo_query	= safe_output( $_POST['cbo_query1'] );
		$_SESSION['feedback']['comment'] = $comment	= safe_output( $_POST['txt_comment1'] );
		
	//validate text input fields
	if (empty($name)){
		$error[]=  format_lang('feedback_error',01); //"Invalid entry: Name";
	}
		
	if (empty($email)){
		$error[]= format_lang('feedback_error',02); //"Invalid entry: Email";
	}
		
	if ( $email != "" ){
		$email = check_email( $email );
		if ($email == ""){
			$error[]= format_lang('feedback_error',03); //"Invalid Email address e.g user@domain.com/co.uk/net";
		}
	}
	
	if ( $cbo_query == "" ){
		$error[]= format_lang('feedback_error',04); //"Invalid entry: My question/comment is about";
	}
		
	if (empty($comment)){
		$error[]= format_lang('feedback_error',05); //'Invalid entry: Question/comment';
	}
	
	if ( ENABLE_SPAM_FEEDBACK && ENABLE_SPAM_FEEDBACK == 'Y' && !$session->get_job_seeker() ){
	  if ( ( strtolower($_POST['spam_code']) != strtolower($_SESSION['spam_code']) || 
		   ( !isset($_SESSION['spam_code']) || $_SESSION['spam_code'] == NULL ) ) )  {
				$error[] = format_lang('error','spam_wrong_word');//"The security code you entered does not match the image.";
				unset($_SESSION['spam_code']);
	  }
	}
	
	//check for errors
	//if none found
	if (sizeof($error)==0){
		//
		$email_template = get_lang('email_template', 'feedback_user');		
		if (empty($subject)){
			$subject = $email_template['email_subject'];
			$subject 	= str_replace("#SiteName#", SITE_NAME, $subject );
		}
		
		$body = $email_template['email_text'];
		$body 		= str_replace("#FullName#", $name, $body);
		$body 		= str_replace("#Email#", $email, $body);
		$body 		= str_replace("#Subject#", $subject, $body);
		$body 		= str_replace("#MyQuestion#", $cbo_query, $body);
		$body 		= str_replace("#comment#", $comment, $body);
		$body 	= str_replace("#SiteName#", SITE_NAME, $body );
		
		$to 	= array("email" => $email, "name" => $name );
		$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME );
		$mail = send_mail( $body, $subject, $to, $from, "", "" );
		unset($email_tem,  $body, $subject, $to, $from );
		
		
		/************* send it to admin ***********/
		$email_template = get_lang('email_template', 'feedback_admin');		
			$subject = $email_template['email_subject'];
			$subject 	= str_replace("#SiteName#", SITE_NAME, $subject );
		
		$body = $email_template['email_text'];
		$body 		= str_replace("#FullName#", $name, $body);
		$body 		= str_replace("#Email#", $email, $body);
		$body 		= str_replace("#Subject#", $subject, $body);
		$body 		= str_replace("#MyQuestion#", $cbo_query, $body);
		$body 		= str_replace("#comment#", $comment, $body);
		$body 	= str_replace("#SiteName#", SITE_NAME, $body );
		
		$to 	= array("email" => ADMIN_EMAIL, "name" => ADMIN_EMAIL );
		$from 	= array("email" => $email, "name" => $name );
		$mail2 = send_mail( $body, $subject, $to, $from, "", "" );
		unset($email_tem,  $body, $subject, $to, $from );
		

		if ( $mail && $mail2 ){
			destroy_my_session();
			$message ='<div class="success">'.format_lang('success','feedback_sent').'</div>';
		}else{
			$message ="<div class='error'>".format_lang('errormsg', 59)."</div>";
		}
	}else{
		//errors found //print as list
		$message = "<div class='error'> 
						".format_lang('following_errors')."
					<ul> <li />";
		$message .= join(" <li /> ", $error);
		
		$message .= " </ul> 
				   </div>";
		$session->message($message);
	}
	
	$session->message($message);
	redirect_to(BASE_URL."feedback/");
	exit;
}

$html_title 		= SITE_NAME . " - ".format_lang('page_title','feedback');
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('feedback.tpl') );
?>