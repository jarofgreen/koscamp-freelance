<?php if( !defined('SITE_ROOT') ){include_once("../initialise_file_location.php");}

	include_once("left_side_page.php");	
	$smarty->assign('employer_logged_in', false);
	if( $session->get_recuriter() ){ 	$smarty->assign('employer_logged_in', true); }

	$html_title 		= PAGE_TITLE;
	$meta_description 	= META_KEYWORDS;
	$meta_keywords 		= META_DESCRIPTION;
	
	$has_been_found = false;
	$page2 = return_url();
	$page = $page2[1];
	

	switch( $page ){

//guest		
		case '':
			require_once("home_page.php");
			$has_been_found = true;
		break;

		case "register":
			require_once("register_page.php");
			$has_been_found = true;
		break;

		case "login":
			require_once("login_page.php");
			$has_been_found = true;
		break;

		case "page":
			require_once("page_page.php");
			$has_been_found = true;
		break;

		case "services":
			require_once("services_page.php");
			$has_been_found = true;
		break;
		
		case "page-unavailable":
			require_once("page-unavailable.php");
			$has_been_found = true;
		break;

		case "forgot_details":
			require_once("forgot_detail_page.php");
			$has_been_found = true;
		break;
		
		case "resend_conflink":
			require_once("resend_conflink_page.php");
			$has_been_found = true;
		break;
		
		case "confirmreg":
			require_once("confirmreg_page.php");
			$has_been_found = true;
		break;

		case "rss":
			require_once("rss_page.php");
			$has_been_found = true;
		break;
		
		case "sitemap":
			require_once("job_page.php");
			$has_been_found = true;
		break;
		
		case "feedback":
			require_once("feedback_page.php");
			$has_been_found = true;
		break;

//login	
		case "search":
			require_once("search_page.php");
			$has_been_found = true;
		break;

		case "search_result":
			require_once("search_result_page.php");
			$has_been_found = true;
		break;

		case "review_cv":
			require_once("review_cv_page.php");
			$has_been_found = true;
		break;

		case "download_cv":
			require_once("download_cv_page.php");
			$has_been_found = true;
		break;
		
		case "addjob":
			require_once("add_job_page.php");
			$has_been_found = true;
		break;

		case "editjob":
			require_once("edit_job_page.php");
			$has_been_found = true;
		break;
		
		case "account":
			require_once("account_page.php");
			$has_been_found = true;
		break;

		case "credits":
			require_once("credits_page.php");
			$has_been_found = true;
		break;

		case "payment_history":
			require_once("payment_history_page.php");
			$has_been_found = true;
		break;

		case "order":
			require_once("order_page.php");
			$has_been_found = true;
		break;
		
		case "confirmation":
			require_once("confirmation_page.php");
			$has_been_found = true;
		break;
		case "payment":
			require_once("payment_page.php");
			$has_been_found = true;
		break;

		case "myjobs":
			require_once("my_jobs_page.php");
			$has_been_found = true;
		break;

		case "invoice":
			require_once("invoice_page.php");
			$has_been_found = true;
		break;
		
		case "checkout_process":
			require_once("checkout_process.php");
			$has_been_found = true;
		break;
		
		case "thankyou":

			$html_title 		= SITE_NAME . " - Thank you for your payment ";
					
			$smarty->assign('lang', $lang);
			$smarty->assign( 'message', $message );	
			$smarty->assign('rendered_page', $smarty->fetch('employer/thankyou.tpl') );
			//$smarty->assign('rendered_page','employer/thankyou.tpl');

			//require_once("than_page.php");
			$has_been_found = true;
		break;
						
		default:
			//require_once("job_page.php");
		break;
		
	}

	if($has_been_found == false && !$has_been_found )
	{
		//redriect(BASE_URL."un");
		redirect_to(BASE_URL . 'employer/page-unavailable/');
		exit;
	}
	//$smarty->assign('rendered_page', $smarty->fetch('admin/add_category.tpl') );
	
	global $html_title, $meta_description,$meta_keywords;
	
	if (isset($html_title) && $html_title != '')
		$smarty->assign('html_title', $html_title);
	if (isset($meta_description) && $meta_description != '')
		$smarty->assign('meta_description', $meta_description);
	if (isset($meta_keywords) && $meta_keywords != '')
		$smarty->assign('meta_keywords', $meta_keywords);	
	
	
$smarty->assign( 'message', $message );
unset( $_SESSION['message'] );
$smarty->display('employer/index.tpl');
?>