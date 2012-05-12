<?php 
$job = new Job();
$job2type 	= new Job2Type();

	$req = return_url();	
	$var_name = $req[1];

	$jobs = $job->find_by_var_name( $var_name );
	$job_id = (int)$jobs->id;

if($jobs && !empty($jobs) )
{
	
	$html_title 		= SITE_NAME . " - ".$jobs->job_title;
	$meta_description 	= seo_words( subtrack_string($jobs->job_description, 250 ) );
	$meta_keywords 		= seo_words( subtrack_string($jobs->job_description, 150 ) );
	$id = (int)$jobs->id;
	
	$jobs->update_views();
	
	//job type
	$type = Job2Type::find_all_type_by_jobid($id);
	$type2=array();
	$i=1;
	foreach( $type as $job_type ):
		$type_name = JobType::find_by_id( $job_type->fk_job_type_id );
		$type2[$i]['name'] = $type_name->type_name;
		$type2[$i]['var_name'] = $type_name->var_name;
		$i++;
	endforeach;
	$smarty->assign('jobtype', 	$type2 );
	
	$smarty->assign('var_name', 		$jobs->var_name );
	$smarty->assign('job_ref', 			$jobs->job_ref );
	$smarty->assign('job_title', 		$jobs->job_title );
	$smarty->assign('job_description', 	$jobs->job_description );
	$smarty->assign('job_postion', 		$jobs->job_postion );
	
	
	//locations
	//country 
	$country_arry = Country::find_by_code( $jobs->country );
	//$country_a($country_arry) ? $country_arry->code : $country_a;
	$country_var_name = $country_arry->var_name;
	$country_name = $country_arry->name;
	$smarty->assign('country', $country_name );
	$smarty->assign('country_url', $country_var_name );

	//states
	$state = StateProvince::find_by_code( $jobs->country, $jobs->state_province );
	$state_name = empty($state) ? $jobs->state_province : $state->name; 
	$state_var_name = ($state) ? $state->var_name : $jobs->state_province;
	$smarty->assign('state', $state_name );
	$smarty->assign('state_url', $country_var_name . "/".$state_var_name."/" );
	
	//county
	$county = County::find_by_code( $jobs->country, $jobs->state_province, $jobs->county );
	$county_name = empty($county) ? $jobs->county : $county->name;
	$county_var_name = ($county) ? $county->var_name : $jobs->county;
	$smarty->assign('county', $county_name );
	$smarty->assign('county_url', $country_var_name . "/". $state_var_name."/".$county_var_name."/" );
	
	$city = City::find_by_code( $jobs->country, $jobs->state_province, $jobs->county, $jobs->city );
	$city_name = empty($city) ? $jobs->city : $city->name;
	$city_var_name = empty($city) ? $jobs->city : $city->var_name;		
	$smarty->assign('city', $city_name );
	$smarty->assign('city_url', $country_var_name . "/".$state_var_name."/".$county_var_name."/".$city_var_name."/" );
	
	//educations
	$educations	= Education::find_by_id( $jobs->fk_education_id );
	$education_name	= !empty($educations) ? $educations->education_name : format_lang('not_provided') ;
	$smarty->assign('education_var_name', $educations->var_name );
	$smarty->assign('education', $education_name );
	
	//career
	$careers	= CareerDegree::find_by_id( $jobs->fk_career_id );
	$smarty->assign('careers', 			$careers );
	$career_name	= $careers ? $careers->career_name : format_lang('not_provided');
	$smarty->assign('career_var_name', 	$careers->var_name );
	$smarty->assign('career', 			$career_name );
	
	//experience
	$experiences = Experience::find_by_id( $jobs->fk_experience_id );
	$smarty->assign('experiences', $experiences );
	$experience_name = !empty( $experiences ) ? $experiences->experience_name : format_lang('not_provided');
	$smarty->assign('experience_var_name', $experiences->var_name );
	$smarty->assign('experience', $experience_name );

	
	$smarty->assign('spotlight', 		$jobs->spotlight );
	
	if( !empty($jobs->job_salary) && !empty($jobs->salaryfreq) ) $job_salary = $jobs->job_salary. format_lang('per') .$jobs->salaryfreq;
	else $job_salary = format_lang('not_provided');	
	$smarty->assign('job_salary', 		$job_salary );
	//$smarty->assign('salaryfreq', 		$jobs->salaryfreq );
	
	$employer = Employer::find_by_id( $jobs->fk_employer_id );
	$company_name = $employer->company_name;
	$employer_var_name = $employer->var_name;
	$smarty->assign('employer_var_name', 	$employer_var_name );
	$smarty->assign('company_name', 	$company_name );
	$smarty->assign('company_logo', 	$employer->company_logo );
	
	$smarty->assign('contact_name', 	$jobs->contact_name );
	
	$telephone = !empty($jobs->contact_telephone) ? $jobs->contact_telephone : format_lang('not_provided');
	$smarty->assign('contact_telephone', $telephone );
	
	$link = !empty($jobs->site_link) ? $jobs->site_link : format_lang('not_provided');	
	$smarty->assign('site_link', 		 $link );
	//$smarty->assign('poster_email', 	$jobs->poster_email );
	
	
	$smarty->assign('views_count', 		$jobs->views_count );
	$smarty->assign('apply_count', 		$jobs->apply_count );
	
	$start_date = !empty($jobs->start_date)? $jobs->start_date : format_lang('not_provided');
	$smarty->assign('start_date', 		$start_date );
	
	$smarty->assign('created_at', 		strftime(DATE_FORMAT, strtotime($jobs->created_at) ) );
	//$smarty->assign('job_startdate', 	$jobs->job_startdate );
	//$smarty->assign('job_enddate', 		$jobs->job_enddate );
	//$smarty->assign('modified', 		$jobs->modified );
	
	//$smarty->assign('is_active', 		$jobs->is_active );
	//$smarty->assign('job_status', 		$jobs->job_status );
	//$smarty->assign('has_been_active', 	$jobs->has_been_active );
	
	//$smarty->assign('admin_first_view', $jobs->admin_first_view );
	//$smarty->assign('admin_status_date', $jobs->admin_status_date );
	//$smarty->assign('admin_comments', 	$jobs->admin_comments );

$smarty->assign('jobs', $jobs );
}else{
	//$message = '<div class="error">'.format_lang('job','not_found').'</div>';
}


$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('job.tpl') );
?>