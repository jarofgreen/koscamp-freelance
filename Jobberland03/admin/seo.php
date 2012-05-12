<?php  require_once( "../initialise_files.php" );  
	
	include_once('sessioninc.php');
	$setting = new Setting();

  	$k=false;
	if( isset($_POST['add']) ){	
		foreach( $_POST['setting'] as $key => $data ){
			$setting->setting_name = strip_html ( $key );
			$setting->value = strip_html ( $data );
			if( $setting->update_setting() ) {$k = true;}
		}
		//die;
		if( isset($k) && $k == true ){ 
			$session->message ("<div class='success'> Setting has been updated successfully. </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}else{
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
  	
	$id = $setting->fk_category_id = 2;
	$smarty->assign('id', $id );
	
	$get_cat_name = $setting->get_setting_name( $id );	
	$cat_description = $get_cat_name['category_desc'];
	$smarty->assign('cat_description', $cat_description );

$title 	= $setting->get_setting_by_setting_name( 'PAGE_TITLE' );
$smarty->assign('title', $title->title);
$smarty->assign('title_value', $title->value);
$smarty->assign('title_desc', $title->description);

$keyword 	= $setting->get_setting_by_setting_name( 'META_KEYWORDS' );
$smarty->assign('keyword_title', $keyword->title );
$smarty->assign('keyword_value', $keyword->value );
$smarty->assign('keyword_desc', $keyword->description );

$desc 	= $setting->get_setting_by_setting_name( 'META_DESCRIPTION' );

$smarty->assign('desc_title', $desc->title );
$smarty->assign('desc_value', $desc->value );
$smarty->assign('desc_desc', $desc->description );


$html_title = SITE_NAME . " Search Engine Optimisation";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/seo.tpl') );
$smarty->display('admin/index.tpl');
unset( $_SESSION['message']);
?>