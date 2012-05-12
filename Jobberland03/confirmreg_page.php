<?php  $req = return_url();
	$confcode = $req[1];
	
	if ( isset( $_GET['txtconfcode'] ) && $_GET['txtconfcode'] ) {
		$confcode = $_GET['txtconfcode'];
		redirect_to( BASE_URL."confirmreg/".$_REQUEST['txtconfcode'] );
		exit;
	} else {
		//$confcode = $_GET['confcode'];
	}
	
	if(isset($_REQUEST['bt_confirm'])){
		if ( empty( $_GET['txtconfcode'] ) && $_GET['txtconfcode'] == '' ) {
			$session->message ("<div class='error'>".format_lang('errormsg',50)."</div>");
			redirect_to( BASE_URL."confirmreg/" );
			die;
		}
	}
	
	if ( isset($confcode) && $confcode != '' ){
		$employee = Employee::complete_registration( $confcode ) ;
		if( $employee ){
			if( $employee->is_active == 'Y' )
			{
				$session->message ("<div class='error'>".format_lang('errormsg',51)."</div>");
				redirect_to( BASE_URL."confirmreg/" );
				exit;
			}
			
			$session->message ("<div class='success'>".format_lang('success','confirm_reg')."</div>");
			redirect_to( BASE_URL."login/" );
			exit;
		}
	}
	
$html_title = SITE_NAME . " - ".format_lang('page_title','ConfirmYourRegistration');
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('confirmreg.tpl') );
?>