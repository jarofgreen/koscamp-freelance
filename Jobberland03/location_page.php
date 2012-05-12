<?php 
	//global $states_a, $page;
	$location_url = return_url();
	$page = $location_url[0];
	$country_a = $location_url[1];
	$states_a = $location_url[2];
	$county_a = $location_url[3];
	$city_a = $location_url[4];
	
	if (!empty($country_a) && substr($country_a, 0, 6) != "?page=") $page = "country";
	//if (!empty($country_a) ) $page = "country";
	if (!empty($states_a) ) $page = "states";
	if (!empty($county_a) ) $page = "county";
	if (!empty($city_a) ) $page = "city";	

//country
//$country_a = DEFAULT_COUNTRY;
if (!empty($country_a) ) {
	$country_arry = Country::find_by_loc_var( $country_a );
	$country_a = $country_code = ($country_arry) ? $country_arry->code : $country_a;
	$country_var_name = $country_arry->var_name;
	$country_name = $country_arry->name;
}

//states
$state_array = StateProvince::find_by_loc_var( $country_code, $states_a );
$state_code = ( $state_array && !empty($state_array->code)) ? $state_array->code : $states_a;
$states_var_name = ( $state_array && !empty($state_array->var_name)) ? $state_array->var_name : $states_a;
$state_name = ( $state_array && !empty($state_array->name)) ? $state_array->name : $states_a;

//county
$county_array = County::find_by_loc_var( $country_a, $state_code, $county_a );
$county_code = ($county_array) ? $county_array->code : $county_a;
$county_var_name = ( $county_array && !empty($county_array->var_name)) ? $county_array->var_name : $county_a;
$county_name = ($county_array) ? $county_array->name : $county_a;

//city
$city_array = City::find_by_loc_var(  $country_a, $state_code, $county_code, $city_a );
$city_code = ($city_array) ? $city_array->code : $city_a;
$city_var_name = ($city_array) ? $city_array->var_name : $city_a;
$city_name = ($city_array) ? $city_array->name : $city_a;

$smarty->assign('location_name', $city_name);

switch ( $page ){
	case "country":
		//get all StateProvince by country
		$job_states = Job::location_top_link( $country_code );		
		  //if found then
		  if($job_states){
			$activeLink =array();
			$i=1;
			foreach( $job_states as $job_state ){			
				//states - 
				$state_code_a = StateProvince::find_by_code( $country_code, $job_state->state_province );
				$state_var_name = ($state_code_a) ? $state_code_a->var_name : $job_state->state_province;
				$state_name = ($state_code_a) ? $state_code_a->name : $job_state->state_province;
				
				$activeLink[$i]['name'] 		= $state_name;
				$activeLink[$i]['var_name'] 	= $state_var_name;
				$activeLink[$i]['url'] = $country_var_name."/";
				$i++;
			}				
			$smarty->assign('activeLink', $activeLink);
		  }
		  
		///jobs
	  $job_by_locations = Job::list_job_by_location( $country_code );
	  if($job_by_locations){
		$location = array();
		$i=1;
		foreach( $job_by_locations as $job_by_location ):
			
			//states
			$state_code = $job_by_location->state_province;
			$state_ = StateProvince::find_by_code( $country_code, $state_code );
			$state_var_name = ($state_) ? $state_->var_name : $job_by_location->state_province;
			$state_name = ($state_) ? $state_->name : $job_by_location->state_province;
			
			//county
			$county_code = $job_by_location->county;
			$county_ = County::find_by_code( $country_code, $state_code, $county_code );
			$county_var_name = ($county_) ? $county_->var_name : $job_by_location->county;
			
			//city
			$city_code = City::find_by_code( $country_code, $state_code, $county_code, $job_by_location->city );
			$city_var_name = ($city_code) ? $city_code->var_name : $job_by_location->city;
			
			if ($city_code){/**check length of text */
				$location_name = strlen($city_code->name) > 60  ? substr( $city_code->name ,0 ,30 ). " ... " : $city_code->name;
			}else{/**check length of text */
				$location_name = strlen($city_var_name) > 60  ? substr( $city_var_name ,0 ,30 ). " ... " : $city_var_name;
			}
			
			$total_jobs = Job::get_total_job_by_location( $country_code, $state_code, $county_code, $job_by_location->city );
			$location[$i]['total'] = $total_jobs;
								
			$location[$i]['name'] = $location_name;
			$location[$i]['location_id'] = $city->id;
			$location[$i]['var_name'] = $city_var_name;
			$location[$i]['url'] = $country_var_name . "/".$state_var_name."/".$county_var_name."/";
			$i++;	
		endforeach;		
		$smarty->assign('location', $location);
		
		$html_title = SITE_NAME . " - ".format_lang('page_title','BrowseBYLocation')." (".$country_name.") ";
	  }	
	    
		$smarty->assign( 'message', $message );	
		$smarty->assign('rendered_page', $smarty->fetch('location.tpl') );		

	break;
	
	case "states":	
	  $job_counties = Job::location_top_link( $country_code, $state_code );		
	  if($job_counties){
		$activeLink =array();
		$i=1;
		foreach( $job_counties as $job_county ){
			//County
			$county_code = County::find_by_code( $country_code, $state_code, $job_county->county );
			$county_var_name = ($county_code) ? $county_code->var_name : $job_county->county;
			$county_name = ($county_code) ? $county_code->name : $job_county->county;
			
			$activeLink[$i]['name'] 		= $county_name;
			$activeLink[$i]['var_name'] 	= $county_var_name;
			$activeLink[$i]['url'] = $country_var_name."/".$states_var_name."/";
			$i++;
		}				
		$smarty->assign('activeLink', $activeLink);
	  }
	  
		///jobs
		$job_by_locations = Job::list_job_by_location( $country_code, $state_code );
	  if($job_by_locations){
		$location = array();
		$i=1;
		foreach( $job_by_locations as $job_by_location ):
			
			//states
			$state_code = $job_by_location->state_province;
			$state_ = StateProvince::find_by_code( $country_code, $state_code );
			$state_var_name = ($state_) ? $state_->var_name : $job_by_location->state_province;
			$state_name = ($state_) ? $state_->name : $job_by_location->state_province;
			
			//county
			$county_code = $job_by_location->county;
			$county_ = County::find_by_code( $country_code, $state_code, $county_code );
			$county_var_name = ($county_) ? $county_->var_name : $job_by_location->county;
			
			//city
			$city_code = City::find_by_code( $country_code, $state_code, $county_code, $job_by_location->city );
			$city_var_name = ($city_code) ? $city_code->var_name : $job_by_location->city;
			
			if ($city_code){/**check length of text */
				$location_name = strlen($city_code->name) > 60  ? substr( $city_code->name ,0 ,30 ). " ... " : $city_code->name;
			}else{/**check length of text */
				$location_name = strlen($city_var_name) > 60  ? substr( $city_var_name ,0 ,30 ). " ... " : $city_var_name;
			}
			
			$total_jobs = Job::get_total_job_by_location( $country_code, $state_code, $county_code, $job_by_location->city );
			$location[$i]['total'] = $total_jobs;
								
			$location[$i]['name'] = $location_name;
			$location[$i]['location_id'] = $city->id;
			$location[$i]['var_name'] = $city_var_name;
			$location[$i]['url'] = $country_var_name . "/". $state_var_name."/".$county_var_name."/";
			$i++;	
		endforeach;
		
		$smarty->assign('location', $location);
		$html_title = SITE_NAME . " - ".format_lang('page_title','BrowseBYLocation')." (".$state_name.", ".$country_name.") ";
	  }	
		$smarty->assign( 'message', $message );	
		$smarty->assign('rendered_page', $smarty->fetch('location.tpl') );		
	break;
	
	case "county":
		///jobs
		$job_by_locations = Job::list_job_by_location( $country_code, $state_code,  $county_code);
	  if($job_by_locations){
		$location = array();
		$i=1;
		foreach( $job_by_locations as $job_by_location ):			
			
			//states
			$state_code = StateProvince::find_by_code( $country_code, $job_by_location->state_province );
			$state_var_name = ($state_code) ? $state_code->var_name : $job_by_location->state_province;
			
			//county
			$county_code = County::find_by_code( $country_code, $state_code->code, $job_by_location->county );
			$county_var_name = ($county_code) ? $county_code->var_name : $job_by_location->county;
			
			//city
			$city_code = City::find_by_code( $country_code, $state_code->code, $county_code->code, $job_by_location->city );
			$city_var_name = ($city_code) ? $city_code->var_name : $job_by_location->city;
			
			if ($city_code){/**check length of text */
				$location_name = strlen($city_code->name) > 60  ? substr( $city_code->name ,0 ,30 ). " ... " : $city_code->name;
			}else{/**check length of text */
				$location_name = strlen($city_var_name) > 60  ? substr( $city_var_name ,0 ,30 ). " ... " : $city_var_name;
			}
			
			$total_jobs = Job::get_total_job_by_location( $country_code, $state_code->code, $county_code->code, $job_by_location->city );
			$location[$i]['total'] = $total_jobs;
								
			$location[$i]['name'] = $location_name;
			$location[$i]['location_id'] = $city->id;
			$location[$i]['var_name'] = $city_var_name;
			$location[$i]['url'] = $country_var_name."/".$state_var_name."/".$county_var_name."/";
			$i++;
			
		endforeach;
		
		$smarty->assign('location', $location);
		$html_title = SITE_NAME . " - ".format_lang('page_title','BrowseBYLocation')." (".$county_name.", ".$state_name.", ".$country_name.") ";
	  }
	  	$smarty->assign('lang', $lang);
		$smarty->assign( 'message', $message );	
		$smarty->assign('rendered_page', $smarty->fetch('location.tpl') );
	break;
		
	case "city":
		///jobs
		$job_by_locations = Job::list_job_by_location_city( $country_code, $state_code, $county_code,  $city_code );

	  if($job_by_locations){

		//city
		$city_code = City::find_by_code( $country_code, $state_code, $county_code, $job_by_location->city );
		$city_var_name = ($city_code) ? $city_code->var_name : $job_by_location->city;

		$location = array();
		$i=1;
		foreach( $job_by_locations as $job_by_location ):			
			
			$job_id = $job_by_location->id;
			$job = Job::find_active_job_by_id( $job_id );		
			if( $job ){
				$job_name = strlen($job->job_title) > 60  ? substr( $job->job_title ,0 ,30 ). " ... " : $job->job_title;
					
				$location[$i]['job_name'] = $job_name;
				$location[$i]['job_id'] = $job->id;
				$location[$i]['var_name'] = $job->var_name;
			}
			$i++;
						
		endforeach;
		
		$smarty->assign('location', $location);
		$html_title = SITE_NAME . " - ".format_lang('page_title','BrowseBYLocation')." - ( ". $city_name. ", ". $county_name. ", ". $state_name. ", ".$country_name." ) ";
	  }
		$smarty->assign('lang', $lang);
		$smarty->assign( 'message', $message );	
		$smarty->assign('rendered_page', $smarty->fetch('job_location.tpl') );		
	break;

///this is the first page
	default:
		$job_states = Job::location_top_link(  );

	  if($job_states){
		$activeLink =array();
		$i=1;
		foreach( $job_states as $job_state ){			
			//states
			$state_code = Country::find_by_code( $job_state->country );
			$state_var_name = ($state_code) ? $state_code->var_name : $job_state->country;
			$state_name = ($state_code) ? $state_code->name : $job_state->country;
			
			$activeLink[$i]['name'] 		= $state_name;
			$activeLink[$i]['var_name'] 	= $state_var_name;
			$activeLink[$i]['url'] = "";
			$i++;
		}				
		$smarty->assign('activeLink', $activeLink);
	  }
		///jobs
	 $job_by_locations = Job::list_job_by_location( $country_code );
	  if($job_by_locations2){	
		$location = array();
		$i=1;
		foreach( $job_by_locations as $job_by_location ):			
			//city
			$city_code = City::find_by_code( $country_a, null, null, $job_by_location->city );
			$city_var_name = ($city_code) ? $city_code->var_name : $job_by_location->city;
			
			//states
			$state_code = $job_by_location->state_province;
			$state_ = StateProvince::find_by_code( $country_a, $state_code );
			$state_var_name = ($state_) ? $state_->var_name : $job_by_location->state_province;
			
			//county
			$county_code = $job_by_location->county;
			$county_ = County::find_by_code( $country_a, $state_code, $county_code );
			$county_var_name = ($county_) ? $county_->var_name : $job_by_location->county;
			
			
			if ($city_code){/**check length of text */
				$location_name = strlen($city_code->name) > 60  ? substr( $city_code->name ,0 ,30 ). " ... " : $city_code->name;
			}else{ /**check length of text */
				$location_name = strlen($city_var_name) > 60  ? substr( $city_var_name ,0 ,30 ). " ... " : $city_var_name;
			}
			
			$total_jobs = Job::get_total_job_by_location( $country_a, null, null, $job_by_location->city );
			$location[$i]['total'] = $total_jobs;
								
			$location[$i]['name'] = $location_name;
			$location[$i]['location_id'] = $city->id;
			$location[$i]['var_name'] = $city_var_name;
			$location[$i]['url'] = $state_var_name."/".$county_var_name."/";
			$i++;
			
		endforeach;
		
		$smarty->assign('location', $location);
	  }
	  
		$html_title = SITE_NAME . " - ".format_lang('page_title','BrowseBYLocation');
		$smarty->assign('lang', $lang);
		$smarty->assign( 'message', $message );	
		$smarty->assign('rendered_page', $smarty->fetch('location.tpl') );		
	break;
}

?>