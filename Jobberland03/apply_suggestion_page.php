<?php $req = return_url();	
	$var_name = $req[1];

$job = new Job();
$jobs = $job->find_by_var_name_active( $var_name );

if (!$jobs) { redirect_to( BASE_URL."page-unavailable/" ); }

$employer = Employer::find_by_id( $jobs->fk_employer_id );

$country_arry = Country::find_by_code( $jobs->country );
$country_name = $country_arry->name;

$city = City::find_by_code( $jobs->country, $jobs->state_province, $jobs->county, $jobs->city );
$city_name = empty($city) ? $jobs->city : $city->name;

$smarty->assign('apply_for', $jobs->job_title ." ".strtolower(format_lang('at')) . " ".$employer->company_name . " ".strtolower(format_lang('in')) . " ". $city_name . ", ". $country_name );

unset($employer, $city,  $country_arry );

//Congratulations! You've applied for:
//IT Manager at IT Lab in London EC1A 9PT

if( $jobs )
{
	$job_s = array();
	$i=1;
	$job_suggestions = Job::apply_suggestion( $jobs->job_title, $var_name );
	
	foreach( $job_suggestions as $job_suggestion ):
	  $employer = Employer::find_by_id( $job_suggestion->fk_employer_id );
	  
//locations
	//country 
$country_arry = Country::find_by_code( $job_suggestion->country );
$country_name = $country_arry->name;
	//states
$state = StateProvince::find_by_code( $job_suggestion->country, $job_suggestion->state_province );
$state_name = empty($state) ? $job_suggestion->state_province : $state->name; 
	//county
$county = County::find_by_code( $job_suggestion->country, $job_suggestion->state_province, $job_suggestion->county );
$county_name = empty($county) ? $job_suggestion->county : $county->name;
	//city
$city = City::find_by_code( $job_suggestion->country, $job_suggestion->state_province, $job_suggestion->county, $job_suggestion->city );
$city_name = empty($city) ? $job_suggestion->city : $city->name;
//end	  
	  $job_s[$i]['id'] 			= $job_suggestion->id;
	  $job_s[$i]['var_name'] 	= $job_suggestion->var_name;
	  $job_s[$i]['job_title'] 	= $job_suggestion->job_title;
	  $job_s[$i]['company_name']= $employer->company_name;
	  $job_s[$i]['created_at'] 	= strftime(DATE_FORMAT, strtotime($job_suggestion->created_at) );
	  $job_s[$i]['location'] 	= $city_name.", ". $county_name.", ".$state_name.", ".$country_name;
	  
	  $i++;
	endforeach;
	
	$smarty->assign('job_suggestion', $job_s);
}

$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('apply_suggestion.tpl') );
?>