<?php //$_SESSION['direct_to_emp'] = "order/?".$_SERVER['QUERY_STRING']; 	
	 include_once('sessioninc.php');
//confirmation_page.php
if ( FREE_SITE == "Y" ){
	redirect_to(BASE_URL."employer/account/");
	die;
}

$invoice_id = (int)$_REQUEST['invoice_id'];
$payment_method = $_REQUEST['payment_method'];

if( !isset($invoice_id)) { redirect_to(BASE_URL."employer/credits/"); }

	$user_id = $session->get_user_id();
	$smarty->assign('user_id', $user_id);
	
	$username = $session->get_username();
	$smarty->assign('username', $username);
	
	$user = Employer::find_by_id( $user_id );

	$packageinvoice = PackageInvoice::find_by_id( $invoice_id );
	$status = 'Confirmed';
	$packageinvoice->package_status = $status;
	$packageinvoice->payment_method = $payment_method;

if($packageinvoice->amount == 0.00 )
{
	$payment_method = 'free';
	$packageinvoice->payment_method = 'free';
}
//
if($packageinvoice->amount != 0.00 && $payment_method == 'free' )
{
	$session->message("<div class='error'>".format_lang('error','noPaymentSelected')."</div>");
	redirect_to(BASE_URL."employer/credits/"); 	
	exit;
}

	$packageinvoice->save();
	$smarty->assign('p_invoice', $packageinvoice);
	$smarty->assign('invoice_id', $invoice_id);

if ($payment_method == 'free'){
	$smarty->assign('rendered_page', $smarty->fetch('employer/free_checkout.tpl') );
}else{
	$smarty->assign('transaction_id', $invoice_id );//$user_id."_".time() );
	$payment= $payment_method;
	require( '../modules/payment/'.$payment.'.php' );
	$payment_module =& new $payment;
	$payment_module->button();
}

$smarty->assign('dont_include_left', true);
$html_title 		= SITE_NAME . " - ".format_lang('page_title','Confirmorder');
$smarty->assign('package_id', $_REQUEST['package_id']);
$smarty->assign('invoice_id', $invoice_id);
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );
?>