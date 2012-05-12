<?php //checkout_process.php
	$_SESSION['direct_to_emp'] = "account/"; 	
	 include_once('sessioninc.php');

$payment_from = $_REQUEST['payment_from'];
$invoice_id = $_REQUEST['invoice_id'];
$payment_cancel = $_REQUEST['payment_c'];

$packageinvoice = PackageInvoice::find_by_id( $invoice_id );

if ( (!isset($payment_from) && $payment_from == '' && $payment_cancel == '')|| $invoice_id == '' )
{ 
	redirect_to(BASE_URL."employer/credits/"); 
}

elseif( $payment_from == 'free' )
{
	if ( $packageinvoice->amount != 0.00 ){ redirect_to(BASE_URL."employer/credits/"); }		

	$param['payment_status'] = "Completed"; //what is the status of the payment
	$param['amount'] = "0.00"; // how much was paid for this total amount for each item
	$param['currency'] = "N/A"; //what currecy they used to pay for this
	$param['receiver_id'] = "N/A"; // what is the id of person who is paying
	$param['payment_email']="N/A"; // what email have they used to pay
	$param['txn_id'] = $clint->id."_".time(); // txt id
	$param['txn_type'] = "web"; // how are they pay for this web or ext.
	$param['payer_status'] = "N/A"; //is user verfied by the method they pay from
	$param['residence_country'] = "N/A"; //which country does user belogn to
	//$param['origin'] = ""; //where is the payment come from
	$param['payment_method'] = "free"; // what methoid of payment they used e.g. paypal, ccbill
	$param['payment_vars'] = "N/A"; //get all var which are return from online site.
	$param['payment_type'] = "free"; //how they pay for this
	$param['reason'] = "None"; // if they cancel then tell user why

	process_payment( $invoice_id, $param);

	$smarty->assign('order_number', $invoice_id);
	$smarty->assign('num_of_posts', $packageinvoice->posts_quantity);
	$smarty->assign('price', $packageinvoice->amount);
	$smarty->assign('status',"Completed");
	$smarty->assign('payment_from',$payment_from);

	$html_title 		= SITE_NAME . " - Thank you for your payment ";	
	$smarty->assign('lang', $lang);
	$smarty->assign( 'message', $message );	
	$smarty->assign('rendered_page', $smarty->fetch('employer/thankyou.tpl') );	
}
elseif( $payment_cancel != '' || isset( $payment_cancel))
{
	$invoice = PackageInvoice::find_by_id( $invoice_id );
	$invoice->package_status 	= 'Cancelled';
	//$invoice->processed_date 	= date("Y-m-d H:i:s", time() );
	$invoice->update_package_status();
		
	$invoice_item = new Invoice;
	$invoice_item->fk_invoice_id 	= $invoice_id;
	$invoice_item->payment_status 	= "Cancelled";
	$invoice_item->payment_type  	= "web";//$params['payment_type'];
	$invoice_item->amount 			= $packageinvoice->amount;//$params['amount'];
	$invoice_item->currency			= $packageinvoice->currency_code;//$params['currency'];
	//$invoice_item->receiver_id 		= $packageinvoice->amount;//$params['receiver_id'];
	//$invoice_item->payment_email 	= $packageinvoice->amount;//$params['payment_email'];
	//$invoice_item->txn_id 			= $packageinvoice->amount;//$params['txn_id'];
	//$invoice_item->txn_type 		= $packageinvoice->amount;//$params['txn_type'];
	//$invoice_item->payer_status		= $packageinvoice->amount;//$params['payer_status'];
	//$invoice_item->residence_country= $packageinvoice->amount;//$params['residence_country'];
	//$invoice_item->payment_date		= $packageinvoice->amount;//date("Y-m-d H:i:s", time() );
	$invoice_item->reason			= "Payment cancelled by user";//$params['reason'];
	//$invoice_item->origin			= $packageinvoice->amount;//$params['payment_method'];
	//$invoice_item->payment_vars 	= $packageinvoice->amount;//$params['payment_vars'];
	$invoice_item->save();

	$smarty->assign('order_number', $invoice_id);
	$smarty->assign('num_of_posts', $packageinvoice->posts_quantity);
	$smarty->assign('price', $packageinvoice->amount);
	$smarty->assign('status',"Cancelled");
	$smarty->assign('payment_from',$payment_from);

	$html_title 		= SITE_NAME . " - Thank you for your payment -cancelled ";	
	$smarty->assign('lang', $lang);
	$smarty->assign( 'message', $message );	
	$smarty->assign('rendered_page', $smarty->fetch('employer/thankyou.tpl') );
}


else{

	$smarty->assign('order_number', $invoice_id);
	$smarty->assign('num_of_posts', $packageinvoice->posts_quantity);
	$smarty->assign('price', $packageinvoice->amount);
	$smarty->assign('status',"Processing");
	$smarty->assign('payment_from',$payment_from);

	$html_title 		= SITE_NAME . " - Thank you for your payment ";	
	$smarty->assign('lang', $lang);
	$smarty->assign( 'message', $message );	
	$smarty->assign('rendered_page', $smarty->fetch('employer/thankyou.tpl') );
}
?>