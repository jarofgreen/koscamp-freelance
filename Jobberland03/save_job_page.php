<?php $_SESSION['direct_to'] = BASE_URL."save_job/"; 	
	 include_once('sessioninc.php');
	 
	$username = $session->get_username();
	$user_id = $session->get_user_id();
	
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "save_job" ) {
		$job_id = $_GET['id'];
		$savejob = new SaveJob();
		$savejob->fk_employee_id	= $user_id;
		$savejob->fk_job_id 		= $job_id;
		
		if( !$savejob->already_existed() ){
			
			$savejob = new SaveJob();
			$savejob->fk_employee_id	= $user_id;
			$savejob->fk_job_id 		= $job_id;
			$savejob->date_saved		= strftime(" %Y-%m-%d %H:%M:%S ", time() );
			
			if( $savejob && $savejob->save() ) {
				$message = "<div class='success'>".format_lang('success','save_job')."</div>";
			}else{
				$message = "<div class='error'>".format_lang('errormsg',40)."</div>";
			}
		}else{
			$message = "<div class='error'>".format_lang('errormsg',41)."</div>";
		}
			$session->message ( $message );
			redirect_to( BASE_URL. "save_job/");
	}
	
	$my_apps = SaveJob::find_by_user_id( $user_id );
	
	if ( !empty( $my_apps ) ){
		$apps = array();
		$i=1;
		foreach( $my_apps as $app ):
		  $job_id = $app->fk_job_id;
		  $job = Job::find_active_job_by_id ( $job_id );
		  $apps[$i]['job_id'] = $job_id;
		  
		  if ($job){
			$apps[$i]['job_title'] = $job->job_title;
			$apps[$i]['created_at'] = strftime(DATE_FORMAT, strtotime($job->created_at) );
			$apps[$i]['contact_name'] = $job->contact_name;
			$apps[$i]['poster_email'] = $job->poster_email;
			$apps[$i]['job_url'] = "job/".$job->var_name."/";
		  }
		  
			$apps[$i]['date_saved'] = strftime(DATE_FORMAT, strtotime($app->date_saved) );		  
			$apps[$i]['id'] = $app->id;
		  
		  $i++;
		endforeach;
		$smarty->assign( 'save_job', $apps );
	}
	
	/**deleting */
	if( isset($_GET['delete']) ){
		if( isset($_GET['delete']) && isset($_GET['job_id']) &&  $_GET['delete'] == true ){
			$save_job = new SaveJob();
			$save_job->fk_employee_id = $user_id;
			$save_job->fk_job_id 	  = (int)$_GET['job_id'];
			$save_job->id 			  = (int)$_GET['id'];
			if( $save_job->delete_saveJob() )
			{
				$message = "<div class='success'>".format_lang('success','delete_success')."</div>";
			}else{
				$message = "<div class='error'>".format_lang('errormsg',42)."</div>";
			}
		}
		$session->message ( $message );
		redirect_to(BASE_URL. "save_job/");
	}

$html_title 		= SITE_NAME . " -  ".format_lang('page_title','save_job'). chr(10).strip_html($employee->full_name() );
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('save_job.tpl') );
?>