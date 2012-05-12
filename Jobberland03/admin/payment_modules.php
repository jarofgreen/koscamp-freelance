<?php
require_once( "../initialise_files.php" );  
	include_once("sessioninc.php");

	if( $session->get_admin() ){
		$username = $session->get_username();
	}


if ($_GET['install'])
{
	$payment= $_GET['install'];
	
	require( '../modules/payment/'.$payment.'.php' );

	$payment_module =& new $payment;

	$payment_module->install();
	
	redirect_to(BASE_URL."admin/payment_modules.php");
	die;
}
elseif($_GET['remove'])
{
	$payment= $_GET['remove'];
	
	require( '../modules/payment/'.$payment.'.php' );

	$payment_module =& new $payment;

	$payment_module->remove();
	
	redirect_to(BASE_URL."admin/payment_modules.php");
	die;
	
}

$PaymentModules = PaymentModules::find_all();
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

$html_title = SITE_NAME . " - Payment Modules ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/payment_modules.tpl') );
$smarty->display('admin/index.tpl');
unset($_SESSION['message']);
?>