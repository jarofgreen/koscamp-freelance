<?php  require_once( "../initialise_files.php" );
	
	include_once("sessioninc.php");
	
	$NoYes = get_lang("select", "NoYes");
	$smarty->assign('NoYes', $NoYes);
	
	$_SESSION['package']['standard'] = !isset($_SESSION['package']['standard']) ? "Y" : $_SESSION['package']['standard'];
	
	if( isset($_POST['bt_add']) ){
		
		$package = new Package();
		$package->package_name		= $_SESSION['package']['name'] 		= $_POST['txt_name'];
		$package->package_desc		= $_SESSION['package']['desc'] 		= $_POST['txt_desc'];
		$package->package_price 	= $_SESSION['package']['price'] 	= $_POST['txt_price'];
		$package->package_job_qty 	= $_SESSION['package']['qty'] 		= $_POST['txt_qty'];
		$package->standard			= $_SESSION['package']['standard'] 	= $_POST['txt_standard'];
		$package->spotlight			= $_SESSION['package']['spotlight'] = $_POST['txt_spotlight'];
		$package->cv_views			= $_SESSION['package']['cv_views'] 	= $_POST['txt_cv_views'];
		$package->is_active 		= $_SESSION['package']['active'] 	= $_POST['txt_active'];
		
		if( $package->save() ){
			$session->message ("<div class='success'> Package has been successfully added. </div>");
			destroy_my_session();
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}else{
			$message = "<div class='error'> following error(s) found: <ul> <li />";
			$message .= join(" <li /> ", $package->errors);
			$message .= " </ul></div>";
		}
	}

$smarty->assign( 'titles', get_lang ('titles') );
$html_title = SITE_NAME . " Add New Employer ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/new_package.tpl') );
$smarty->display('admin/index.tpl');	
unset( $_SESSION['message']);
?>