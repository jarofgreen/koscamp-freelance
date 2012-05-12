<?php 
$req = return_url();	
$var_name = $req[1];

$jobs = new Job();

$job = $jobs->find_by_var_name( $var_name );
$smarty->assign('job', 	$job );
$job_id = (int)$job->id;

if($job && !empty($job) )
{
	$smarty->assign('job_title', 	safe_output( strip_html($job->job_title) ) );
	$smarty->assign('job_description', 	subtrack_string(strip_html($job->job_description), 500 ) );
	$smarty->assign('created_at', 	safe_output( strftime(DATE_FORMAT, strtotime($job->created_at) ) ) );
	
	$city = City::find_by_code( $job->country, $job->state_province, $job->county, $job->city );
	$city_name = empty($city) ? $job->city : $city->name;

	$smarty->assign('location', $city_name );
}


if ( isset($_POST['bt_send']) ) {
	
	$error = array();
	/** SNED to email address and check for vaildation on entered emails */
	$_SESSION['share']['send_to'] = $send_to	= safe_output( $_POST['txt_send_to1'] );
	if ( $send_to == "" ){
		$error[] = format_lang('errormsg', 38);
	}
	if ($send_to != ""){
		$send = split(",", $send_to);
		for ($i=0; $i < sizeof($send); $i++ ){
			$ch = check_email( $send[$i] );
			if ($ch == ""){
				$error[]= format_lang('error', 'incorrect_format_email') . " - ".$send[$i];
			}
		}
	}
	
	/**subject */
	$_SESSION['share']['subject'] = $subject = safe_output( $_POST['txt_subject'] );
	if ( $subject == "" ){
		$subject = "Re: ".$job->job_title;
	}
	
	/** comments */
	$_SESSION['share']['notes'] = $notes	.= safe_output( $_POST['txt_comments']);
	
	/**from email address*/
	$_SESSION['share']['from_send'] = $from_send	= safe_output( $_POST['txt_email1'] );
	if ( $from_send == "" ){
		$error[] = format_lang("error",'email');
	}
	if ( $from_send != "" ){
		$from_send = check_email( $from_send );
		if ($from_send == ""){
			$error[]= format_lang('errormsg', 39);
		}
	}

if (  ENABLE_SPAM_SHARE && ENABLE_SPAM_SHARE == 'Y'  && !$session->get_job_seeker() ){
 if ( (strtolower($_POST['spam_code']) != strtolower($_SESSION['spam_code']) || 
	( !isset($_SESSION['spam_code']) || $_SESSION['spam_code'] == NULL ) ) )  {
		$error[] = format_lang('error','spam_wrong_word');
	}
}
	
	/**if no errors found then do this*/
	if( sizeof($error) == 0 ):
		$send_to = split(",", $send_to);
		
		$email_template = format_lang('email_template','tell_a_friend' );
		$subject 	= str_replace("#SiteName#", SITE_NAME, $email_template['email_subject'] );
		
		$body = $email_template['email_text'];
		$body = str_replace("#Link#", 		BASE_URL, $body);
		$body = str_replace("#Domain#", 	$_SERVER['HTTP_HOST'], $body );
		$body 	= str_replace("#Message#", nl2br($_POST['txt_comments']), $body );
		$body 	= str_replace("#JobId#", $var_name , $body );
		$body 	= str_replace("#SiteName#", SITE_NAME , $body );
		
		$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME );
		//$from 	= array("email" => $from_send, "name" => $from_send);
		
		for ($i=0; $i < sizeof($send_to); $i++ ){
			$to 	= array("email" => trim($send_to[$i]), "name" => trim($send_to[$i]) );
			$mail = send_mail( $body, $subject, $to, $from, $cv, "" );
		}
		
		unset($email_tem,  $body, $subject, $to, $from );
		
		destroy_my_session();
		
		if($mail):
			$session->message ("<div class='success'>".format_lang('success','succ_feedback')."</div>");
			//redirect_to("tell_a_friend.php?id=".$job_id);
		else:
			$session->message ("<div class='error'>".format_lang('error', 'email_not_send')."</div>");
		endif;
	  
	else:
	 //if any errors found then display them for user
	 //if size of error more then 0 then 
		$message = "<div class='error'> 
						".format_lang('following_errors')."
					<ul> <li />";
		$message .= join(" <li /> ", $error);
		
		$message .= " </ul> 
				   </div>";
		$session->message ($message);
	endif;
	redirect_to( BASE_URL. "share/". $var_name."/" );
}

$html_title 		= SITE_NAME . " - ".format_lang('page_title','Sharewithfriend')." < ".$job->job_title . " > ";

$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );
$smarty->assign('rendered_page', $smarty->fetch('tell_a_friend.tpl') );
//tell_a_friend.tpl
?>