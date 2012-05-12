<?php  require_once( "../initialise_files.php" );  
		
	include_once("sessioninc.php");
	
	$employer 	= new Employer();

	$smarty->assign( 'employer_id', $_POST['employer_id'] );
	
###################### DELETE ####################################		
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "delete" ){
		$employer->id = (int)$_GET['id'];
		$employer->delete();
	}
	
	if(isset($_POST['delete_all']) && $_POST['employer_id'] != "" && sizeof($_POST['employer_id']) != 0 ){
		foreach( $_POST['employer_id'] as $key => $value ){
			if($value != "" ) {
				$employer->id = (int)$value;
				if($employer->delete()){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Employee(s) has been deleted </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
	
###################### deactivate ####################################		
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "deactivate" ){
		$employer->id = $_GET['id'];
		$employer->deactive_user();
	}
	if(isset($_POST['deactivate_all']) && $_POST['employer_id'] != "" && sizeof($_POST['employer_id']) != 0 ){
		foreach( $_POST['employer_id'] as $key => $value ){
			if($value != "" ) {
				$employer->id = $value;
				if( $employer->deactive_user() ){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Employee(s) has been deactivated </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
	
###################### activate ###################################	
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "activate" ){
		$employer->id = $_GET['id'];
		$employer->active_user();
	}
	if(isset($_POST['activate_all']) && $_POST['employer_id'] != "" && sizeof($_POST['employer_id']) != 0 ){
		foreach( $_POST['employer_id'] as $key => $value ){
			if($value != "" ) {
				$employer->id = $value;
				if( $employer->active_user() ){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Employee(s) has been actived </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}

################# Add credits ####################################
	if( sizeof($_POST['employer_id']) != 0 && isset($_POST['employer_id']) ){
			$employer_id=array();
			foreach( $_POST['employer_id'] as $key => $value ){
				if($value != "" ) {
					$employer_id[]=$value;
				}
			}
	}
	
	if( $_POST['employer_id'] != "" && sizeof($_POST['employer_id']) != 0 ) {
		if( isset($_POST['cv_credit_all']) && !empty($_POST['txt_credits']) ){
			foreach( $_POST['employer_id'] as $key => $value ){
				if($value != "" ) {
					$username = Employer::find_by_id($value);
					$employer->username = $username->username;
					$employer->cv_qty = (int)$_POST['txt_credits'];
					if( $employer->add_cvs() ){ $success=true;}
				}
			}
		}
		if( isset($_POST['spotlight_credit_all']) && !empty($_POST['txt_credits']) ){
			foreach( $_POST['employer_id'] as $key => $value ){
				if($value != "" ) {
					$username = Employer::find_by_id($value);
					$employer->username = $username->username;
					$employer->spotlight_qty = (int)$_POST['txt_credits'];
					if( $employer->add_more_spotlight_job_post() ){ $success=true;}
				}
			}
		}
		if( isset($_POST['job_credit_all']) && !empty($_POST['txt_credits']) ){
			foreach( $_POST['employer_id'] as $key => $value ){
				if($value != "" ) {
					$username = Employer::find_by_id($value);
					$employer->username = $username->username;
					$employer->job_qty = (int)$_POST['txt_credits'];
					if( $employer->add_more_job_post() ){ $success=true;}
				}
			}
		}
		if($success){
			$session->message("<div class='success'>Credit(s) has been added</div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
	

###############################################################################
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$per_page = JOBS_PER_SEARCH;
		$total_count = Employer::count_all();
		
		$smarty->assign( 'total_count', $total_count );
		$smarty->assign( 'page', $page );
		
		$pagination = new Pagination( $page, $per_page, $total_count );
		
		$smarty->assign( 'previous_page', $pagination->previous_page() );
		$smarty->assign( 'has_previous_page', $pagination->has_previous_page() );
		$smarty->assign( 'total_pages', $pagination->total_pages() );
		
		$smarty->assign( 'has_next_page', $pagination->has_next_page() );
		$smarty->assign( 'next_page', $pagination->next_page());
		
		$offset = $pagination->offset();
		$sql=" SELECT * FROM ".TBL_EMPLOYER;
		$sql.=" LIMIT {$per_page} ";
		$sql.=" OFFSET {$offset} ";
		$lists = Employer::find_by_sql( $sql );
		
		$manage_lists = array();
		if($lists && is_array($lists)){
			$i=1;
			foreach( $lists as $list ):

			  $manage_lists[$i]['id'] 				= $list->id;
			  $manage_lists[$i]['employee_id'] 		= $list->id;
			  $manage_lists[$i]['username'] 		= $list->username;
			  $manage_lists[$i]['email_address'] 	= $list->email_address;
              $manage_lists[$i]['cv_qty'] 			= $list->cv_qty;
              $manage_lists[$i]['job_qty'] 			= $list->job_qty;
              $manage_lists[$i]['spotlight_qty'] 	= $list->spotlight_qty;
			  $manage_lists[$i]['date_register'] 	= strftime( DATE_FORMAT, strtotime($list->date_register));
			  $manage_lists[$i]['last_login'] 		= strftime( DATE_FORMAT, strtotime($list->last_login));
			  $manage_lists[$i]['is_active'] 		= $list->is_active;
			  $manage_lists[$i]['employer_status'] 	= $list->employer_status ;
			  $i++;
			  
			endforeach;
			$smarty->assign( 'manage_lists', $manage_lists );
		}
		
		$query = "1=1";
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
$smarty->assign('rendered_page', $smarty->fetch('admin/manage_employer.tpl') );
$smarty->display('admin/index.tpl');
?>