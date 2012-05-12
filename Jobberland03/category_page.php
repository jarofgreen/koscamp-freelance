<?php $category_url = return_url();
	$page = $category_url[0];
		
	if( !empty ($category_url[1]) ){
		$category_name = $category_url[1];
		$category = Category::find_by_var_name( $category_name );
		
		if($category){
				$page = "job_by_category";
				$smarty->assign('cat_var_name', $category_name);
		}else{
			redirect_to( BASE_URL."page-unavailable/" );
			$page = "not_found";
		}
	}

	switch( $page ){
		
		case "category":
			$jobcategory = new JobCategory();
			$job_by_cats = $jobcategory->find_active_category();
		  
		  if($job_by_cats){
			$cat = array();
			$i=1;
			foreach( $job_by_cats as $job_by_cat ):
				 $job_id = $job_by_cat->job_id;
				 $cat_id = $job_by_cat->category_id;
			
				$total_jobs = JobCategory::get_total_job_by_cat ( $cat_id );
				
				$cat[$i]['total'] = $total_jobs;
				
				if( Job::find_active_job_by_id( $job_id ) ){
					$cat_name = Category::find_by_id( $cat_id );
					
					/**check length of text */
					$cat_names = strlen($cat_name->cat_name) > 60  ? substr( $cat_name->cat_name ,0 ,30 ). " ... " : $cat_name->cat_name;
					
					$cat[$i]['cat_name'] = $cat_names;
					$cat[$i]['cat_id'] = $cat_id;
					$cat[$i]['var_name'] = $cat_name->var_name;
					
					}
				$i++;
			endforeach;
			
			$smarty->assign('cat', $cat);
			
			$html_title = SITE_NAME . " - ".format_lang('page_title', 'category');
		  }
		  	$smarty->assign('lang', $lang);
			$smarty->assign( 'message', $message );	
			$smarty->assign('rendered_page', $smarty->fetch('category.tpl') );
		break;
		
		case "job_by_category":
		
			$cat_id = $category_name = $category_url[1];
			$category = Category::find_by_var_name( $category_name );
			
			
		  if($category){
			$id = 	$category->id;
			
			$jobcategory = new JobCategory();					
			
			$num_rows = sizeof($jobcategory->list_job_by_cat_search_total( $id ) );

			//$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
			$page_no = (!empty($category_url[2]) ) ? (int)$category_url[2] : 1;
	
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
	
	///888888			
			$record_sets = $jobcategory->list_job_by_cat( $id, $per_page, $offset );
			
			$cat_name = Category::find_by_id( $id );
			$cat_name_result = $cat_name->cat_name;
			
			$job_cat = array();
			$i=1;
			foreach( $record_sets as $job_by_cat ):
				 $job_id = $job_by_cat->job_id;
				 $job = Job::find_active_job_by_id( $job_id );		
				if( $job ){
					$job_name = strlen($job->job_title) > 60  ? substr( $job->job_title ,0 ,30 ). " ... " : $job->job_title;
					
					$job_cat[$i]['job_name'] = $job_name;
					$job_cat[$i]['job_id'] = $job_id;
					$job_cat[$i]['var_name'] = $job->var_name;					
				}
				$i++;
			endforeach;
			$smarty->assign('cat_by_job', $job_cat);
			$smarty->assign('cat_name', $cat_name_result);

			
			$html_title = SITE_NAME . " - ". $cat_name_result;
			//$meta_description = "";
		  }
		    $smarty->assign('lang', $lang);
			$smarty->assign( 'message', $message );	
			$smarty->assign('rendered_page', $smarty->fetch('job_category.tpl') );
		break;
		
		case "not_found":
			
		    $smarty->assign('lang', $lang);
			$smarty->assign( 'message', $message );	
			//$smarty->assign('rendered_page', $smarty->fetch('category_not_found.tpl') );
			
		break;
		
	}
/*
$both = array_merge($t1, $t2);
$t3 =  array_unique($both ); 
*/
?>