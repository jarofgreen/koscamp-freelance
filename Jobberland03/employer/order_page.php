<?php  $_SESSION['direct_to_emp'] = "order/?".$_SERVER['QUERY_STRING']; 	
	 include_once('sessioninc.php');

if ( FREE_SITE == "Y" ){
	redirect_to(BASE_URL."employer/account/");
	die;
}
	
	if( !isset($_REQUEST['package_id'])) { redirect_to(BASE_URL."employer/credits/"); }
	
	$user_id = $session->get_user_id();
	$username = $session->get_username();
	$user = Employer::find_by_id( $user_id );
	
	$packageinvoice	= new PackageInvoice();
	$packageinvoice->fk_employer_id = $user_id;//$user->username;
	$packageinvoice->fk_package_id = (int)$_REQUEST['package_id'];
	
     if (($_REQUEST['action']== 'post') || ($_REQUEST['action']=='premium_post')) { 
			$pack_invoice = $packageinvoice->check_invoice();
			if ( $pack_invoice ){ 
					$invoice_id = $pack_invoice->id;
			}else{
			  $package = Package::find_by_id( $_REQUEST['package_id'] );	
					if( $package ){
						$status = 'Selected';
						$packageinvoice->invoice_date 	= (gmdate("Y-m-d H:i:s"));
						$packageinvoice->processed_date = "null";
						$packageinvoice->package_status = $status;
						$packageinvoice->fk_employer_id = $user_id;
						$packageinvoice->fk_package_id 	= $package->id;
						$packageinvoice->posts_quantity = $package->package_job_qty;
						$packageinvoice->standard 		= $package->standard;
						$packageinvoice->spotlight 		= $package->spotlight;
						$packageinvoice->cv_views		= $package->cv_views;
						$packageinvoice->amount 		= $package->package_price;
						$packageinvoice->item_name 		= $package->package_name;
						$packageinvoice->subscr_date 	= "";
						$packageinvoice->payment_method = "";
						$packageinvoice->currency_code 	= "";
						$packageinvoice->currency_rate 	= "";
						$packageinvoice->reason			= "";
						
						if($packageinvoice && $packageinvoice->save() ){
							$invoice_id = $db->insert_id();
						}else{
							
						}
					}
			}
				$packageinvoice->id = $invoice_id;
				
				$packageinvoice->delete_inactive_invoice();
				$found_invoice = PackageInvoice::find_by_id( $invoice_id );
				if( !$found_invoice ) {  redirect_to(BASE_URL."employer/credits/"); }
				
				$smarty->assign('found_invoice', $found_invoice);
	 }else{
		 redirect_to(BASE_URL."employer/credits/");
	 }
	 

//payment_method.tpl	 
$PaymentModules = PaymentModules::find_all_active();
if( $PaymentModules ){
	$i=1;
	$manage_lists = array();
	foreach( $PaymentModules as $row ){	
		$manage_lists[$i]['id'] = $row->id;
		$manage_lists[$i]['name'] = $row->name;
		$manage_lists[$i]['module_key'] = $row->module_key;
		$manage_lists[$i]['enabled'] = $row->enabled;
		$i++;
	}
	$smarty->assign( 'payment_modules', $manage_lists );
}



$smarty->assign('dont_include_left', true);
$html_title 		= SITE_NAME . " - ".format_lang( "page_title", 'Confirmorder' );
$smarty->assign('package_id', $_REQUEST['package_id']);
$smarty->assign('invoice_id', $invoice_id);
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('employer/order.tpl') );
?>