<?php $_SESSION['direct_to_emp'] = "myjobs/"; 	
	 include_once('sessioninc.php');

	$user_id = $session->get_user_id();
	$user = Employer::find_by_id( $user_id );
	$total_post			  = $user->total_job_post();
	$total_spotlight_post = $user->total_spotlight_job_post();
	$smarty->assign('standard_credit', $total_post);
	$smarty->assign('spotlight_credit', $total_spotlight_post);


	
	$job = new Job;
	$job->fk_employer_id = $user_id;
	$job->id =(int)$_GET['id'];
	
if( isset($_GET['action']) && $_GET['action'] != '' ){
	$job_id = (int)$_GET['id'];
	
	//deactive job
	if(  $_GET['action'] == "deactivate" && isset($_GET['id']) ) {
		if( $job->deactive_job_by_user() ){
			$session->message( "<div class='success'>".format_lang('success','deactivate_job')."</div>" );
		}else{
			$session->message( "<div class='error'>".format_lang( 'error','deactivate_job' )."</div>" );
		}
	}
	
	//active job
	else if(  $_GET['action'] == "activate" && isset($_GET['id']) ) {
		if( $job->active_job_by_user() ){
			$session->message( "<div class='success'>".format_lang('success','activated_job')."</div>" );
		}else{
			$session->message( "<div class='error'>".format_lang('error','activated_job')."</div>" );
		}
	}
	
	//delete job
	else if( $_GET['action'] == "delete" && isset($_GET['id']) ) { 	
		if( $job->delete_by_user() )
		{
			$session->message( "<div class='success'>".format_lang('success','delete_job')."</div>" );
		}else{
			$session->message( "<div class='error'>".format_lang('error','delete_job')."</div>" );
		}
	}
	
	//clone job
	else if( $_GET['action'] == "clone" && isset($_GET['id']) ) { 
		//$user_id = $session->get_user_id();
		$employer = Employer::find_by_id( $user_id );
		$total_post			  = $employer->total_job_post();
		$total_spotlight_post = $employer->total_spotlight_job_post();
	
		$job = new Job;
		$job->fk_employer_id=(int)$user_id;
		$job->id = $id;
		$job = $job->clone_job( $job_id, $user_id );
		$job->views_count = 0;
		$job->apply_count = 0;
		$job->created_at = strftime(" %Y-%m-%d %H:%M:%S ", time() );
		$job->modified = strftime(" %Y-%m-%d %H:%M:%S ", time() );
		unset( $job->id );
		
		if( FREE_SITE == "N" || FREE_SITE == "0" || FREE_SITE == false ) : 
			//this is spotlight
			if( $job->spotlight == "Y" ){	
				if( $total_spotlight_post <= 0 ):
					$session->message( '<div class="error">'.format_lang('total_spotlight_post').'</strong></div>');
					redirect_to(BASE_URL."employer/credits/");
					die;
				endif;
			}else{
				if( $total_post <= 0 ):
					$session->message( '<div class="error">'.format_lang('total_jobpost').'</strong></div>');
					redirect_to(BASE_URL."employer/credits/");
					die;
				endif;
			}
		endif;
	
		//add job to database
		if( $job->save() ){
			$new_job_id = $db->insert_id();
			
			$jobcategory = new JobCategory;
			######## GET CAT ID ###############
			$jobcategory->job_id = (int)$job_id;
			$cats = $jobcategory->get_cat_by_job_id();
			foreach( $cats as $t ){						
				$cat_added = JobCategory::make( $t->category_id, $new_job_id );
				$cat_added->save();
			}
			
			################# JOB TYPE ##################
			$job_type_ns = Job2Type::find_all_type_by_jobid( $job_id );
				foreach( $job_type_ns as $job_type ):
					$type_added = new Job2Type;
					$type_added->fk_job_id 		= (int)$new_job_id;
					$type_added->fk_job_type_id = (int)$job_type->fk_job_type_id;
					$type_added->save();
				endforeach;
				
			########## job_statu_id #######################
			$job_statu_ns = Job2Status::find_by_job_id($job_id);
				foreach( $job_statu_ns as $job_statuss ):
					$status_added = Job2Status::make(  $new_job_id, $job_statuss->fk_job_status_id );
					$status_added->save();
				endforeach;					
		}else{
			$session->message("Error cloning this job ".$db->mysql_db_error() );
		}
	
		//update they job value
		if( FREE_SITE == "N" || FREE_SITE == "0" || FREE_SITE == false ): 
			if( $job->spotlight == "Y" ){
				$employer->update_spotlight_job_post();
			}else{
				$employer->update_job_post();
			}
		endif;
	
		redirect_to(BASE_URL."employer/myjobs/");
	}
}
	$my_jobs = $job->get_list_of_jobs_by_employer_id();
	
if($my_jobs){
	$manage_list =array();
	$i=1;
	foreach( $my_jobs as $my_job ):
		$manage_list[$i]['id']          = $my_job->id;
		$manage_list[$i]['var_name']    = $my_job->var_name;
		$manage_list[$i]['job_title']   = $my_job->job_title;
		$manage_list[$i]['is_active']   = $my_job->is_active;
		$manage_list[$i]['created_at']  = strftime( DATE_FORMAT ,strtotime($my_job->created_at)); 
		$manage_list[$i]['views_count'] = $my_job->views_count; 
		$manage_list[$i]['apply_count'] = $my_job->apply_count;
		$manage_list[$i]['spotlight'] 	= $my_job->spotlight;
	
		if( $my_job->job_status == "rejected" ) {
			$manage_list[$i]['job_status'] 		=  $my_job->job_status;
			$manage_list[$i]['reason'] 			= "Reason for rejection: ";
			$manage_list[$i]['admin_comments'] 	= $my_job->admin_comments;
		}elseif( $my_job->job_status != "approved" ){
			$manage_list[$i]['job_status'] 		=  $my_job->job_status;
			$manage_list[$i]['reason'] 			= "Reason for rejection: ";
			$manage_list[$i]['admin_comments'] 	= $my_job->admin_comments;
		}else{
			$manage_list[$i]['job_status'] 		=  $my_job->job_status;
			$manage_list[$i]['reason'] 			= "";
			$manage_list[$i]['admin_comments'] 	= "";
		}
		$i++;
	endforeach;	
	$smarty->assign('manage_list', $manage_list);
}

$smarty->assign('dont_include_left', true);



$html_title 		= SITE_NAME . " - ".format_lang("page_title", 'MyJobs');
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );
$smarty->assign('rendered_page', $smarty->fetch('employer/my_jobs.tpl') );
//my_jobs.tpl
?>