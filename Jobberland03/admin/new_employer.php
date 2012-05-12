<?php  require_once( "../initialise_files.php" );

	include_once("sessioninc.php");
	
	//unset($_SESSION['loc']);
	
	$smarty->assign( 'max_cv', size_as_text( MAX_CV_SIZE ) );
//$smarty->assign( 'files_allowed', $country_t );

//when button is press		
	if( isset($_POST['bt_register']) ){
		$_SESSION['Employer_Text'] = array();
		
		$employer = new Employer();
		$employer->company_name	 	= $_SESSION['Employer_Text']['company_name'] 	= ucfirst( $_POST['txt_company_name'] );
		$employer->var_name 		= $employer->mod_write_check($_POST['txt_company_name']);
		$employer->contact_name	 	= $_SESSION['Employer_Text']['conatc_name'] 	= ucfirst( $_POST['txt_contact_name'] );
		$employer->site_link	 	= $_SESSION['Employer_Text']['site'] 			= $_POST['txt_site'];
		$employer->company_desc	 	= $_SESSION['Employer_Text']['desc'] 			=  allowedTags($_POST['txt_company_desc']);	
		$employer->email_address 	= $_SESSION['Employer_Text']['email'] 			= $_POST['txt_email'];
		$employer->username		 	= $_SESSION['Employer_Text']['username'] 		= $_POST['txt_username'];
		$employer->passwd		 	= $_SESSION['Employer_Text']['pass'] 			= $reg_pass = $_POST['txt_pass'];
		$employer->confirm_password	= $_SESSION['Employer_Text']['confirm_pass'] 	= $_POST['txt_confirm_pass'];
		$employer->address			= $_SESSION['Employer_Text']['address'] 		= $_POST['txt_address'];
		$employer->address2			= $_SESSION['Employer_Text']['address2'] 		= $_POST['txt_address2'];
		
		$employer->city				= $_SESSION['loc']['citycode'] 					= $_POST['txtcity'];
		$employer->county			= $_SESSION['loc']['countycode']				= $_POST['txtcounty'];
		$employer->state_province	= $_SESSION['loc']['stateprovince']				= $_POST['txtstateprovince'];
		$employer->country			= $_SESSION['loc']['country']					= $_POST['txt_country'];
		
		$employer->post_code		= $_SESSION['Employer_Text']['pcode'] 			= $_POST['txt_pcode'];
		$employer->phone_number		= $_SESSION['Employer_Text']['tel_no'] 			= $_POST['txt_tele'];
		$employer->terms = true;
		
		if( $_FILES['txt_logo']['error']==0 ) {
			$employer->attach_file( $_FILES['txt_logo'] );
		}
			
			if( $employer->save() ) {
				
				/*$email_tem = EmailTemplate::find_by_key( "EMPLOYER_SIGNUP" );
				$subject 	= str_replace("#SiteName#",SITE_NAME, $email_tem->email_subject);
				$body = $email_tem->email_template_body();
				$body 		= str_replace("#Password#", $reg_pass, $body);
				$to 	= array("email" => $employer->email_address, "name" => $employer->full_name() );
				$from 	= array("email" => $email_tem->from_email, "name" => $email_tem->from_name);
				$mail = send_mail( $body, $subject, $to, $from, "", "" );
				*/
				
				// Success
				$message = "<div class='success'>You have been register Successfuly</div>";
				unset($_SESSION['CAPTCHA'], $_SESSION['Employer_Text'], $_SESSION['loc']);
				//redirect_to('add_emp.php');
			} else {
				// Failure
				$message = "<div class='error'> following error(s) found:
							<ul> <li />";
				$message .= join(" <li /> ", $employer->errors );
				$message .= " </ul> 
						   </div>";
				
			}
			$session->message ($message );
			redirect_to( $_SERVER['PHP_SELF'] );
	}


//location///
	$default_county = empty($_SESSION['loc']['country']) ? DEFAULT_COUNTRY : $_SESSION['loc']['country'];
	$_SESSION['loc']['country'] = $countrycode = $default_county = $default_county;
	
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
	
	$lang['states'] = $state->get_stateOptions( $countrycode, 'Y' );

	if (count($lang['states']) == 1) {
		foreach ($lang['states'] as $key => $val) {
			$_SESSION['add_job']['state'] = $key;
		}
	} 

	//status 
	$_SESSION['add_job']['state'] = ($_SESSION['add_job']['state']!= '') ? $_SESSION['add_job']['state'] : "";
	if ($_SESSION['add_job']['state'] != '') {
		$lang['counties'] = $county->get_countyOptions( $countrycode, $_SESSION['add_job']['state'], 'N' );	
		if (count($lang['counties']) == 1) {
			foreach ($lang['counties'] as $key => $val) {
				$_SESSION['add_job']['county'] = $key;
			}
		}
		//county
		$_SESSION['add_job']['county'] = ($_SESSION['add_job']['county']!= '') ? $_SESSION['add_job']['county'] : "";
		if ($_SESSION['add_job']['county'] != '') {
			$lang['cities'] = $city->get_cityOptions($countrycode, $_SESSION['add_job']['state'], $_SESSION['add_job']['county'], 'N');
			if (count($lang['cities']) == 1) {
				foreach($lang['cities'] as $key => $val) {
					$_SESSION['add_job']['city'] = $key;
				}
			}
			//city
			$_SESSION['add_job']['city'] =  ($_SESSION['add_job']['city']!= '') ? $_SESSION['add_job']['city'] : "";
		}
	}
//end//

$smarty->assign( 'titles', get_lang ('titles') );
$html_title = SITE_NAME . " Add New Employer ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/new_employer.tpl') );
$smarty->display('admin/index.tpl');

?>