<?php  require_once( "../initialise_files.php" );  
		include_once("sessioninc.php");
	
	if( isset($_POST['bt_edit']) ){
		
		$package = new Package();
		$package->id 				= (int)$_POST['id'];
		$package->package_name		= $_SESSION['package']['name'] 		= $_POST['txt_name'];
		$package->package_desc		= $_SESSION['package']['desc'] 		= $_POST['txt_desc'];
		$package->package_price 	= $_SESSION['package']['price'] 	= $_POST['txt_price'];
		$package->package_job_qty 	= $_SESSION['package']['qty'] 		= $_POST['txt_qty'];
		$package->standard			= $_SESSION['package']['standard'] 	= $_POST['txt_standard'];
		$package->spotlight			= $_SESSION['package']['spotlight'] = $_POST['txt_spotlight'];
		$package->cv_views			= $_SESSION['package']['cv_views'] 	= $_POST['txt_cv_views'];
		$package->is_active 		= $_SESSION['package']['active'] 	= $_POST['txt_active'];
		
		if( $package->save() ){
			$session->message ("<div class='success'> Package has been successfully updated. </div>");
			redirect_to( "list_packages.php" );
			die;
		}else{
			$message = "<div class='error'> following error(s) found: <ul> <li />";
			$message .= join(" <li /> ", $package->errors);
			$message .= " </ul></div>";
		}
	}else{
		$package = Package::find_by_id( $_GET['id'] );
		$_SESSION['package']['name'] 		= $package->package_name;
		$_SESSION['package']['desc'] = $package->package_desc;
		$_SESSION['package']['price'] = $package->package_price;
		$_SESSION['package']['qty'] = $package->package_job_qty;
		$_SESSION['package']['standard'] = $package->standard;
		$_SESSION['package']['spotlight'] = $package->spotlight;
		$_SESSION['package']['cv_views'] = $package->cv_views;
		$_SESSION['package']['active'] = $package->is_active;
	}

$NoYes = get_lang("select", "NoYes");
$smarty->assign('NoYes', $NoYes);
$smarty->assign('id', $_GET['id']);

$_SESSION['package']['standard'] = !isset($_SESSION['package']['standard']) ? "Y" : $_SESSION['package']['standard'];


$html_title = SITE_NAME . " Edit Package ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/edit_package.tpl'));
$smarty->display('admin/index.tpl');
unset( $_SESSION['message']);
?>