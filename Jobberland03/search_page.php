<?php 
   $q = $_GET['q'];
   $smarty->assign( 'q', $q );	
   
   	$_SESSION['loc']['country'] = $country_code = empty($_REQUEST['txt_country']) ? DEFAULT_COUNTRY : $_REQUEST['txt_country'];

   $location = $_GET['location'];
   $location = strip_html( $location );
   $smarty->assign( 'city_id', strtolower($location) );	
   $do_you_mean=false;


   $category = $_REQUEST['category'];
   if ( is_array($_REQUEST['category']) && !empty($_REQUEST['category']) ) {
		$category_selected = array();
		foreach ( $_REQUEST['category'] as $key => $value ):
			$category_selected[] = $value;
		endforeach;
	}
	
   $smarty->assign( 'category_selected', $category_selected );	
   
   $job_type_g =$_GET['job_type'];
   $smarty->assign( 'job_type_selected', $job_type_g );	
   
   $within =$_GET['within'];
   $career = $_GET['career'];
   $experience = $_GET['experience'];
   $education = $_GET['education'];
   
   $search_in = ($_REQUEST['search_in'] != '' ) ? $_REQUEST['search_in'] : 2;
   $smarty->assign( 'search_in', $search_in );

//get total number of records 
	$select = " SELECT job.id as job_id, job.var_name as job_var_name, job.job_title, job.job_description, job.city, job.fk_employer_id as employer_id, employer.company_name,employer.var_name as company_var_name, jobtype.type_name, job.job_salary, job.salaryfreq, job.created_at  ";
			
		$from = " FROM ".TBL_JOB." AS job";
		$from .= ", ". TBL_EMPLOYER. " AS employer";
		$from .= ", ".TBL_CATEGORY. " AS category";
		$from .= ", ".TBL_JOB_2_CAT ." AS job_cat";
		$from .= ", ".TBL_JOB_TYPE . " AS jobtype";
		$from .= ", ".TBL_JOB_2_TYPE." AS job2type";
		$from .= ", ".TBL_JOB_STATUS. " AS jobstatus";
		$from .= ", ".TBL_JOB_2_STATUS." AS job2status";
		
		$where = " WHERE DATE_ADD( job.created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
					AND job.is_active = 'Y'
					AND job.id > 0
					AND job.job_status = 'approved' 
					AND job.country='".$country_code."' ";
					
		$where .= " AND employer.id = job.fk_employer_id ";
		$where .= " AND (category.id = job_cat.category_id ";
		$where .= " AND job.id = job_cat.job_id )";
		$where .= " AND (jobtype.id = job2type.fk_job_type_id ";
		$where .= " AND job.id = job2type.fk_job_id )";
		$where .= " AND (jobstatus.id = job2status.fk_job_status_id";
		$where .= " AND job.id = job2status.fk_job_id ) ";
		
		$order = " ORDER BY job.created_at DESC";
		
		if ( $q != "" )
		{
			if ( $search_in == 1 ){
				$select .= ", match( job.job_title, job.job_description ) against ('{$q}' IN BOOLEAN MODE) as relevance";
				$where  .= " AND match( job.job_title, job.job_description ) against ('{$q}' IN BOOLEAN MODE) ";
			}else{
				$select .= ", match( job.job_title ) against ('{$q}' IN BOOLEAN MODE) as relevance";
				$where  .= " AND match( job.job_title ) against ('{$q}' IN BOOLEAN MODE) ";
			}
			
			$order = " ORDER BY relevance DESC";
		}
		
		if ( isset($location) && $location != "" )
		{
			$location = strip_html( $location );
			/*
			$city_sql = " SELECT * FROM ".TBL_CITY . " WHERE countrycode='".$country_code."' ";
			
			$city_result = $db->query( $city_sql );
			$new_array=array();
			$i=0;
			while ($fetch_sql = $db->fetch_object($city_result) ){
								
				if ( strcmp(soundex(strtolower($fetch_sql->name)), soundex(strtolower($location))) == 0 ) { 
					$new_array[$i]['name'] = $fetch_sql->name;
					$new_array[$i]['code'] = $fetch_sql->name;
					//echo "<br>".levenshtein( strtolower($fetch_sql->name), strtolower($location)). $fetch_sql->name;
					$i++; 
					//exit;
				}
			}
						
			$k=0;
			for ( $j=0; $j < sizeof($new_array); $j++ ){
				$i = similar_text(strtolower($new_array[$j]['name']), strtolower($db->escape_value($location)), &$similarity_pst);
				if( $i > $k && $i > 7 ){
					$k = $i;
						$city_db_name = $new_array[$j]['name'];
						$city_code = $new_array[$j]['code'];
				}
			}
			
			if( strtolower( $city_db_name) != strtolower( $location) )
			{
				$do_you_mean="found";
				$smarty->assign('did_you_mean_name', strtolower($city_db_name) );
				$smarty->assign('city_code', $city_code);
			}
			
			//$from .= ", ". TBL_CITY . " as city ";
			//$from .= ", ". TBL_COUNTIES . " as countty ";
			//$from .= ", ". TBL_STATES . " as states ";
			
			//$where .= " AND city.code = job.city ";
			//$where .= " AND match( city.name ) AGAINST ( '{$location}*' IN BOOLEAN MODE ) ";
			
			*/
			
			$state_r = StateProvince::find_closest_states( $country_code, $location);
			if ($state_r){
				$from .= ", ". TBL_STATES . " as states ";
				$where .= " AND states.code = job.state_province ";
				$where .= " AND job.state_province='".$state_r->code."' ";
			}else{
				$county_r = County::find_closest_county( $country_code, $location);
				if ($county_r){
					$from .= ", ". TBL_COUNTIES . " as county ";
					$where .= " AND county.code = job.county ";
					$where .= " AND job.county='".$county_r->code."' ";
				}else{
					$city_r = City::find_closest_city( $country_code, $location);
					if ($city_r){
						$from .= ", ". TBL_CITY . " as city ";
						$where .= " AND city.code = job.city ";
						$where .= " AND job.city='".$city_r->code."' ";
						//$where .= " AND match( city.name ) AGAINST ( '{$location}*' IN BOOLEAN MODE ) ";
					}else{
						$where  .= " AND match( job.city, job.county, job.state_province  ) against ('{$location}' IN BOOLEAN MODE) ";
					}					
				}
			}
			
			
			
			
			//$where .= " AND (job.city='{$location}' OR city.name ='{$location}') ";
		}
		
		if ( isset($category) && $category != "" )
		{
			
			$category = implode( "," , $category_selected );
			$where .= " AND job_cat.category_id IN (". $category .") ";
			//$where .= " AND job_cat.category_id ='{$category}' ";
		}
		
		if ( isset($job_type_g ) && $job_type_g != "" )
		{	
			$where .= " AND ( jobtype.var_name ='{$job_type_g}' OR jobtype.id = '{$job_type_g}' ) ";
		}
		
		if ( isset($career) && $career != "" )
		{	
			$from .= ", ".TBL_CAREER_DEGREE . " as career ";
			$where .= " AND career.id = fk_career_id ";
			$where .= " AND career.var_name ='".safe_output($career)."' ";
		}
		
		if ( isset($education) && $education != "" )
		{	
			$from .= ", ".TBL_EDUCATION . " as education ";
			$where .= " AND education.id = fk_education_id ";
			$where .= " AND education.var_name ='".safe_output($education)."' ";
		}
		
		if ( isset($experience) && $experience != "" )
		{	
			$from .= ", ".TBL_YEAR_EXPERIENCE . " as experience ";
			$where .= " AND experience.id = fk_experience_id ";
			$where .= " AND experience.var_name ='".safe_output($experience)."' ";
		}
		
		if ( isset($within) && $within != "" && $within != 0 )
		{
			$end = date("Y-m-d H:i:s");// current date
			//$start   = strtotime( date("Y-m-d H:i:s", strtotime($start)) . " +{$within} day");
			
			if( $within == 0 ) $t = "today";
			else $t = "- ".$within. " days";
			
			$start   = date("Y-m-d H:i:s", strtotime("{$t}"));
			//echo DATE_ADD( $end, INTERVAL 30 DAY );
			$where .= " AND  job.created_at BETWEEN '{$start}' AND '{$end}' ";
		}
		
		if( $order_by == "0" && $q != "" ):
			$order = " ORDER BY relevance DESC ";
		else:
			$order = " ORDER BY created_at DESC ";
		endif;
		
		$group_by = " GROUP BY job.id ";
		$sql = $select.$from.$where. $group_by. $order;
		
		$result = $db->query( $sql );
		$num_rows = $db->num_rows( $result );
#######################################################################################
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$per_page = (JOBS_PER_SEARCH <= $num_rows) ? JOBS_PER_SEARCH : $num_rows;
		$per_page = $per_page == 0 ? 1 : $per_page; 
		$total_count = $num_rows;

		$smarty->assign( 'total_count', $total_count );
		$smarty->assign( 'page', $page );
		
		$pagination = new Pagination( $page, $per_page, $total_count );
		
		$smarty->assign( 'previous_page', $pagination->previous_page() );
		$smarty->assign( 'has_previous_page', $pagination->has_previous_page() );
		$smarty->assign( 'total_pages', $pagination->total_pages() );
		
		$smarty->assign( 'has_next_page', $pagination->has_next_page() );
		$smarty->assign( 'next_page', $pagination->next_page());
		
		$offset = $pagination->offset();
		
		$smarty->assign( 'offset', $offset );
		$smarty->assign( 'per_page', $per_page );
		
		$limit = " LIMIT {$per_page}  OFFSET {$offset}";
		
		//get result
		$sql = $select.$from.$where. $group_by. $order. $limit;
		//echo $sql;
		$result = $db->query( $sql );
		$num_rows = $db->num_rows( $result );

if( $num_rows > 0 ){
	$list_jobs = array();
	$i=1;
	while( $rows = $db->fetch_object($result) ){
		$list_jobs[$i]['id']= $rows->job_id; 
		$list_jobs[$i]['created_at']= strftime(DATE_FORMAT, strtotime($rows->created_at) );
		$list_jobs[$i]['job_var_name']= $rows->job_var_name; 
		$list_jobs[$i]['job_title']= $rows->job_title; 
		$list_jobs[$i]['job_description']= strip_html( subtrack_string($rows->job_description, 230 ) ); 
		//$employer = Employer::find_by_id()
		$list_jobs[$i]['company_name']= $rows->company_name;
		$list_jobs[$i]['company_var_name']= $rows->company_var_name;
		
		//locations
		$jobs = Job::find_by_id( $rows->job_id );
		//country 
		$country_arry = Country::find_by_code( $jobs->country );
		$country_var_name = $country_arry->var_name;
		$country_name = $country_arry->name;
		
		//states
		$state = StateProvince::find_by_code( $jobs->country, $jobs->state_province );
		$state_var_name = ($state) ? $state->var_name : $jobs->state_province;
		
		//county
		$county = County::find_by_code( $jobs->country, $jobs->state_province, $jobs->county );
		$county_var_name = ($county) ? $county->var_name : $jobs->county;
		
		$city = City::find_by_code( $jobs->country, $jobs->state_province, $jobs->county, $jobs->city );
		$city_name = empty($city) ? $jobs->city : $city->name;
		$city_var_name = empty($city) ? $jobs->city : $city->var_name;
		
		$list_jobs[$i]['location']= $city_name; 			
		$list_jobs[$i]['city_url'] = $country_var_name."/".$state_var_name."/".$county_var_name."/".$city_var_name."/";
		
		$list_jobs[$i]['type_name']= $rows->type_name; 
		$list_jobs[$i]['salary']= !empty($rows->job_salary) ? $rows->job_salary. " per ".$rows->salaryfreq : "N/A"; 
		$i++;
	}
	$smarty->assign('list_jobs', $list_jobs);
}

$query = "";
//print_r($_GET);
if( !empty($_GET) ){
	foreach( $_GET as $key => $data){
		$data = trim($data);
		if( !empty($data) && $data != "" && $key != "page" && $key != "search_bt" && $key != "PHPSESSID"){
			if( $do_you_mean == 'found' ){
				if( is_array( $_GET[$key] ) ){
					foreach( $_GET[$key] as $key2 => $data2){
						$query .= "&".$key."[]=".$data2;
					}
				}else{
					if ( $key != "location"){
						$query .= "&amp;".$key."=".$data;
					}
				}				
			}else{
				if( is_array( $_GET[$key] ) ){
					foreach( $_GET[$key] as $key2 => $data2){
						$query .= "&".$key."[]=".$data2;
					}
				}else{
					$query .= "&amp;".$key."=".$data;
				}
			}
		}
	}
		
	$query = substr_replace($query, '', 0, 5);		
	$smarty->assign( 'query', $query );
	$smarty->assign( 'save_reference_name', $q );
	$smarty->assign( 'save_reference', urlencode($query) );
}

include_once("advance_search_page.php");
$html_title = SITE_NAME . " - ".format_lang('page_title','Search')." ". $q;
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('search.tpl') );		
?>