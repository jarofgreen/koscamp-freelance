<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	$setting = new Setting();

	$id = !isset($_REQUEST['id']) ? 1 : $_REQUEST['id'];
	$id = ( $id == 0 )? $id=1 : $id;
	
	$smarty->assign( 'id', $id );
	
  $k=false;
  if( isset($_POST['add']) ){	
	foreach( $_POST['setting'] as $key => $data )
	{
		if ($key == "FILE_UPLOAD_DIR" && empty($data) && trim($data) == ""){
			$data = "uploads/";
		}
		$setting->setting_name = strip_html ( $key );
		$setting->value = strip_html ( $data );
		
		if( $setting->update_setting() ) {$k = true;}
	}
	 
	 //detele template c and cache files
	 delete_template_c_files();
	 
		if( isset($k) && $k == true ){ 
		  $session->message ("<div class='success'> Setting has been updated successfully. </div>");
		  redirect_to( $_SERVER['PHP_SELF']."?id=".$_REQUEST['id'] );
		  die;
		}else{
		  redirect_to( $_SERVER['PHP_SELF']."?id=".$_REQUEST['id'] );
		  die;
		}
  }
  	
	$setting->fk_category_id = (int)$id;
	$site_settings = $setting->get_setting_by_cat_id();
	$manage_lists = array();
	if($site_settings && is_array($site_settings)){
		$i=1;
		foreach( $site_settings as $list ):			
		  $manage_lists[$i]['id'] = $list->id;		 
		  $manage_lists[$i]['title'] = $list->title;
		  $manage_lists[$i]['description'] = $list->description;
		  $manage_lists[$i]['input'] = Setting::setting_value ( $list );
		  $i++;
		endforeach;
		$smarty->assign( 'site_setting', $manage_lists );
	}

	
	$cat_settings  	= $setting->get_setting_cat_name();
	$manage_lists = array();
	if($cat_settings && is_array($cat_settings)){
		$i=1;
		foreach( $cat_settings as $list ):			
		  $manage_lists[$i]['id'] = $list->id;		 
		  $manage_lists[$i]['category_name'] = $list->category_name;
		  $i++;
		endforeach;
		$smarty->assign( 'cat_settings', $cat_settings );
	}

	
	if( isset($id) ){
		$get_cat_name = $setting->get_setting_name( $id );
	}
	
	$cat_name = isset($get_cat_name) ? $get_cat_name['category_name'] :  "Settings Overview";
 	$cat_description = $get_cat_name['category_desc'];
	$smarty->assign( 'cat_name', $cat_name );
	$smarty->assign( 'cat_description', $cat_description );


	
$html_title = SITE_NAME . " Add New Employer ";

$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/setting.tpl') );
$smarty->display('admin/index.tpl');
unset( $_SESSION['message']);
?>