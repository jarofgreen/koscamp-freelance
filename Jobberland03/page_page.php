<?php  	
	$req = return_url();	
	$var_name = $req[1];

	$page = strip_html( $var_name );	
	$sql = "Select * FROM ".TBL_PAGE." WHERE pagekey='".$page."' ";
	$result = $database->query($sql);
	
	$page_ = $database->fetch_object( $result );
	
	if(!$page_ && !is_array($page_)){
		redirect_to(BASE_URL . 'page-unavailable/');
		exit;
	}
	
	$smarty->assign( 'page', $page_ );

	
	$title = strip_html( $page_->title );
	$smarty->assign( 'title', $title );
	
	$key = $page_->pagekey;
	$pagetext = stripslashes( $page_->pagetext );
	$smarty->assign( 'pagetext', $pagetext );

$html_title = SITE_NAME . " - ". $title;
$smarty->assign( 'message', $message );
$smarty->assign('rendered_page', $smarty->fetch('page.tpl') );
?>