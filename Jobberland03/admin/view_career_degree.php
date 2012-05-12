<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");

	$smarty->assign( 'action', $_GET['action'] );
	$smarty->assign( 'id', (int)$_GET['id'] );
	
if( isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) ) { 

    $id = (int)$_GET['id'];
    $jt_name = CareerDegree::find_by_id( $id );    
    $jt_name2 = $jt_name->career_name;

	$smarty->assign( 'jt_name2', $jt_name2 );
	$smarty->assign( 'is_active', $jt_name->is_active );

		if( isset($_GET['bt_update']) ){
			$career_degree = new CareerDegree();
			$career_degree->id = (int)$_GET['id'];
			$career_degree->career_name = $_GET['txt_name'];
			$career_degree->var_name 	= $career_degree->mod_write_check($_GET['txt_name'], $jt_name->var_name);
			$career_degree->is_active = $_GET['txt_active'];
			
			if($career_degree->save()){
				$session->message ("CareerDegree updated ");
				redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
				die;
			}else{
				$message = join("<br />", $career_degree->errors );
			}
		}
}

if( isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) ) { 
	$career_degree = new CareerDegree();
	$career_degree->id = (int)$_GET['id'];
	if( $career_degree->delete() ){
		$session->message ("CareerDegree deleted ");
		redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
		die;
	}else{
		$message = join("<br />", $career_degree->errors );
	}
	
}

if( isset($_GET['action']) && $_GET['action'] == "add" ) { 
	if( isset($_POST['bt_add']) ){
			$add_new = new CareerDegree();
			
			$add_new->career_name	= $_POST['txt_career_name'];
			$add_new->var_name 	= $add_new->mod_write_check($_POST['txt_career_name'] );
			$add_new->is_active	= $_POST['txt_is_active'];
			
			if( $add_new->save() ){
				$session->message("New Career Degree added.");
				redirect_to( $_SERVER['PHP_SELF'] );
				die;
			}else{
				$message = join("<br />", $add_new->errors );
			}
	}
}

	$delete_message = "Are you sure you wont to delete this CareerDegree name";

	$career_degree = CareerDegree::find_all();

		$manage_lists = array();
		if($career_degree && is_array($career_degree)){
			$i=1;
			foreach( $career_degree as $list ):			
			  $manage_lists[$i]['id'] = $list->id;		 
			  $manage_lists[$i]['career_name'] = $list->career_name;
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
$smarty->assign('rendered_page', $smarty->fetch('admin/view_career_degree.tpl') );
$smarty->display('admin/index.tpl');
?>