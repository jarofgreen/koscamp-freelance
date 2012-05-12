<?php  $req = return_url();
	$confcode = $req[2];
	
	if ( isset( $_REQUEST['txtconfcode'] ) && $_REQUEST['txtconfcode'] ) {
		$confcode = $_REQUEST['txtconfcode'];
		redirect_to( BASE_URL."employer/confirmreg/".$_REQUEST['txtconfcode']."/" );
		exit;
	} else {
		//$confcode = $_REQUEST['confcode'];
	}
	
	if(isset($_REQUEST['bt_confirm'])){
		if ( empty( $_REQUEST['txtconfcode'] ) && $_REQUEST['txtconfcode'] == '' ) {
			$session->message ("<div class='error'>".format_lang('errormsg',50)."</div>");
			redirect_to( BASE_URL."employer/confirmreg/" );
			die;
		}
	}
	
	if ( isset($confcode) && $confcode != '' ){
		$employer = Employer::complete_registration( $confcode ) ;
		if( $employer ){
			if( $employer->is_active == 'Y' )
			{
				$session->message ("<div class='error'>".format_lang('errormsg',51)."</div>");
				destroy_my_session();
				redirect_to( BASE_URL."employer/confirmreg/" );
				exit;
			}
			
			$session->message ("<div class='success'>".format_lang('success','confirm_reg')."</div>");
			destroy_my_session();
			redirect_to( BASE_URL."employer/login/" );
			exit;
		}
	}
	
$html_title = SITE_NAME . " - ".format_lang('page_title','ConfirmYourRegistration');
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('employer/confirmreg.tpl') );
?>