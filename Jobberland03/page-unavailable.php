<?php
	
	include_once("layout/search_inc.php");

	$smarty->assign( 'message', $message );
	$smarty->assign('rendered_page', $smarty->fetch('page-unavailable.tpl') );
?>