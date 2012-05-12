<?php if( !defined('SITE_ROOT') ){include_once("initialise_file_location.php");}

	$page2 = return_url();
	$page = (isset($page2[0]) ? $database->escape_value($page2[0]) : '');


	$smarty->assign('employee_logged_in', false);
	if( $session->get_job_seeker() ){ 
	  $smarty->assign('employee_logged_in', true);
	  $smarty->assign('logged_user_id', $session->get_user_id() );
	}
	
	include_once("layout/jobs_by_top_category.php");
	include_once("layout/spotlight_jobs_inc.php");
	include_once("layout/recruiting_now_inc.php");
	
	if ( HOME_DISPLAY == 'topten' && $page == '' ){
		include_once("layout/group_by_created_date.php");
	}
	
	include_once("page_top.php");

	$has_been_found = false;

	if(!isset($_SERVER['HTTP_REFERER'])) {
	   $_SERVER['HTTP_REFERER'] = '';
	}

	$html_title 		= PAGE_TITLE;
	$meta_description 	= META_KEYWORDS;
	$meta_keywords 		= META_DESCRIPTION;
	
	switch( $page ){
//guest		
		case '':
			if( $session->get_job_seeker() ){ require_once("home_account.php"); }
			else{require_once("home_page.php");}
			
			$has_been_found = true;
		break;
		
		case "login": 
			require_once("login_page.php");
			$has_been_found = true;
		break;

		case "register":
			require_once("register_page.php");
			$has_been_found = true;
		break;
		
		case "job":
			require_once("job_page.php");
			$has_been_found = true;
		break;
		
		case "apply":
			require_once("apply_page.php");
			$has_been_found = true;
		break;

		case "apply_suggestion":
			require_once("apply_suggestion_page.php");
			$has_been_found = true;
		break;
		case "advance_search":
			require_once("advance_search_page.php");
			$has_been_found = true;
		break;
		
		case "search_result":
			require_once("search_page.php");
			$has_been_found = true;
		break;

		case "search":
			$url="";
			if(!empty($_REQUEST['q'])){
				if(!empty($_REQUEST['q'])) $url .= "q=".$_REQUEST['q'];
				if( strlen($_REQUEST['q']) < 3 ){
					$session->message("<div class='error'>String to short for search</div>");
					redirect_to(BASE_URL.'search_result/' );
					die;
				}
			}
			
			//if(!empty($_REQUEST['category'])) $url .= "category=". implode( ',' , $_REQUEST['category'] ); 
			
			
				$query = "";
				foreach( $_REQUEST as $key => $data){
					//$data = trim($data);
					if( !empty($data) && $data != "" && $key != "page" && $key != "search_bt" && $key != "PHPSESSID" ){
						if( is_array( $_GET[$key] ) ){
							foreach( $_GET[$key] as $key2 => $data2){
								$query .= "&".$key."[]=".$data2;
							}
						}else{
							$query .= "&".$key."=".$data;
						}
					}
				}
/*				
				if ( is_array($_REQUEST['category']) && !empty($_REQUEST['category'])&& $_REQUEST['category'] != "" ) {
					$category = "";
					foreach ( $_REQUEST['category'] as $key => $value ):
						$category .= "&category[]=".$value;
					endforeach;
					$query = $query . $category;
				}
*/
				$query = substr_replace($query, '', 0, 1);
				redirect_to(BASE_URL . 'search_result/?'.$query);
				exit;
			//search_result
		break;
		
		case "category":
			require_once("category_page.php");		
			$has_been_found = true;
		break;
		
		case "location":
			require_once("location_page.php");
			$has_been_found = true;
		break;
		
		case "company":
			require_once("company_page.php");
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
		
		case "help":
			require_once("job_page.php");
			$has_been_found = true;
		break;

		case "feedback":
			require_once("feedback_page.php");
			$has_been_found = true;
		break;
		
		case "page":
			require_once("page_page.php");
			$has_been_found = true;
		break;
		
		case "share":
			require_once("tell_a_friend_page.php");
			$has_been_found = true;
		break;
//members		
		case "applications":
			require_once("application_page.php");
			$has_been_found = true;
		break;
		
		case "save_job":
			require_once("save_job_page.php");
			$has_been_found = true;
		break;
		
		case "save_search":
			require_once("save_search_page.php");
			$has_been_found = true;
		break;
		
		case "account":
			require_once("account_page.php");
			$has_been_found = true;
		break;
		
		case "curriculum_vitae":
			require_once("cv_page.php");
			$has_been_found = true;
		break;
		
		case "covering_letter":
			require_once("cl_page.php");
			$has_been_found = true;
		break;
		
		case "change_password":
			require_once("company_page.php");
			$has_been_found = true;
		break;
				
		case "logout":
			require_once("logout_page.php");
			$has_been_found = true;
		break;

		case "page-unavailable":
			require_once("page-unavailable.php");
			$has_been_found = true;
		break;
		
		default:
			//require_once("job_page.php");
		break;
		
	}

	if($has_been_found == false && !$has_been_found )
	{
		//redriect(BASE_URL."un");
		redirect_to(BASE_URL . 'page-unavailable/');
		exit;
	}
	
	$has_been_found = false;
	
	global $html_title, $meta_description,$meta_keywords;
	
	if (isset($html_title) && $html_title != '')
		$smarty->assign('html_title', $html_title);
	if (isset($meta_description) && $meta_description != '')
		$smarty->assign('meta_description', $meta_description);
	if (isset($meta_keywords) && $meta_keywords != '')
		$smarty->assign('meta_keywords', $meta_keywords);	
	
/**
	if (isset($_SESSION['SEO']['html_title']) && $_SESSION['SEO']['html_title'] != '')
		$smarty->assign('html_title', $_SESSION['SEO']['html_title']);
	if (isset($_SESSION['SEO']['meta_description']) && $_SESSION['SEO']['meta_description'] != '')
		$smarty->assign('meta_description', $_SESSION['SEO']['meta_description']);
	if (isset($_SESSION['SEO']['meta_keywords']) && $_SESSION['SEO']['meta_keywords'] != '')
		$smarty->assign('meta_keywords', $_SESSION['SEO']['meta_keywords']);	
	
***/	
	
	unset( $_SESSION['message'] );
	$smarty->display('index.tpl');	
?>