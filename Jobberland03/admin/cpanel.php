<?php  require_once( "../initialise_files.php" );  
	include_once("sessioninc.php");


$html_title = SITE_NAME . " Add New Employer ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/cpanel.tpl') );
$smarty->display('admin/index.tpl');
?>