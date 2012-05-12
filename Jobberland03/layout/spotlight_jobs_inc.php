<?php 
	$job = new Job();
	$job_var_name = return_url();
	$var_name = isset($job_var_name[1]) ? $database->escape_value($job_var_name[1]) : '0';
	$spotlight_jobs = $job->list_spotlight($var_name); 

if ( $spotlight_jobs ) {
	if ( sizeof($spotlight_jobs) > 4 ) {
		$size = 100 / 4;
	}else{
		$size = 100 / sizeof($spotlight_jobs);
	}
	
	$smarty->assign('size', $size);

	$i=0;
	$y=4;
	$spotlight = array();
	$word = 300;
	
	$k=1;
	foreach ( $spotlight_jobs as $job ):
		$spotlight[$k]['job_title'] = $job->job_title;
		$body = $job->job_description;
		
		if ( $size >= 50 ){
			$word = 300 / sizeof($spotlight_jobs);
			$word = round($word);
		}
		$spotlight[$k]['job_description'] = subtrack_string($body, $word );
		$spotlight[$k]['var_name'] = $job->var_name;
		
		$city = City::find_by_code( $job->country, $job->state_province, $job->county, $job->city );
		$city_name = empty($city) ? $job->city :  $city->name;
		$spotlight[$k]['location'] = $city_name;
		$spotlight[$k]['created_at'] = strftime(DATE_FORMAT, strtotime($job->created_at) );
		
		$k++;
		$i++;
		
	    if( $i ==  $y ){ 
			$y = $y+4;
			$spotlight[$k]['new_line'] = 1;
		}else{
			$spotlight[$k]['new_line'] = 0;
		}
		
	endforeach;
	$smarty->assign('spotlight', $spotlight);
}else{
	include_once("layout/latest_job_inc.php");
}

$smarty->assign('lang', $lang);
$smarty->assign('spotlight_jobs', $smarty->fetch('spotlight_jobs_inc.tpl') );
//spotlight_jobs_inc.tpl
?>