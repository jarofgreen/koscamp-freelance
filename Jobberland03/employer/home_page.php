<?php 
	if( $session->get_recuriter() && $_GET['page'] == "" && !isset($_GET['page']) ){
			redirect_to( BASE_URL."employer/account/");
			die;
	}

//$html_title 		= SITE_NAME . " - Login";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('employer/home.tpl') );
?>