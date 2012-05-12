<?php  require_once( "../initialise_files.php" );  
		include_once("sessioninc.php");
	
	$packages = Package::find_all();
	$smarty->assign('packages', $packages);
	
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "delete" ){
		$package = new Package();
		$package->id = (int)$_GET['id'];
		
		if($package->delete()){
			$session->message("<div class='success'>Package has been deleted.</div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}else{
			$message = "<div class='error'> Problem deleteing package</div>";
		}
	}


$html_title = SITE_NAME . " List Packages ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );
$smarty->assign('rendered_page', $smarty->fetch('admin/list_packages.tpl') );
$smarty->display('admin/index.tpl');
?>