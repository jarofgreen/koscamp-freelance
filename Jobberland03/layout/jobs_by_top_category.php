<?php 
	/** cat */
	$category_url = return_url();
	$current_category = !empty($category_url[1]) ? $category_url[1] : 0;
	$job_by_cats = JobCategory::top_ten_cat($current_category);
  if($job_by_cats){
	$categorys = array();
	$i=0;
	foreach( $job_by_cats as $job_by_cat ):
		 
		 $job_id = $job_by_cat->job_id;
		 $cat_id = $job_by_cat->category_id;

		$total_jobs = JobCategory::get_total_job_by_cat ( $cat_id );
		if( Job::find_active_job_by_id( $job_id ) ){
			$cat_name = Category::find_by_id( $cat_id );
			
			/**check length of text */
			$cat_names = strlen($cat_name->cat_name) > 25  ? substr( $cat_name->cat_name ,0 ,25 ). " ... " : $cat_name->cat_name;
			
			$categorys[$i]['var_name'] = $cat_name->var_name;
			$categorys[$i]['category_name'] = $cat_names;
			$categorys[$i]['f_category_name'] = $cat_name->cat_name;
			$categorys[$i]['total_num'] = $total_jobs;	
					
			$i++;
		}	
	endforeach;

	$smarty->assign('job_by_cats', $categorys );

	$smarty->assign('job_by_categorys', $smarty->fetch('job_by_top_categorys.tpl') );
  }
?>