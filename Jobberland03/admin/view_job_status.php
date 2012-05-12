<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	$smarty->assign( 'action', $_GET['action'] );
	$smarty->assign( 'id', (int)$_GET['id'] );
	
if( isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) ) { 
	$id = (int)$_GET['id'];
	$jt_name = JobStatus::find_by_id( $id );
	$jt_name2 = $jt_name->status_name;

	$smarty->assign( 'jt_name2', $jt_name2 );
	$smarty->assign( 'is_active', $jt_name->is_active );	

	if( isset($_GET['bt_update']) ){
		$job_status = new JobStatus();
		$job_status->id = (int)$_GET['id'];
		$job_status->status_name = $_GET['txt_name'];
		$job_status->is_active 	= $_GET['txt_active'];
		$job_status->var_name 	= $jt_name->mod_write_check($_GET['txt_name'], $jt_name->var_name);
		
		if($job_status->save()){
			$session->message ("Job Status updated ");
			redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
			die;
		}else{
			$message = join("<br />", $job_status->errors );
		}
	}
}

if( isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) ) { 
	$job_status = new JobStatus();
	$job_status->id = (int)$_GET['id'];
	if( $job_status->delete() ){
		$session->message ("Job Status deleted ");
		redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
		die;
	}else{
		$message = join("<br />", $job_status->errors );
	}
	
}

if( isset($_GET['action']) && $_GET['action'] == "add" ) { 
	if( isset($_POST['bt_add']) ){
			$job_status = new JobStatus();
			
			$job_status->status_name= $_POST['txt_status_name'];
			$job_status->is_active	= $_POST['txt_is_active'];
			$job_status->var_name 	= $job_status->mod_write_check($_GET['txt_status_name'], null);
			
			if( $job_status->save() ){
				$session->message("New Job Status added.");
				redirect_to( $_SERVER['PHP_SELF'] );
				die;
			}else{
				$message = join("<br />", $job_status->errors );
			}
	}
}
	
$job_status = JobStatus::find_all();

$manage_lists = array();

if($job_status && is_array($job_status)){
	$i=1;
	foreach( $job_status as $list ):			
	  $manage_lists[$i]['id'] = $list->id;		 
	  $manage_lists[$i]['status_name'] = $list->status_name;
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
$smarty->assign('rendered_page', $smarty->fetch('admin/view_job_status.tpl') );
$smarty->display('admin/index.tpl');
?>