<?php  require_once( "../initialise_files.php" );  
	include_once("sessioninc.php");


$html_title = SITE_NAME . " - Jobberland Developers and Contributors ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/jobberland_credits.tpl') );

$smarty->display('admin/index.tpl');
unset( $_SESSION['message']);
?>