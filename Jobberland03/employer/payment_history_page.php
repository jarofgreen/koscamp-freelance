<?php $_SESSION['direct_to_emp'] = "credits/"; 	
	 
	 include_once('sessioninc.php');
	
	$username = $session->get_username();
	$user_id = $session->get_user_id();
	
	$invoice = new PackageInvoice();
	$invoice->fk_employer_id = $user_id;
	$recent_orders = $invoice->orders_by_user();
	
	if($recent_orders){
		$package_list = array();
		$i=1;
		foreach( $recent_orders as $list ){
			$pack = Package::find_by_id( $list->fk_package_id );
			
			$package_list[$i]['invoice_date'] 	= strftime(DATE_FORMAT, strtotime($list->invoice_date) );
			$package_list[$i]['processed_date'] = ($list->processed_date == "0000-00-00 00:00:00" || $list->processed_date == 'null') ? "Not Confirmed" : strftime(DATE_FORMAT, strtotime($list->processed_date) );
			$package_list[$i]['id'] 			= $list->id;
			$package_list[$i]['item_name']		= $list->item_name;
			$package_list[$i]['package_desc']	= $pack->package_desc;
			$package_list[$i]['posts_quantity']	= $list->posts_quantity;
			$package_list[$i]['standard']		= $list->standard;
			$package_list[$i]['spotlight']		= $list->spotlight;
			$package_list[$i]['cv_views']		= $list->cv_views;
			$package_list[$i]['package_status']	= $list->package_status;
			$package_list[$i]['amount']			= $list->amount;
			$package_list[$i]['package_id']		= $list->fk_package_id;
			$i++;	
		}
		$smarty->assign('recent_orders', $package_list);
	}
	
$smarty->assign('dont_include_left', true);

$html_title 		= SITE_NAME . " - ".format_lang("page_title", 'PaymentHistory');
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('employer/payment_history.tpl') );
//payment_history.tpl
?>