<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	$plugin_arr = new PluginConfig();
	$id = !isset($_REQUEST['id']) ? 0 : $_REQUEST['id'];
	$smarty->assign( 'id', $id );

$k=false;
if( isset($_POST['add']) ){	
	foreach( $_POST['plugin'] as $key => $data ){
		$plugin_arr->id = strip_html ( $key );
		$plugin_arr->plugin_value = strip_html ( $data );
		if( $plugin_arr->update_plugin() ) {$k = true;}
	}

	if( isset($k) && $k == true ){ 
	  $session->message ("<div class='success'> Plugin has been updated successfully. </div>");
	  redirect_to( $_SERVER['PHP_SELF']."?id=".$id );
	  die;
	}else{
	  redirect_to( $_SERVER['PHP_SELF']."?id=".$id );
	  die;
	}
}


	$plugin_arr->plugin_id = (int)$id;
	$plugin_ = $plugin_arr->get_pluginconfig_by_plugin_id();
	$manage_lists = array();
	if($plugin_ && is_array($plugin_)){
		$i=1;
		foreach( $plugin_ as $list ):			
		  $manage_lists[$i]['id'] = $list->id;		 
		  $manage_lists[$i]['title'] = $list->plugin_title;
		  $manage_lists[$i]['description'] = $list->plugin_desc;
		  $manage_lists[$i]['input'] = PluginConfig::plugin_value ( $list );
		  $i++;
		endforeach;
		$smarty->assign( 'pluginconfig', $manage_lists );
	}


/**




	
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
	**/
	
$html_title = SITE_NAME . " Plugin Config for ";

$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/plugin_config.tpl') );
$smarty->display('admin/index.tpl');
unset( $_SESSION['message']);
?>