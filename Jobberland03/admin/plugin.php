<?php
  require_once( "../initialise_files.php" );
  include_once("sessioninc.php");
	
	if( !empty($_GET['id']) &&  !empty($_GET['action']) ){
		$id 	= $_GET['id'];
		$action = $_GET['action'];

		$plugin = new Plugin();
		$plugin->id = $id;
		if( $action == 'install' ) { $plugin->enabled = 'Y'; $plugin->plugin_check( $id, 'Y' ); }
		else {$plugin->enabled = 'N'; $plugin->plugin_check( $id, 'N' ); }
		
		if( $plugin->save() ) {
		   $session->message ("<div class='success'> Plugin has been updated successfully. </div>");
		   redirect_to( $_SERVER['PHP_SELF'] );
		   die;
		}else{
		   $session->message ("<div class='error'> Plugin has not been updated. </div>");
		   redirect_to( $_SERVER['PHP_SELF'] );
		   die;
		}
		
	}
	
	$plugin_arr = Plugin::find_all();
	//print_r($plugin_arr);
	$manage_lists = array();
	if( $plugin_arr && is_array($plugin_arr) ){
		$i=1;
		foreach( $plugin_arr as $list ):			
		  $manage_lists[$i]['id'] = $list->id;		 
		  $manage_lists[$i]['plugin_name'] = $list->plugin_name;
		  $manage_lists[$i]['plugin_key'] = $list->plugin_key;
		  $manage_lists[$i]['class_file'] = $list->class_file;
		  $manage_lists[$i]['enabled'] = $list->enabled;
		  $i++;
		endforeach;
		
		$smarty->assign( 'plugins', $manage_lists );
	}
	
$html_title = SITE_NAME . " - Plugins";

$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/plugin.tpl') );
$smarty->display('admin/index.tpl');
unset( $_SESSION['message']);
?>