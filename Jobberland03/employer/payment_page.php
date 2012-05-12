<?php  $_SESSION['direct_to_emp'] = "account/"; 	
	 include_once('sessioninc.php');

if ( FREE_SITE == "Y" ){
	redirect_to(BASE_URL."employer/account/");
	die;
}

	if( !isset($_REQUEST['package_id'])) { redirect_to(BASE_URL."employer/credits/"); }
	
	$user_id = $session->get_user_id();
	$username = $session->get_username();
	$user = Employer::find_by_id( $user_id );
	
	$package_invoice = PackageInvoice::find_by_id( $_POST['invoice_id'] );

	if( $package_invoice->amount == 0.00 ){
				$clint = Employer::find_by_user_id( $package_invoice->fk_employer_id );
				
				if( $package_invoice->cv_views == "Y" ){
					$clint->cv_qty = $package_invoice->posts_quantity;
					$clint->add_cvs();
					$success=true;
				}
				if( $package_invoice->spotlight == "Y" ){
					$clint->spotlight_qty = $package_invoice->posts_quantity;
					$clint->add_more_spotlight_job_post();
					$success=true;
				}
				if ( $package_invoice->standard == "Y" ) {
					$clint->job_qty = $package_invoice->posts_quantity;
					$clint->add_more_job_post();
					$success=true;
				}else{}
				
				if( $success ){
					$package_invoice->package_status 	= 'Completed';
					$package_invoice->processed_date 	= date("Y-m-d H:i:s", time() );
					$package_invoice->update_package_status();
					
					$invoice_item = new Invoice;
					/* start **/
					$invoice_item->fk_invoice_id = $_POST['package_id'];
					$invoice_item->payment_type = "None";
					$invoice_item->amount ="0.00";
					$invoice_item->currency = "GBP";
					$invoice_item->receiver_id ="None";
					$invoice_item->txn_id  = $_POST['package_id'];
					$invoice_item->txn_type  ="None";
					$invoice_item->payer_status  ="None";
					$invoice_item->residence_country  ="None";
					$invoice_item->payment_date = date("Y-m-d H:i:s", time() );;
					
					if( $invoice_item->save() ){
					/** EMAIL TEXT **/
					$email_template = get_lang('email_template','confirm_order' );
					$subject= str_replace("#SiteName#", SITE_NAME, $email_template['email_subject']);
					
					
					$body = $email_template['email_text'];
					
					$body 	= str_replace("#FullName#", $clint->full_name(), $body);
					$body 	= str_replace("#SiteName#", SITE_NAME, $body );
					$body 	= str_replace("#InvoiceId#", $_POST['invoice_id'], $body);
					$body 	= str_replace("#Qty#", $package_invoice->posts_quantity, $body);
					$body 	= str_replace("#Amount#", $package_invoice->amount, $body);
					$body 	= str_replace("#PayMethod#", 'None', $body);
					$body 	= str_replace("#Domain#", 	$_SERVER['HTTP_HOST'], $body );
					$body 	= str_replace("#ContactUs#", 	ADMIN_EMAIL, $body );
					$body 	= str_replace("#Link#", 	BASE_URL, $body );
					
					$to 	= array("email" => $clint->email_address, "name" => $clint->full_name() );
					$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME );
					/** end email text **/
						
					$mail = send_mail( $body, $subject, $to, $from, "", "" );
					redirect_to(BASE_URL."employer/credits/");
					die;
					}
				}
	}
	

if( isset( $_POST['bt_confirm'] ) ) { 
	if ( $package_invoice->package_status != "Confirmed" ) {  
			$id=$package_invoice->id;
			$packageinvoice	= new PackageInvoice();
			$packageinvoice->id = $id;
			$packageinvoice->package_status = "Confirmed";
			$packageinvoice->update_package_status();
	}

	$package_invoice = PackageInvoice::find_by_id( $_POST['invoice_id'] );
	$smarty->assign('package_invoice', $package_invoice);
	
}else{
	redirect_to(BASE_URL."employer/credits/");
	die;
}

$smarty->assign('dont_include_left', true);

$html_title 		= SITE_NAME . " - Credits ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );
$smarty->assign('rendered_page', $smarty->fetch('employer/payment.tpl') );
?>