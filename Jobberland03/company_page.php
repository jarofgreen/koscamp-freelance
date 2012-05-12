<?php 
	$company_url = return_url();
	$page = $company_url[0];
	
	if( !empty ($company_url[1]) ){
		$company_name = $company_url[1];
		
		$company = Employer::find_by_var_name( $company_name );
		
		if($company){
			$smarty->assign('company_var_name', $company_name);
			$page = "job_by_company";
		}else{
			$page = "not_found";
		}
	}

	switch( $page ){
		
		case "company":
		   $jobcompany = Job::list_job_by_employer();
		   if($jobcompany){
			$company = array();
			$i=1;
			foreach( $jobcompany as $job_by_company ):
				 $employer_id = $job_by_company->fk_employer_id;			
				 $total_jobs = Job::total_job_by_employer ( $employer_id );
				
				$company[$i]['total'] = $total_jobs;
				
				if(  $employer = Employer::find_by_id( $employer_id ) ){
					$name = $employer->company_name;
					
					/**check length of text */
					$names = strlen($employer->company_name) > 60  ? substr( $employer->company_name ,0 ,30 ). " ... " : $employer->company_name;
					
					$company[$i]['name'] = $names;
					$company[$i]['employer_id'] = $employer_id;
					$company[$i]['var_name'] = $employer->var_name;
					
					}
				$i++;
			endforeach;
			
			$smarty->assign('company', $company);
		   }
			$html_title = SITE_NAME . " - ".format_lang('page_title','BrowseBYCompany');
			//$meta_description = "";
				
			$smarty->assign( 'message', $message );	
			$smarty->assign('rendered_page', $smarty->fetch('company.tpl') );
		break;
		
		case "job_by_company":
		
			$company_id = $company_name = $company_url[1];
			$company = Employer::find_by_var_name( $company_name );
			$id = 	$company->id;
			
			$num_rows = sizeof( Job::job_by_employer($id) );

			$page_no = (!empty($company_url[2]) ) ? (int)$company_url[2] : 1;
	
			$per_page = (JOBS_PER_SEARCH <= $num_rows) ? JOBS_PER_SEARCH : $num_rows;
			$per_page = $per_page == 0 ? 1 : $per_page; 
			$total_count = $num_rows;
	
			$smarty->assign( 'total_count', $total_count );
			$smarty->assign( 'page', $page_no );
			
			$pagination = new Pagination( $page_no, $per_page, $total_count );
			
			$smarty->assign( 'previous_page', $pagination->previous_page() );
			$smarty->assign( 'has_previous_page', $pagination->has_previous_page() );
			$smarty->assign( 'total_pages', $pagination->total_pages() );
			
			$smarty->assign( 'has_next_page', $pagination->has_next_page() );
			$smarty->assign( 'next_page', $pagination->next_page());
			
			$offset = $pagination->offset();
			
			$smarty->assign( 'offset', $offset );
			$smarty->assign( 'per_page', $per_page );
			
			$jobcompany = Job::job_by_employer($id, $per_page, $offset);
			$company_name_result = $company->company_name;
			
			$job_company = array();
			$i=1;
			foreach( $jobcompany as $job_by_company ):
				 $job_id = $job_by_company->id;
				 $job = Job::find_active_job_by_id( $job_id );		
				if( $job ){
					$job_name = strlen($job->job_title) > 60  ? substr( $job->job_title ,0 ,30 ). " ... " : $job->job_title;
					
					$job_company[$i]['job_name'] = $job_name;
					$job_company[$i]['job_id'] = $job_id;
					$job_company[$i]['var_name'] = $job->var_name;					
				}
				$i++;
			endforeach;
			$smarty->assign('company_by_job', $job_company);
			$smarty->assign('company_name', $company_name_result);

			
			$html_title = SITE_NAME . " - ". $company_name_result;
			//$meta_description = "";
			
			$smarty->assign( 'message', $message );	
			$smarty->assign('rendered_page', $smarty->fetch('job_company.tpl') );
		break;
		
		case "not_found":
			redirect_to(BASE_URL . 'page-unavailable/');
			exit;	
		break;
		
		default:
						
		break;
	}
/*
$both = array_merge($t1, $t2);
$t3 =  array_unique($both ); 
*/
?>