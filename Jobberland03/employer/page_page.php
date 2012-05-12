<?php  	
	$req = return_url();	
	$var_name = $req[2];

	$page = strip_html( $var_name );	
	$sql = "Select * FROM ".TBL_PAGE." WHERE pagekey='".$page."' ";
	$result = $database->query($sql);
	
	$get_page = $database->fetch_object( $result );
	$num = $database->num_rows( $result );

if( $num == 0 ){
	redirect_to(BASE_URL."employer/page-unavailable/");
	die;
}
	$smarty->assign( 'get_page', $get_page );

	
	$title = strip_html( $get_page->title );
	
	$smarty->assign( 'title', $title );
	
	$key = $get_page->pagekey;
	$pagetext = stripslashes( $get_page->pagetext );
	
	$smarty->assign( 'pagetext', $pagetext );

$html_title = SITE_NAME . " - ". $title;
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('employer/page.tpl') );
?>