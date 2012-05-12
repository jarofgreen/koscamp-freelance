<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	$user_id = $_GET['id'];
	$action = $_GET['action'];
	
	if( $user_id == '' && !isset($user_id)  ) redirect_to( 'manage_employer.php');
	
	$user = Employer::find_by_id( $user_id );

	
	if( $action == "delete_logo"){
		$employer = new Employer;
		$employer->company_logo = $user->company_logo;
		$employer->username = $user->username;
		if( $employer->destroy_logo() ){
			$session->message("<div class='success'>Logo delete successfuly.</div>");
		}else{
			$session->message("<div class='success'>Unable to delete Logo.</div>");
		}
		redirect_to( $_SERVER['PHP_SELF']."?id=".$user_id );
		die;
	}
	

	if( isset($_POST['bt_update']) ){
		$allowedTags='<p><strong><em><u><img><span><style><blockquote>';
		$allowedTags.='<li><ol><ul><span><div><br><ins><del><a><span>';
		
		$employer = new Employer();
		$remove_logo = Employer::find_by_id( (int)$user_id );
		//$remove_logo->company_logo = $employer->company_logo;
		//$remove_logo->username = $employer->username;

		$employer->id 	= (int)$user_id;
		$email 	= $user->email_address = $_POST['txt_email'];
		//$username = $user->username = $_POST['txt_username'];
		
		$employer->company_name	 = $company_name 	= $_POST['txt_company_name'];
		$employer->var_name = $employer->mod_write_check ( $_POST['txt_company_name'], $user->company_name );
			
		$employer->contact_name	 = $contact_name 	= $_POST['txt_contact_name'];
		$employer->site_link	 = $site 			= $_POST['txt_site'];
		$employer->company_desc	 = $company_desc 	= strip_tags( stripslashes($_POST['txt_company_desc']), $allowedTags);	
		$employer->email_address = $email 			= $_POST['txt_email'];
		$employer->username		 = $username 		= $user->username;
		$employer->address		= $address 			= $_POST['txt_address'];
		$employer->address2		= $address2 		= $_POST['txt_address2'];

		$_SESSION['loc']['citycode']	= $employer->city 			= $_POST['txtcity'];
		$_SESSION['loc']['countycode'] 	= $employer->county 		= $_POST['txtcounty'];
		$_SESSION['loc']['stateprovince']= $employer->state_province = $_POST['txtstateprovince'];
		$_SESSION['loc']['country'] 	= $employer->country 		= $_POST['txt_country'];

		$employer->post_code	= $pcode 			= $_POST['txt_pcode'];
		$employer->phone_number	= $tele 			= $_POST['txt_tele'];
		
		
		
		if( $_FILES['txt_logo']['error'] == 0 ) {
			$employer->attach_file( $_FILES['txt_logo'] );
			$remove_logo->destroy_logo();
		}
			
			if($employer->save()) {
				// Success
				$session->message ("<div class='success'>You details has been updated Successfuly</div>");
					//unset($_SESSION['CAPTCHA']);
				redirect_to( 'manage_employer.php');
			}else {
				// Failure
				$message = "<div class='error'> following error(s) found:
						<ul> <li />";
				$message .= join(" <li /> ", $employer->errors );
				
				$message .= " </ul> 
						   </div>";
			}
	}else{
		$user_id 				= $user->id;
		$company_name 			= $user->company_name;
		$contact_name 			= $user->contact_name;
		$site 					= $user->site_link;
		$company_desc 			= $user->company_desc;	
		$email 					= $user->email_address;
		$username 				= $user->username;
		$address 				= $user->address;
		$address2 				= $user->address2;
		
		$_SESSION['loc']['citycode'] 	= $city = $user->city;
		$_SESSION['loc']['countycode']	= $county = $user->county;
		$_SESSION['loc']['stateprovince']= $state_province = $user->state_province;
		$_SESSION['loc']['country'] 	= $country = $user->country;

		$pcode 					= $user->post_code;
		$tele 					= $user->phone_number;
	}
	
	$smarty->assign( 'company_name', $company_name );
	$smarty->assign( 'contact_name', $contact_name );
	$smarty->assign( 'site', $site );
	$smarty->assign( 'company_desc', $company_desc );
	$smarty->assign( 'email', $email );
	$smarty->assign( 'username', $username );
	$smarty->assign( 'address', $address );
	$smarty->assign( 'company_name', $company_name );
	$smarty->assign( 'address2', $address2 );
	$smarty->assign( 'pcode', $pcode );
	$smarty->assign( 'tele', $tele );
	$smarty->assign( 'company_logo', trim($user->company_logo) );
		
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
	
$html_title = SITE_NAME . " - Edit Employer ( " . $user->full_name() . " ) ";
$smarty->assign('lang', $lang);
//$smarty->assign( 'titles', get_lang ('titles') );
$smarty->assign('id', $user_id);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/edit_employer.tpl') );
$smarty->display('admin/index.tpl');
unset($_SESSION['message']);
?>