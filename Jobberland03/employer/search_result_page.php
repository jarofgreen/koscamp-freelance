<?php   $_SESSION['direct_to_emp'] = "search/"; 	
	 include_once('sessioninc.php');

	$username = $session->get_username();
	
	$user_id = $session->get_user_id();
	$country_code = strip_html($_POST['txt_country']);

	$employer = Employer::find_by_id( $user_id );
	$total_cv = $employer->total_cv();
	define('TEMP_TOTAL_CV', $total_cv);
	
	if ( FREE_SITE == "N" ){
		if( $total_cv <= 0 ){
			//$session->message("<div class='error'>".format_lang('error','cv_zero')."</div>");
			//redirect_to(BASE_URL."employer/credits/");
			//die;
		}
	}	
	
		$keyword 	= $_GET['txt_keywords'];		
		$experience	= $_GET['txt_experience'];
		$education 	= $_GET['txt_education'];
		
		if( sizeof($_GET['txt_job_statu']) != 0 && isset($_GET['txt_job_statu'])){
			//$job_status=array();
			//foreach( $_GET['txt_job_statu'] as $key => $data ){
			//	$job_status[] = "look_job_status = '{$data}'";
			//}
			
			//$job_status = implode(' OR ', $job_status );
			$job_status = "look_job_status IN (". mysql_IN_values( $_GET['txt_job_statu'] )." ) ";
		}
		
		if( !empty($_POST['txt_start_date_Month']) && 
						  !empty($_POST['txt_start_date_Day']) && 
						  !empty($_POST['txt_start_date_Year']) ){
			$str_date 	= mktime(0,0,0, 
								 $_GET['txt_start_date_Month'], 
								 $_GET['txt_start_date_Day'], 
								 $_GET['txt_start_date_Year']);
			
			$str_date 	= date("Y-m-d H:i:s",$str_date);
		}
		
		//print_r($_GET['txt_location']);
		if( sizeof($_GET['txt_location']) != 0 && isset($_GET['txt_location'])){
			$loc2=array();
			foreach( $_GET['txt_location'] as $key => $data ){
				$loc2[] = "city = '{$data}'";
			}
			 $loc = implode(' OR ', $loc2 );
			 //$loc = "city IN (". mysql_IN_values( $_GET['txt_location'] )." ) ";
		}
		
		
		
		$salary		= $_GET['txt_salary'];

//setup search query
		$select = " SELECT * ";
		
		$from = " FROM ".TBL_CV;
		
		$where = " WHERE cv_status='Public' ";
		
		$order_by ="";
		
		if( !empty($keyword)){
			$select .=", match ( cv_title, recent_job_title, 
								  look_job_title, look_job_title2, 
								  additional_notes ) against ('{$keyword}' IN BOOLEAN MODE) AS relevance";
								  
			$where.=" AND match ( cv_title, recent_job_title, 
								  look_job_title, look_job_title2, 
								  additional_notes ) against ('{$keyword}' IN BOOLEAN MODE) 
					 AND country = '{$country_code}' ";
			
			$order = " ORDER BY relevance DESC";
		}
		
		if( sizeof($_GET['txt_category']) != 0 && isset($_GET['txt_category'])){
			$cat2=array();
			foreach( $_GET['txt_category'] as $key => $data ){
				$cat2[] = "cv_cat.category_id =".$data;
			}
			
			$cat = implode(' OR ', $cat2 );
			//$cat = "look_industries IN (". mysql_IN_values( $_GET['category'] )." ) ";
			$from .= ", ". TBL_CV_CAT . " AS cv_cat ";
			$where.= " AND ( ".$cat." ) ";
			$where.= " AND cv_cat.cv_id = id";
		}
		
		if( !empty($experience) && $experience != "" ){
			$where.=" AND year_experience ='$experience' ";
		}
		
		if( !empty($education) && $education != ""){
			$where.=" AND highest_education ='$education' ";
		}
		
		if( !empty($job_status) && $job_status != ""){
			$where.=" AND {$job_status} ";
		}
		
		if( !empty($str_date) ){
			$where.=" AND start_date ='{$str_date}' ";
		}
		
		if( !empty($loc) && $loc != ""){
			$where.=" AND ({$loc}) ";
		}
		
		if(!empty($salary) ){
			//$where.=" AND salary_range ='$salary' ";
		}
		
		$group_by = " GROUP BY id ";
		
		$sql = $select. $from . $where.$group_by;
		$result = $db->query( $sql );
		$num_rows = $db->num_rows( $result );
#######################################################################################
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$per_page = JOBS_PER_SEARCH;
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
	$manage_list = array();
	$i=1;
	while( $rows = $db->fetch_object($result) ){
		$employee = Employee::find_by_id( $rows->fk_employee_id );
		
		$manage_list[$i]['id']= $rows->id; 
		$manage_list[$i]['employee_name']= $employee->full_name();
		$manage_list[$i]['employee_id']= $rows->fk_employee_id ;
		$manage_list[$i]['cv_title']= $rows->cv_title;
		$manage_list[$i]['look_job_title']= $rows->look_job_title;
		$manage_list[$i]['look_job_title2']= $rows->look_job_title2;
		
		$status = JobStatus::find_by_id( $rows->look_job_status );
		$status_name = $status->status_name;
		$manage_list[$i]['look_job_status']= $status_name;
		
		$manage_list[$i]['recent_job_title']= $rows->recent_job_title;
		//$manage_list[$i]['city']=  $rows->city;
		$manage_list[$i]['modified_at']= strftime(DATE_FORMAT, strtotime($rows->modified_at)) ;
		
		//locations
		//country 
		$country_arry = Country::find_by_code( $rows->country );
		$country_var_name = $country_arry->var_name;
		$country_name = $country_arry->name;
	
		//states
		$state = StateProvince::find_by_code( $rows->country, $rows->state_province );
		$state_name = empty($state) ? $rows->state_province : $state->name; 
		
		//county
		$county = County::find_by_code( $rows->country, $rows->state_province, $rows->county );
		$county_name = empty($county) ? $rows->county : $county->name;
		
		$city = City::find_by_code( $rows->country, $rows->state_province, $rows->county, $rows->city );
		$city_name = empty($city) ? $rows->city : $city->name;
		//end of location
		
		$manage_list[$i]['city']= $city_name.", ".$county_name.",<br />".$state_name.", ".$country_name; 			
		//$manage_list[$i]['city_url'] = $state_var_name."/".$county_var_name."/".$city_var_name."/";
		
		$i++;
	}
	$smarty->assign('list_cv', $manage_list);
}
	
	$query = "";
	foreach( $_GET as $key => $data){
		if( !empty($data) && $data != "" && $key != "page" && $key != "bt_search"){
			$query .= "&amp;".$key."=".$data;
		}
	}
	
	
$html_title 		= SITE_NAME . " - ".format_lang("page_title", 'Search');

$smarty->assign('dont_include_left', true);
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );
$smarty->assign('rendered_page', $smarty->fetch('employer/search_result.tpl') );	
?>