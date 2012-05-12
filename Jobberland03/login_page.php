<?php 	/** if user already logged in take them to index page */
	if( $session->get_job_seeker() ){
		redirect_to(BASE_URL."account/");
		die;
	}
	
$smarty->assign( 'username', "" );

if ( !isset($_GET['error']) ) unset($_SESSION['direct_to']);
	
	/** login */
	if( isset($_POST['bt_login']) ){
		$username 	= trim($_POST['useranme_txt']);
		$pass 		= trim($_POST['pass_txt']);
		$smarty->assign( 'username', $username );
		
		$errors = array();
		
		if( $username == "" || $pass == "" ){
			$errors[] = format_lang ( 'error', 'empty_user_pass' );
		}
		
		if ( ENABLE_SPAM_LOGIN && ENABLE_SPAM_LOGIN == 'Y' ){
			
		  if ( ( strtolower($_POST['spam_code']) != strtolower($_SESSION['spam_code']) || 
		  	   ( !isset($_SESSION['spam_code']) || $_SESSION['spam_code'] == NULL ) ) )  {
					$errors[] = format_lang('error', 'spam_wrong_word');
				}
		}
		
		if( sizeof($errors) == 0 ){		
			$user_found = Employee::authenticate( $username, $pass );
				if( $user_found ){
					//check employee status
					if($user_found->employee_status == 'pending' ){
						$message = "<div class='error'>".format_lang('error', 'approve_account')."</div>";
					}
					elseif($user_found->employee_status == 'deleted' ){
						$message = "<div class='error'>".format_lang('error', 'status_deleted_account')."</div>";
					}
					elseif($user_found->employee_status == 'suspended' ){
						$message = "<div class='error'>".format_lang('error', 'status_suspended_account')."</div>";
					}
					elseif($user_found->employee_status == 'declined' ){
						$message = "<div class='error'>".format_lang('error', 'status_declined_account')."</div>";
					}
					else{
							$access = "User";
							$session->login ( $user_found, $access );
							
							if(isset($_SESSION['direct_to']) ){
								$page = $_SESSION['direct_to'];
								unset($_SESSION['direct_to']);
								redirect_to( $page );
								die;
							}
							else {redirect_to( BASE_URL . "account/"); exit;}
					}
				}else{
					$message = "<div class='error'>".format_lang ( 'error', 'incorrect_user_pass' )."</div>";
				}
		}else
		{
			$message = "<div class='error'><ul style='margin:0; padding:0; list-style:none;'><li />";
			$message .= join(" <li /> ", $errors );
			$message .= " </ul> </div>";
		}
		
		
	}else{
		$username = "";
		$pass 	  = "";
	}
	/** end here **/
	
$html_title = SITE_NAME . " - ".format_lang('page_title', 'login');
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('login.tpl') );
?>