<?php // payment_edit.php
require_once( "../initialise_files.php" );  
	include_once("sessioninc.php");

require_once( LIB_PATH.DS."class.paymentmodules.php");
require_once( LIB_PATH.DS."class.paymentconfig.php");

	if( $session->get_admin() ){
		$username = $session->get_username();
	}

$module_key = $_REQUEST['payment'];
$id = (int)$_REQUEST['id'];

if( isset( $_POST['bt_update'])){
	
	foreach( $_POST['payment_array'] as $key => $data )
	{	
	    $sql = "UPDATE ".TBL_PAYMENT_CONFIG. " SET config_value='".$data."' WHERE id={$key}";
		$db->query( $sql );
	}
	
	redirect_to(BASE_URL."admin/payment_edit.php?payment=".$module_key );
	die;	
}

$smarty->assign( 'page_title','Edit Payment Module: '.$module_key );


$paymentconfig 	= PaymentConfig::find_by_module_key( $module_key );
$i=1;
$manage_lists = array();
foreach( $paymentconfig as $row ){
    $manage_lists[$i]['id'] = $row->id;
	$manage_lists[$i]['title'] = $row->config_title;
	$manage_lists[$i]['configuration_key'] = $row->config_key;
	$manage_lists[$i]['configuration_value'] = $row->config_value;
	$manage_lists[$i]['configuration_description'] = $row->config_desc;
	$manage_lists[$i]['input'] = PaymentConfig::setting_value ( $row );
	$i++;
}
$smarty->assign( 'payment_editmodules', $manage_lists );

$html_title = SITE_NAME . " - Edit Payment Module " . $module_name;
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/payment_editmodules.tpl') );
$smarty->display('admin/index.tpl');
unset($_SESSION['message']);
?>