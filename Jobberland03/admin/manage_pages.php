<?php  require_once( "../initialise_files.php" );  
	
	include_once("sessioninc.php");
	
	if( isset($_POST['bt_page']) ){
		
		$allowedTags='<p><strong><em><u><img><span><style><blockquote>';
		$allowedTags.='<li><ol><ul><span><div><br><ins><del><a><span>';
		
		$title 		= trim($_POST['txt_title']);
		$key 		= trim($_POST['txt_key']);
		$page_text 	= trim($_POST['txt_page_text']);
		
		$page_text 	= strip_tags( $page_text, $allowedTags);
		$page_text 	= $database->escape_value( $page_text );
		//$city->var_name = $state->mod_write_check( trim($data[1]) );
		$page_text = str_replace( "%SITE_NAME%", SITE_NAME, $page_text);
		
		if (!empty($title) && !empty($key) && !empty($page_text) )
		{
			$sql = " INSERT INTO ".TBL_PAGE." (id,lang,pagekey,title,pagetext) VALUES (NULL , '' , '$key', '$title', '".$page_text."') ";

			if($database->query($sql)) {
				$session->message("Page has been added Successfully");
				redirect_to( $_SERVER['PHP_SELF'] );
				die;
				
			} else {
				$message = "Problem ";
			}
		}
		
		unset( $sql );
	}
	
	if( isset($_POST['bt_update_page']) ){
		$allowedTags='<p><strong><em><u><img><span><style><blockquote>';
		$allowedTags.='<li><ol><ul><span><div><br><ins><del><a><span>';
		
		$id = (int)$_POST['id'];
		$title = trim($_POST['txt_title']);
		$key = trim($_POST['txt_key']);
		$page_text = ltrim(rtrim($_POST['txt_page_text']));
		$page_text = strip_tags($page_text, $allowedTags);	
		$page_text 	= $database->escape_value( $page_text );
		$page_text = str_replace( "%SITE_NAME%", SITE_NAME, $page_text);

		if (!empty($title) && !empty($key) && !empty($page_text) ){
			$sql = sprintf(" UPDATE ".TBL_PAGE." SET 
											pagekey = '%s', 
											title = '%s', 
											pagetext = '%s' 
								WHERE id='%s'
						   ",
							   $key,
							   $title,
							   $page_text,
							   $id
						   );
			
			
			
			if($database->query($sql)) {
				$session->message("Page has been updated Successfully");
				redirect_to( $_SERVER['PHP_SELF'] );
				die;
				
			} else {
				$message = "Problem ";
			}
		}
		unset( $sql );
	}
	
	
	$sql = "Select * FROM ".TBL_PAGE."; ";
	$result = $database->query($sql);
	$pages = $database->db_result_to_object( $result );
	
if ( is_array($pages) && !empty($pages) ) {
	$page_t = array();
	//$page_t['AA'] = 'All Countries';
	foreach( $pages as $page ):
			$page_t[ $page->id ] = $page->title;
	endforeach; 
	$smarty->assign( 'list_page', $page_t );
}	


	if( isset($_POST['id']) && $_POST['id'] != "" ){
		unset($sql);
		$sql = "Select * FROM ".TBL_PAGE." WHERE id=".$_POST['id'];
		$result = $database->query($sql);
		$get_page = $database->fetch_object( $result );
		$title = $get_page->title;
		$key = $get_page->pagekey;
		$page_text = $get_page->pagetext;
		
	}
	
	$smarty->assign( 'title', $title );	
	$smarty->assign( 'key', $key );	
	$smarty->assign( 'page_text', $page_text );	
	$smarty->assign( 'id', $_POST['id'] );	
	//$smarty->assign( 'message', $message );		

$html_title = SITE_NAME . " Add New Employer ";

$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/manage_pages.tpl'));
$smarty->display('admin/index.tpl');
	//manage_pages.tpl
?>