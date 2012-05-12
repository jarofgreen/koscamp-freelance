<?php $records = Job::gorup_jobs_by_dates();
$i = 0;
if ( !empty($records) ) {
	$record_array = array();
	$i=0;
	foreach($records as $record){
		$rows = Job::get_group_job( $record->created_at );
		$created_at = date("d M",strtotime($record->created_at) );
			$i=0;
			foreach ( $rows as $row ):
			   $city = City::find_by_code( $row->country, $row->state_province, $row->county, $row->city );
			   $city_name = empty($city) ? $row->city :  $city->name;
			   $company_namer = Employer::find_by_id( $row->fk_employer_id );
			   $company_name = $company_namer->company_name;
			   $body = $row->job_description;
			   				
			   $record_array[$created_at][$i]['job_title'] = $row->job_title;
			   $record_array[$created_at][$i]['location'] = $city_name;
			   $record_array[$created_at][$i]['job_description'] = subtrack_string($body, 120 );
			   $record_array[$created_at][$i]['var_name'] = $row->var_name;
			   $record_array[$created_at][$i]['company_name'] = $company_name;
			   $i++;
			endforeach;
		//$i++;
	}
	$smarty->assign('gorup_jobs_by_dates', $record_array);
	unset($record_array, $i, $record, $row);
}
?>