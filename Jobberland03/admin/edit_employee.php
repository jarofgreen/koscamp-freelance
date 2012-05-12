<?php require_once( "../initialise_files.php" );  
	include_once("sessioninc.php");
	
	$user_id = $_GET['id'];
	$user = Employee::find_by_id( $user_id );
	
	$id 							= $user->id;
	$email 							= $user->email_address;
	$username 						= $user->username;
	$_SESSION['account']['title'] 	= $title = $user->title;
	$fname 						 	= $user->fname;
	$sname 							= $user->sname;
	$address 						= $user->address;
	$address2 						= $user->address2;
	$_SESSION['loc']['citycode'] 	= $city = $user->city;
	$_SESSION['loc']['countycode']	= $county = $user->county;
	$_SESSION['loc']['stateprovince']= $state_province = $user->state_province;
	$_SESSION['loc']['country'] 	= $country = $user->country;
	$post_code 						= $user->post_code;
	$phone_number 					= $user->phone_number;
	$fk_career_degree_id 			= $user->fk_career_degree_id;

	$smarty->assign( 'id', $id );
	$smarty->assign( 'email_address', $email );
	$smarty->assign( 'username', $username );
	$smarty->assign( 'title', $title );
	$smarty->assign( 'fname', $fname );
	$smarty->assign( 'sname', $sname );
	$smarty->assign( 'address', $address );
	$smarty->assign( 'address2', $address2 );
	$smarty->assign( 'city', $city );
	$smarty->assign( 'county', $county );
	$smarty->assign( 'state_province', $state_province );
	$smarty->assign( 'country', $country );
	$smarty->assign( 'post_code', $post_code );
	$smarty->assign( 'phone_number', $phone_number );
	$smarty->assign( 'fk_career_degree_id', $fk_career_degree_id );

	if( isset($_POST['account_btn']) ){
		$employee = new Employee();
		$_SESSION['account']['id'] 	  	= $employee->id 			= $user_id;
		//$_SESSION['account']['email'] 	= $employee->email_address 	= $_POST['txt_email_address'];
		$_SESSION['account']['title'] 	= $employee->title			= $_POST['title_txt'];
		$_SESSION['account']['fname'] 	= $employee->fname			= ucfirst($_POST['txt_fname']);
		$_SESSION['account']['sname'] 	= $employee->sname			= ucfirst($_POST['txt_sname']);
		
		$_SESSION['account']['address'] = $employee->address		= $_POST['txt_address'];
		$_SESSION['account']['address2']= $employee->address2		= $_POST['txt_address2'];
		
		$_SESSION['loc']['citycode']	= $employee->city 			= $_POST['txtcity'];
		$_SESSION['loc']['countycode'] 	= $employee->county 		= $_POST['txtcounty'];
		$_SESSION['loc']['stateprovince']= $employee->state_province = $_POST['txtstateprovince'];
		$_SESSION['loc']['country'] 	= $employee->country 		= $_POST['txt_country'];
		
		$_SESSION['account']['pc'] 		= $employee->post_code 			= strtoupper($_POST['txt_post_code']);
		$_SESSION['account']['pn'] 		= $employee->phone_number 		= $_POST['txt_phone_number'];
		$_SESSION['account']['email'] = $employee->email_address 		= $_POST['txt_email_address'];
		
		if( $employee->save() ){
			destroy_my_session();
			$session->message ("<div class='success'>Account details has been Successfuly updated</div>");
			unset($_SESSION['account']);
			redirect_to( BASE_URL."admin/manage_employee.php" );
		}else{
			$message = "<div class='error'> 
					following error(s) found:
				<ul> <li />";
			$message .= join(" <li /> ", $employee->errors );
			$message .= " </ul> 
					</div>";
		}
	}

$default_county = $_SESSION['loc']['country'];
$countrycode = $default_county = !empty( $default_county ) ? $default_county : "GB";
	
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

$state = new StateProvince();
$county 	= new County();
$city = new City();

$lang['states'] = $state->get_stateOptions( $countrycode, 'N' );
if (count($lang['states']) == 1) {
	foreach ($lang['states'] as $key => $val) {
		$_SESSION['loc']['stateprovince'] = $key;
	}
}
//status 
$_SESSION['loc']['stateprovince'] = ($_SESSION['loc']['stateprovince']!= '') ? $_SESSION['loc']['stateprovince'] : "";
if ($_SESSION['loc']['stateprovince'] != '') {
	$lang['counties'] = $county->get_countyOptions( $countrycode, $_SESSION['loc']['stateprovince'], 'N' );
	if (count($lang['counties']) == 1) {
		foreach ($lang['counties'] as $key => $val) {
			$_SESSION['loc']['countycode'] = $key;
		}
	}
	//county
	$_SESSION['loc']['countycode'] = ($_SESSION['loc']['countycode']!= '') ? $_SESSION['loc']['countycode'] : "";
	if ( $_SESSION['loc']['countycode'] != '') {
		$lang['cities'] = $city->get_cityOptions($countrycode, $_SESSION['loc']['stateprovince'], $_SESSION['loc']['countycode'], 'N');
		if (count($lang['cities']) == 1) {
			foreach($lang['cities'] as $key => $val) {
				$_SESSION['loc']['citycode'] = $key;
			}
		}
		//city
		$_SESSION['loc']['citycode'] = ($_SESSION['loc']['citycode']!= '') ? $_SESSION['loc']['citycode'] : "" ;
	}
}

	$smarty->assign( 'titles', get_lang ('select','titles') );	

$html_title = SITE_NAME . " - Edit Employee ( " . $user->full_name() . " ) ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/editEmployee.tpl') );
$smarty->display('admin/index.tpl');
unset($_SESSION['message']);
?>