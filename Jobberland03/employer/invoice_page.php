<?php  $_SESSION['direct_to_emp'] = "account/"; 	
	 include_once('sessioninc.php');
	
	$page2 = return_url();
	$invoice_id = $page2[2];
	$username = $session->get_username();
	$user_id = $session->get_user_id();
		
	$invoice = PackageInvoice::find_invoice( $user_id, $invoice_id );
	
	$success = ($invoice->package_status == "Completed")? true : false;
	$smarty->assign( 'success', $success );	
	
	$payment_status= $invoice->package_status;
	$smarty->assign( 'payment_status', $payment_status );	
	
	$payment_method= empty($invoice->payment_method) ? "None":$invoice->payment_method;
	$smarty->assign( 'payment_method', $payment_method );	
	
	$payment_date = "on ". $invoice->payment_method ;
	$smarty->assign( 'payment_date', $payment_date );	
		
	$invoice_no=$invoice->id;
	$smarty->assign( 'invoice_no', $invoice_no );	
	
	$invoice_date= strftime(DATE_FORMAT, strtotime($invoice->invoice_date) );
	$smarty->assign( 'invoice_date', $invoice_date );	
	
	$payment_date= ($invoice->processed_date=='null' || $invoice->processed_date=="0000-00-00 00:00:00") ? "":strftime(DATE_FORMAT, strtotime($invoice->processed_date) );
	$smarty->assign( 'payment_date', $payment_date );	
	
	///$invoice_to
	
	$emp = Employer::find_by_username( $username );
	
	
	$invoice_to = $emp->address();
	$invoice_to = str_replace(":", "<br />", $invoice_to); 
	$name = $emp->full_name();
	$invoice_to = $name . "<br />".$invoice_to;
	$smarty->assign( 'invoice_to', $invoice_to );	
		
	$payment_to = "Jobberland<br />Address1 <br />Address1<br />Code";
	$smarty->assign( 'payment_to', $payment_to );	
	
	//item
	$package = Package::find_by_id( $invoice->fk_package_id );
	
	$description = $package->package_desc;
	$smarty->assign( 'description', $description );
	
	$package_name = $package->package_name;
	$smarty->assign( 'package_name', $package_name );
	
	$qty = $package->package_job_qty;
	$smarty->assign( 'qty', $qty );
	
	$amount= format_number ( $invoice->amount );
	$smarty->assign( 'amount', $amount );
	
	$vat = "17.5";
	$vat_cal = $vat / 100;
	$vat_cal = $vat_cal+1;
	
	$sub_total = $amount / $vat_cal;
	$sub_total = format_number ($sub_total);
	$smarty->assign( 'sub_total', $sub_total );
	
	$vat_amount= $sub_total / 100 * $vat;
	$vat_amount = format_number( $vat_amount );
	$smarty->assign( 'vat_amount', $vat_amount );
	
	$total_amount = $vat_amount + $sub_total;
	$total_amount = format_number( $total_amount );
	$smarty->assign( 'total_amount', $total_amount );
	
	$currency_name = CURRENCY_NAME;//get_lang('select','currency_symbol' );
	$smarty->assign( 'currency_name', $currency_name );
	
	$currency_symbol = get_lang('select','currency_symbol' );
	$currency_symbol = $currency_symbol[CURRENCY_NAME];
	$smarty->assign( 'currency_symbol', $currency_symbol );


$html_title 		= SITE_NAME . " - Invoice " .$invoice_id ;

if (isset($html_title) && $html_title != '')
	$smarty->assign('html_title', $html_title);
if (isset($meta_description) && $meta_description != '')
	$smarty->assign('meta_description', $meta_description);
if (isset($meta_keywords) && $meta_keywords != '')
	$smarty->assign('meta_keywords', $meta_keywords);	
	
	
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );
//$smarty->assign('rendered_page', $smarty->fetch('employer/invoice.tpl') );
$smarty->display('employer/invoice.tpl');
exit;
?>