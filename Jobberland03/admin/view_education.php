<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	$smarty->assign( 'action', $_GET['action'] );
	$smarty->assign( 'id', (int)$_GET['id'] );
	
if( isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) ) {
	
	$id = (int)$_GET['id'];
    $jt_name = Education::find_by_id( $id );    
    $jt_name2 = $jt_name->education_name;

	$smarty->assign( 'jt_name2', $jt_name2 );
	$smarty->assign( 'is_active', $jt_name->is_active );
	
		if( isset($_GET['bt_update']) ){
			$education = new Education();
			$education->id = (int)$_GET['id'];
			$education->education_name = $_GET['txt_name'];
			$education->var_name 	= $education->mod_write_check($_GET['txt_name'], $jt_name->var_name);
			$education->is_active = $_GET['txt_active'];
			
			if($education->save()){
				$session->message ("Education updated ");
				redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
				die;
			}else{
				$message = join("<br />", $education->errors );
			}
		}
}

if( isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) ) { 
	$education = new Education();
	$education->id = (int)$_GET['id'];
	if( $education->delete() ){
		$session->message ("Education deleted ");
		redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
		die;
	}else{
		$message = join("<br />", $education->errors );
	}
	
}

if( isset($_GET['action']) && $_GET['action'] == "add" ) { 
	if( isset($_POST['bt_add']) ){
			$education = new Education();
			
			$education->education_name	= $_POST['txt_education_name'];
			$education->var_name 		= $education->mod_write_check($_POST['txt_education_name'] );
			$education->is_active		= $_POST['txt_is_active'];
			
			if( $education->save() ){
				$session->message("New Education added.");
				redirect_to( $_SERVER['PHP_SELF'] );
				die;
			}else{
				$message = join("<br />", $education->errors );
			}
	}
}

	$education = Education::find_all();
		$manage_lists = array();
		if($education && is_array($education)){
			$i=1;
			foreach( $education as $list ):			
			  $manage_lists[$i]['id'] = $list->id;		 
			  $manage_lists[$i]['education_name'] = $list->education_name;
			  $manage_lists[$i]['is_active'] = $list->is_active;
			  $i++;
			endforeach;
			$smarty->assign( 'manage_lists', $manage_lists );
		}
		
		$query = "";
		if( !empty($_GET) ) {
			foreach( $_GET as $key => $data){
				if( !empty($data) && $data != "" && $key != "page" && $key != "bt_search"){
					$query .= "&amp;".$key."=".$data;
				}
			}
			$smarty->assign( 'query', $query );
		}
				
$html_title = SITE_NAME . " Add New Employer ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/view_education.tpl') );
$smarty->display('admin/index.tpl');
?>