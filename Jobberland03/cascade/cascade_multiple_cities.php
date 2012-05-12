<?php require_once( "../initialise_file_location.php" );  

if (!isset($_GET['a']) || empty($_GET['a']) || !isset($_GET['v']) || empty($_GET['v'])) {
	echo '|||stateprovince_auto|:|' .'<input name="txtstateprovince" type="text" size="30" maxlength="100" />&nbsp;&nbsp;'
	. '|||county_auto|:|' . '<input name="txtcounty" type="text" size="30" maxlength="100" />&nbsp;&nbsp;'
		. '|||city_auto|:|' . '<input name="txtcity" type="text" size="30" maxlength="100" />&nbsp;&nbsp;';
		//. '|||txtzip|:|' . '<input name="txtzip" type="text" size="30" maxlength="100" />';
	$db->close_connection();
	exit;
}

switch (trim($_GET['a'])) {

	case 'country':
		echo '|||stateprovince_auto|:|' . stateOptions()
			. '|||county_auto|:|' . '<input name="txtcounty" type="text" size="30" maxlength="100" />&nbsp;&nbsp;'
			. '|||city_auto|:|' . '<input name="txtcity" type="text" size="30" maxlength="100" />&nbsp;&nbsp;';
			//. '|||txtzip|:|' . '<input name="txtzip" type="text" size="30" maxlength="100" />';
		break;

	case 'state':
		echo '|||'.
			'county_auto|:|' . countyOptions()
			. '|||city_auto|:|' . '<input name="txtcity" type="text" size="30" maxlength="100" />&nbsp;&nbsp;';
			//. '|||txtzip|:|' . '<input name="txtzip" type="text" size="30" maxlength="100" />';
		break;

	case 'county':
		echo '|||'.
			 'city_auto|:|' . cityOptions();
			//. '|||txtzip|:|' . '<input name="txtzip" type="text" size="30" maxlength="100" />';
		break;
/*
	case 'city':
		echo '|||'.
			 'txtzip|:|' . zipOptions();
		break;
*/
	default : return ''; break;
}

function stateOptions() {
	$state = new StateProvince();
	$data = $state->get_stateOptions( trim($_GET['v']), 'Y' );

	if (count($data) < 1) 
		return '<input name="txtstateprovince" type="text" size="30" maxlength="100" />&nbsp;&nbsp;';
			
	  $ret .= '	<select class="select" name="txtstateprovince" onchange="javascript: cascadeState_multiple(this.value, this.form.txt_country.value,\'txtcounty\');" >';

	//$ret .= '<option value="">'.get_lang('select_text').'</option>';

	foreach ($data as $k => $y) {
		if ($k!='AA') {
			$ret .= "<option value='$k'>$y</option>";
		}
	}
	unset ($data);

	return $ret .= '</select>';
}

function countyOptions() {
	$county 	= new County();
	$data = $county->get_countyOptions(trim($_GET['v1']), trim($_GET['v']), 'N');
	
	if (count($data) < 1) return '<input name="txtcounty" type="text" size="30" maxlength="100" />&nbsp;&nbsp;';

	$ret = '<select class="select" name="txtcounty" onchange="javascript: cascadeCounty_multiple(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,\'txtcity\');" >';

	//$ret .= '<option value="">'.get_lang('select_text').'</option>';
	foreach ($data as $k => $y) {
		if ($k!='AA') {
			$ret .= "<option value='$k'>$y</option>";
		}
	}

	unset ($data);

	return $ret .= '</select>';
}

function cityOptions() {
	$city = new City();	
	$data = $city->get_cityOptions(trim($_GET['v1']),trim($_GET['v2']),trim($_GET['v']),'N');

	if (count($data) < 1) return '<input name="txtcity" type="text" size="30" maxlength="100" />&nbsp;&nbsp;';
	$ret = get_lang('max_no_of_cities');
	$ret .= '<br />	<select class="select" name="txtcity[]" multiple="multiple" size="10" >';

	//$ret .= '<option value="">'.get_lang('select_text').'</option>';

	foreach ($data as $k => $y) {
		if ($k!='AA') {
			$ret .= "<option value='$k'>$y</option>";
		}
	}

	unset ($data);

	return $ret .= '</select>';
}


function zipOptions() {
	$data = getZipcodes(trim($_GET['v1']),trim($_GET['v2']),trim($_GET['v3']),trim($_GET['v']),'N');

	if (count($data) < 1) return '<input name="txtzip" type="text" size="30" maxlength="100" />';

	$ret = '	<select class="select" style="width: 175px" name="txtzip" >';

	foreach ($data as $k => $y) $ret .= "<option value='$k'>$y</option>";

	unset ($data);

	return $ret .= '</select>';
}


	$db->close_connection();
//$osDB->disconnect();

?>