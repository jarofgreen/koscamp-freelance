<?php 
/* recurint now */
$current_company ="0";
$company_url = return_url();
$current_company = !empty($company_url[1]) ? $company_url[1] : 0;

//global $database, $db;
$sql .= " SELECT COUNT(job.fk_employer_id) as total, employer.company_name, employer.id As employer_id, employer.company_logo, employer.var_name as employer_var_name
			FROM ".TBL_EMPLOYER." AS employer, ".TBL_JOB." AS job
			WHERE  employer.id = job.fk_employer_id 
			AND DATE_ADD( job.created_at, INTERVAL ".JOBLASTFOR." DAY ) > NOW() 
			AND job.is_active = 'Y' AND job_status='approved' 
			AND employer.company_logo <> 'no_image.jpg'
			AND employer.company_logo IS NOT NULL
			AND employer.var_name <> '".$current_company."' 
			AND employer.company_logo <> ''
			Group by job.fk_employer_id
			LIMIT 0, ".MAX_RECRUITING;
$result = $database->query( $sql );
$num_rows = $db->num_rows($result);

//echo $sql;

//$recruiting_nows = !empty($result) ? $db->fetch_object($result) : false;

if( $num_rows > 0  ) {
	$list = array();
	$i=1;
	while ($company = $db->fetch_object($result)) {
	//foreach ( $recruiting_nows as $company ):
		$list[$i]['var_name'] = $company->employer_var_name;
		$list[$i]['logo'] 	  = $company->company_logo;
		$list[$i]['name'] 	  = $company->company_name;
		$list[$i]['total'] 	  = $company->total;
		$i++;
	}
	//endforeach;
	$smarty->assign('recruiting_nows', $list);
}

$smarty->assign('lang', $lang);
$smarty->assign('recruiting_now', $smarty->fetch('recruiting_now_inc.tpl') );
//recruiting_now_inc.tpl
?>