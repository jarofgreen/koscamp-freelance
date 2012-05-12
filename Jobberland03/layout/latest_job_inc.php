<?php
	$job = new Job();
	$job_var_name = return_url();
	$var_name = isset($job_var_name[1]) ? $database->escape_value($job_var_name[1]) : '0';
	
	$latest_jobs = $job->latest_job($var_name);

if ( $latest_jobs ) {
	
	if ( sizeof($latest_jobs) > 4 ) {
		$size = 100 / 4;
	}else{
		$size = 100 / sizeof($latest_jobs);
	}
	
	$smarty->assign('size', $size);

	$i=0;
	$y=4;
	$word = 300;
	$latest_job = array();
	
	$k=1;
	foreach ( $latest_jobs as $job ):
		$latest_job[$k]['job_title'] = $job->job_title;
		$body = $job->job_description;
		
		if ( $size >= 50 ){
			$word = 300 / sizeof($latest_jobs);
			$word = round($word);
		}
		
		$latest_job[$k]['job_description'] = subtrack_string($body, $word );
		$latest_job[$k]['var_name'] = $job->var_name;
		
		$city = City::find_by_code( $job->country, $job->state_province, $job->county, $job->city );
		$city_name = empty($city) ? $job->city :  $city->name;
		$latest_job[$k]['location'] = $city_name;
		$latest_job[$k]['created_at'] = strftime(DATE_FORMAT, strtotime($job->created_at) );
		
		$k++;
		$i++;
		
	    if( $i ==  $y ){ 
			$y = $y+4;
			$latest_job[$k]['new_line'] = 1;
		}else{
			$latest_job[$k]['new_line'] = 0;
		}
		
	endforeach;
	$smarty->assign('latest_job', $latest_job);
}

$smarty->assign('lang', $lang);
$smarty->assign('latest_jobs', $smarty->fetch('latest_job_inc.tpl') );
//latest_jobs_inc.tpl
?>