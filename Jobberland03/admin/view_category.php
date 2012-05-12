<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	$smarty->assign( 'action', $_GET['action'] );
	$smarty->assign( 'id', (int)$_GET['id'] );
	
if( isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) ) { 
    $id = (int)$_GET['id'];
    $cat_ = Category::find_by_id( $id );
    $cat_name = strip_tags($cat_->cat_name);
	
	$smarty->assign( 'cat_name', $cat_name );

		if( isset($_GET['bt_update']) ){
			$category = new Category();
			$category->id = (int)$_GET['id'];
			$category->var_name = $category->mod_write_check($_GET['txt_cat_name'], $cat_->var_name);
			$category->cat_name = $_GET['txt_cat_name'];
			
			if($category->save()){
				$session->message ("category updated ");
				redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
				die;
			}else{
				$message = join("<br />", $category->errors );
			}
		}
}

if( isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) ) { 
	$category = new Category();
	$category->id = (int)$_GET['id'];
	if( $category->delete() ){
		$session->message ("category deleted ");
		redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
		die;
	}else{
		$message = join("<br />", $category->errors );
	}
	
}


if( isset($_GET['action']) && $_GET['action'] == "add" ) { 
		
	if( isset($_POST['bt_add']) ){
			$category = new Category();			
			$category->cat_name	= $_POST['txt_cat'];
			if( $category->save() ){
				$session->message("New Category added.");
				redirect_to( $_SERVER['PHP_SELF'] );
				die;
			}else{
				$message = join("<br />", $category->errors );
			}
	}
	
}

	$category = Category::find_all();

		$manage_lists = array();
		if($category && is_array($category)){
			$i=1;
			foreach( $category as $list ):			
			  $manage_lists[$i]['id'] = $list->id;		 
			  $manage_lists[$i]['cat_name'] = $list->cat_name;
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
				
$smarty->assign( 'titles', get_lang ('titles') );
$html_title = SITE_NAME . " Add New Employer ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/view_category.tpl') );
$smarty->display('admin/index.tpl');
?>