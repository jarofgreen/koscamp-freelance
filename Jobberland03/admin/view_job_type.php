<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	$smarty->assign( 'action', $_GET['action'] );
	$smarty->assign( 'id', (int)$_GET['id'] );
	
//// updating job types
if( isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) ) { 
    $id = (int)$_GET['id'];
    $jt_name = JobType::find_by_id( $id );    
    $jt_name2 = $jt_name->type_name;

	$smarty->assign( 'jt_name2', $jt_name2 );
	$smarty->assign( 'is_active', $jt_name->is_active );
	
		if( isset($_GET['bt_update']) ){
			$job_type = new JobType();
			$job_type->id = (int)$_GET['id'];
			$job_type->type_name = $_GET['txt_name'];
			$job_type->var_name 	= $job_type->mod_write_check($_GET['txt_name'], $jt_name->var_name);
			$job_type->is_active = $_GET['txt_active'];
			
			if($job_type->save()){
				$session->message ("Job Type updated ");
				redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
				die;
			}else{
				$message = join("<br />", $job_type->errors );
			}
		}
}

//deleteing job type
if( isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) ) { 
	$job_type = new JobType();
	$job_type->id = (int)$_GET['id'];
	if( $job_type->delete() ){
		$session->message ("Job Type deleted ");
		redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
		die;
	}else{
		$message = join("<br />", $job_type->errors );
	}
	
}

///// add new job type
if( isset($_GET['action']) && $_GET['action'] == "add" ) { 
	if( isset($_POST['bt_add']) ){
			$job_type = new JobType();
			
			$job_type->type_name	= $_POST['txt_type_name'];
			$job_type->var_name 	= $job_type->mod_write_check($_POST['txt_type_name'], null );
			$job_type->is_active	= $_POST['txt_is_active'];
			
			if( $job_type->save() ){
				$session->message("New Job Type added.");
				redirect_to( $_SERVER['PHP_SELF'] );
				die;
			}else{
				$message = join("<br />", $job_type->errors );
			}
	}
}

#########################################

	$job_types = JobType::find_all();

		$manage_lists = array();
		if($job_types && is_array($job_types)){
			$i=1;
			foreach( $job_types as $list ):			
			  $manage_lists[$i]['id'] = $list->id;		 
			  $manage_lists[$i]['type_name'] = $list->type_name;
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
$smarty->assign('rendered_page', $smarty->fetch('admin/view_job_type.tpl') );
$smarty->display('admin/index.tpl');
?>