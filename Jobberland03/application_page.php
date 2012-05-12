<?php $_SESSION['direct_to'] = BASE_URL."applications/"; 	
	 include_once('sessioninc.php');
	 
	 destroy_my_session();
	 
	$username = $session->get_username();
	$user_id = $session->get_user_id();
	
	$my_apps = JobHistory::find_by_user_id( $user_id );
	
	if ( !empty( $my_apps ) ){
		
		$apps = array();
		$i=1;
		foreach( $my_apps as $app ):
		  $job_id = $app->fk_job_id;
		  $job = Job::find_active_job_by_id ( $job_id );
		  $apps[$i]['job_id'] = $job_id;

		  if ($job){
			$apps[$i]['job_title'] = $job->job_title;
			$apps[$i]['contact_name'] = $job->contact_name;
			$apps[$i]['poster_email'] = $job->poster_email;
			$apps[$i]['created_at'] = strftime(DATE_FORMAT, strtotime($job->created_at) );
			$apps[$i]['job_url'] = "job/".$job->var_name."/";
		  }
		  
			$apps[$i]['date_apply'] = strftime(DATE_FORMAT, strtotime($app->date_apply) );
			$apps[$i]['cover_letter'] = $app->cover_letter ;
			$apps[$i]['cv_name'] = $app->cv_name;
			$apps[$i]['id'] = $app->id;
		  
		  $i++;
		endforeach;
		
		$smarty->assign( 'application', $apps );	
		
	}else{
		//$message = "<div class='error'>No application(s) found</div>";
	}
	
	
	if( isset($_GET['delete']) ){
		if( isset($_GET['delete']) && isset($_GET['job_id']) &&  $_GET['delete'] == true ){
			$jobhistory = new JobHistory();
			$jobhistory->fk_employee_id	= $user_id;
			$jobhistory->fk_job_id 		= (int)$_GET['job_id'];
			$jobhistory->id 			= (int)$_GET['id'];
			
			if($jobhistory->delete_job())
			{
				$session->message ("<div class='success'>".format_lang('success','app_delete_success')."</div>");
				redirect_to( BASE_URL."applications/");	
			}else{
				$message = "<div class='error'>".format_lang('errormsg', 06)."</div>";
			}
		}
	}

$html_title 		= SITE_NAME . " - ".format_lang('page_title','my_app')." ".strip_html($employee->full_name() );
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('application.tpl') );
?>