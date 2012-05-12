<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	$job = new Job();
	$smarty->assign( 'job_id', $_POST['job_id'] );
	
###################### DELETE ####################################		
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "delete" ){
		$job->id = (int)$_GET['id'];
		$job->delete();
	}
	
	if(isset($_POST['delete_all']) && $_POST['job_id'] != "" && sizeof($_POST['job_id']) != 0 ){
		//$job->admin_comments = $_POST['reject_reason'];
		foreach( $_POST['job_id'] as $key => $value ){
			if($value != "" ) {
				$job->id = (int)$value;
				if($job->delete()){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Job(s) has been deleted </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
	
###################### deactivate ####################################		
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "deactivate" ){
		$job->id = $_GET['id'];
		$job->deactive_job();
		$session->message("<div class='success'>Job(s) has been actived </div>");
		redirect_to( $_SERVER['PHP_SELF'] );
		die;
	}
	
	if(isset($_POST['deactivate_all']) && $_POST['job_id'] != "" && sizeof($_POST['job_id']) != 0 ){
		//$job->admin_comments = $_POST['reject_reason'];
		foreach( $_POST['job_id'] as $key => $value ){
			if($value != "" ) {
				$job->id = $value;
				if($job->deactive_job()){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Job(s) has been deactivated </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
	
###################### activate ###################################	
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "activate" ){
		$job->id = $_GET['id'];
		$job->active_job();
		$session->message("<div class='success'>Job(s) has been actived </div>");
		redirect_to( $_SERVER['PHP_SELF'] );
		die;
	}
	if(isset($_POST['activate_all']) && $_POST['job_id'] != "" && sizeof($_POST['job_id']) != 0 ){
		//$job->admin_comments = $_POST['reject_reason'];
		foreach( $_POST['job_id'] as $key => $value ){
			if($value != "" ) {
				$job->id = $value;
				if($job->active_job()){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Job(s) has been actived </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
	
################### reject jobs ##################################	
	if( sizeof($_POST['job_id']) != 0 && isset($_POST['job_id']) ){
		$job_id=array();
		foreach( $_POST['job_id'] as $key => $value ){
			if($value != "" ) {
				$job_id[]=$value;
			}
		}
	}
	
	/*** this to reject jobs */
	if(isset($_POST['reject_reason_btn']) && $_POST['job_id'] != "" && sizeof($_POST['job_id']) != 0){
		$job->admin_comments = $_POST['reject_reason'];
		foreach( $_POST['job_id'] as $key => $value ){
			if($value != "" ) {
				$job->id = $value;
				if( $job->reject_job() ){ $success=true;}
			}
		}
		
		if($success){
			$session->message("<div class='success'>Job(s) has been rejected</div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
	
######################## approved #######################	
	if(isset($_POST['approve_all']) && $_POST['job_id'] != "" && sizeof($_POST['job_id']) != 0){
		//$job->admin_comments = $_POST['reject_reason'];
		foreach( $_POST['job_id'] as $key => $value ){
			if($value != "" ) {
				$job->id = $value;
				if($job->approve_job()){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Job(s) has been approved</div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}

############### repost job #######################
if(isset($_POST['repost_btn']) && $_POST['job_id'] != "" && sizeof($_POST['job_id']) != 0){
		//$job->admin_comments = $_POST['reject_reason'];
		foreach( $_POST['job_id'] as $key => $value ){
			if($value != "" ) {
				$job->id = $value;
				$job->created_at = strftime(" %Y-%m-%d %H:%M:%S ", time() );
				if($job->repost()){ $success=true;}
			}
		}

		if($success){
			$session->message("<div class='success'>Job(s) has been reposted</div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
}

############### spotlight_all job #######################
if(isset($_POST['act_spotlight_all']) && $_POST['job_id'] != "" && sizeof($_POST['job_id']) != 0){
		//$job->admin_comments = $_POST['reject_reason'];
		foreach( $_POST['job_id'] as $key => $value ){
			if($value != "" ) {
				$job->id = $value;
				//$job->created_at = strftime(" %Y-%m-%d %H:%M:%S ", time() );
				if($job->spotlight_activate() ){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Job(s) has been Set as Spotlight</div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
}

if(isset($_POST['dea_spotlight_all']) && $_POST['job_id'] != "" && sizeof($_POST['job_id']) != 0){
		//$job->admin_comments = $_POST['reject_reason'];
		foreach( $_POST['job_id'] as $key => $value ){
			if($value != "" ) {
				$job->id = $value;
				//$job->created_at = strftime(" %Y-%m-%d %H:%M:%S ", time() );
				if($job->spotlight_deactivate() ){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Job(s) has been remove from Spotlight</div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
}

		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$per_page = JOBS_PER_SEARCH;
		$total_count = sizeof($job->list_all_approve_jobs());
		
		$smarty->assign( 'total_count', $total_count );
		
		$pagination = new Pagination( $page, $per_page, $total_count );
		
		$smarty->assign( 'previous_page', $pagination->previous_page() );
		$smarty->assign( 'has_previous_page', $pagination->has_previous_page() );
		$smarty->assign( 'total_pages', $pagination->total_pages() );
		
		$smarty->assign( 'has_next_page', $pagination->has_next_page() );
		$smarty->assign( 'next_page', $pagination->next_page());
						
		$offset = $pagination->offset();
		$sql=" SELECT * FROM ".TBL_JOB;
		$sql .= " WHERE job_status='approved' ";
		$sql.=" LIMIT {$per_page} ";
		$sql.=" OFFSET {$offset} ";
		$lists = Job::find_by_sql( $sql );
		
		$manage_lists = array();
		if($lists && is_array($lists)){
			$i=1;
			foreach( $lists as $list ):			
			  $employer = Employer::find_by_id($list->fk_employer_id);
			  $manage_lists[$i]['id'] = $list->id;		 
			  $manage_lists[$i]['job_title'] = $list->job_title;
			  $manage_lists[$i]['spotlight'] = ($list->spotlight == "Y") ? "Spotlight Job" : "Standard Job";
			  $manage_lists[$i]['created_at'] = strftime( DATE_FORMAT, strtotime($list->created_at));
			  $manage_lists[$i]['employer_name'] =  empty($employer) ? 'Employer not found' : $employer->full_name();
			  $manage_lists[$i]['employer_id'] =  $employer->id;
			  $manage_lists[$i]['employer_username'] =  $employer->username;
			  $manage_lists[$i]['views_count'] = $list->views_count ;
			  $manage_lists[$i]['apply_count'] = $list->apply_count ;
			  $manage_lists[$i]['is_active'] = ($list->is_active == "Y") ? "Active" : "Not Active";
			  $manage_lists[$i]['job_status'] = $list->job_status ;
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
		}
		
		$smarty->assign( 'query', $query );
		
$smarty->assign( 'titles', get_lang ('titles') );
$html_title = SITE_NAME . " Add New Employer ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/manage_approved.tpl') );
$smarty->display('admin/index.tpl');	
unset( $_SESSION['message']);	
?>