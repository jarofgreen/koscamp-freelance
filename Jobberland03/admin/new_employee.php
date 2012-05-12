<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	//unset($_SESSION['loc']);

############## when post button is press ######################
	if( isset($_POST['bt_register']) ){
		global $employee;
		$employee = new Employee();
		$_SESSION['reg']['username'] = $employee->username 		= $reg_username 	= $_POST['reg_username'];
		$_SESSION['reg']['email'] 	= $employee->email_address 	= $reg_email 		= $_POST['reg_email'];
		$_SESSION['reg']['pass']  	= $employee->passwd 		= $reg_pass 		= $_POST['reg_pass'];
									  $employee->confirm_passwd = $reg_confirm_pass = $_POST['reg_confirm_pass'];
		$_SESSION['reg']['fname'] 	= $employee->fname 			= $reg_fname 		= $_POST['reg_fname'];
		$_SESSION['reg']['sname'] 	= $employee->sname 			= $reg_sname		= $_POST['reg_sname'];
									  $employee->actkey			= $reg_key 			= md5( session_id().time() );
		
		$employee->city				= $_SESSION['loc']['citycode'] 					= $_POST['txtcity'];
		$employee->county			= $_SESSION['loc']['countycode']				= $_POST['txtcounty'];
		$employee->state_province	= $_SESSION['loc']['stateprovince']				= $_POST['txtstateprovince'];
		$employee->country			= $_SESSION['loc']['country']					= $_POST['txt_country'];
		
		
		//if( !empty($_POST['txt_terms']) && $_POST['txt_terms'] != "" ){
			$employee->terms = 1;
		//}
				
		if( $employee->save() ){
			$session->message ("<div class='success'>You have been register Successfuly</div>");
/**		
			$email_tem = EmailTemplate::find_by_key( "CANDIDATE_SIGNUP" );
			$subject 	= str_replace("#SiteName#",SITE_NAME, $email_tem->email_subject);

			$body = $email_tem->email_template_body(null, $employee);
			$body 		= str_replace("#Password#", $reg_pass, $body);
			if( REG_CONFIRMATION == "N" ){
				$mess = "<p>To confirm your profile addition, please click the link below. Or, if the link is not clickable, 
				copy and paste it into address bar of your web browser, to directly access it.</p><p>&nbsp;</p>";
				
				$mess .= "<p>#Link#/confirm_reg.php?confcode=$reg_key</p><p>&nbsp;</p>";
				
				$mess .= "<p>If you still have the final step of the registration wizard open, 
				you can input your confirmation code on that screen.</P><p>&nbsp;</p>";
				
				$mess .= "<p>Your confirmation code is: $reg_key</p><p>&nbsp;</p>";
				
				$body = str_replace("#Message#", $mess, $body );
			}
			$body = str_replace("#Link#", "http://".$_SERVER['HTTP_HOST'], $body);
			
			$body = str_replace("#Message#", "", $body );
			
			$to 	= array("email" => $reg_email, "name" => $employee->full_name() );
			$from 	= array("email" => $email_tem->from_email, "name" => $email_tem->from_name);
			$mail = send_mail( $body, $subject, $to, $from, "", "" );
			
			unset($_SESSION['CAPTCHA']);
			
			if( REG_CONFIRMATION == "N" ){
				redirect_to( "confirm_reg.php" );
				exit;
			}
*/
			destroy_my_session();
			redirect_to( $_SERVER['PHP_SELF'] );
		}
		/** errors */
		else{
			$message = "<div class='error'> 
					following error(s) found:
				<ul> <li />";
			$message .= join(" <li /> ", $employee->errors );
			$message .= " </ul> 
					</div>";
		}
	}else{
		$reg_username 		=  "";
		$reg_email 			=  "";
		$reg_pass 			=  "";
		$reg_confirm_pass 	=  "";
		$reg_fname 			=  "";
		$reg_sname			=  "";
	}

################ end ###################


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
$smarty->assign('rendered_page', $smarty->fetch('admin/new_employee.tpl') );
$smarty->display('admin/index.tpl');
unset($_SESSION['message']);
?>