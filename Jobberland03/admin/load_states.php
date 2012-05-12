<?php require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");

	@set_time_limit(1200);

$default_county = empty($_POST['txt_country']) ? DEFAULT_COUNTRY : $_POST['txt_country'];
$_SESSION['loc']['country'] = $countrycode = $default_county = !empty( $default_county ) ? $default_county : "GB";

$country 	= Country::find_all_order_by_name();
if ( is_array($country) && !empty($country) ) {
	$country_t = array();
	$country_t['AA'] = 'All Countries';
	foreach( $country as $co ):
		if ($val['code'] != 'AA') {
			$country_t[ $co->code ] = $co->name;
		}
	endforeach; 
	$smarty->assign( 'country', $country_t );
}	


//if load states button is press process the states
if ( isset($_POST['loadstates']) )
{	
	$state = new StateProvince();
	$filename = $_POST['filename'];
	$state->delete_by_country( $countrycode );
	$file = SITE_ROOT."/states/".$filename;
	$file = fopen($file, "r");
	while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
		$state = new StateProvince();
		$state->countrycode = $countrycode;
		$state->code = trim($data[0]);
		$state->var_name = $state->mod_write_check( trim($data[1]) );
		$state->name = trim($data[1]);
		$save = $state->save();
	}
	fclose($file);
	
	$message = "<div class='success'>State codes loaded from ".$filename. " </div>";
	$session->message ($message );
	redirect_to( $_SERVER['PHP_SELF'] );
}

//delete all the states from list
if ( isset($_POST['deletestates']) ){
	global $db, $database;
	$state = new StateProvince();
	$state->delete_by_country( $countrycode );

	/* We should remove the state definition from counties, cities and zips tables also for this country */
	$db->query("update ".TBL_COUNTIES." set statecode='' where countrycode='$countrycode' ");
	$db->query("update ".TBL_CITY." set statecode='' where countrycode='$countrycode' ");
	
	$message = "<div class='success'>State codes for #COUNTRY# are deleted </div>";
	$message = str_replace('#COUNTRY#', $countrycode, $message );
	
	/* Analyze the table to adjust index values */
	//$db->optimize_table( TBL_COUNTRY );
	$db->optimize_table( TBL_STATES );
	$db->optimize_table( TBL_COUNTIES );
	$db->optimize_table( TBL_CITY );
	
	$session->message ($message );
	redirect_to( $_SERVER['PHP_SELF'] );
}


//get the states files 
$files = array();
$dir = opendir( SITE_ROOT."/states" );
while($file = readdir($dir)) {
	if ($file != '.' && $file != '..' && stristr( $file, '.csv' ) )
		$files[] = $file;
}

$smarty->assign('files', $files);
$smarty->assign('filename',$filename);

unset($files, $dir);

$html_title = SITE_NAME . " Add New Employer ";

$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/load_states.tpl'));
$smarty->display('admin/index.tpl');
?>