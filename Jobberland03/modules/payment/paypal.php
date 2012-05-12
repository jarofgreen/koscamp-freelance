<?php
require_once( LIB_PATH.DS."class.database.php");
require_once( LIB_PATH.DS."class.paymentmodules.php");
require_once( LIB_PATH.DS."class.paymentconfig.php");
class paypal {
	
	public $module_key = 'paypal';
	
	public function button(){
		global $smarty;
		$paymentconfig = PaymentConfig::find_by_module_key( $this->module_key );
		foreach( $paymentconfig as $confitem ) {
			$paymod_data[ $confitem->config_key ] = $confitem->config_value;
		}
		unset($confdata);
		
		$smarty->assign( 'email', $paymod_data['MODULE_PAYMENT_PAYPAL_ID'] );
		$smarty->assign('run_mode', $paymod_data['MODULE_PAYMENT_PAYPAL_TESTMODE']) ;
		$smarty->assign('rendered_page', $smarty->fetch('employer/paypal_checkout.tpl') );
	}
	
	public function install(){
		global $db, $database;
		
		$paymentmodules 	= PaymentModules::find_by_module_key( $this->module_key );
		$paymentmodules->enabled = 'Y';
		$payment_module_id = $paymentmodules->id;
		$paymentmodules->save();
		
		$paymentconfig 	= new PaymentConfig();
		$paymentconfig->payment_module_id = $payment_module_id;
		$paymentconfig->module_key = 'paypal';
		$paymentconfig->config_title = 'E-Mail Address';
		$paymentconfig->config_key = 'MODULE_PAYMENT_PAYPAL_ID';
		$paymentconfig->config_value = 'yourname@yourdomain.com';
		$paymentconfig->config_description = 'The e-mail address to use for the PayPal service';
		//$paymentconfig->data_type;
		$paymentconfig->input_type = 'text';
		//$paymentconfig->input_options;	
		$paymentconfig->date_added = date("Y-m-d H:i:s", time());
		$paymentconfig->save();

		unset($paymentconfig->id);
		//$paymentconfig->payment_module_id = $payment_module_id;
		//$paymentconfig->module_key = 'paypal';
		$paymentconfig->config_title = 'Transaction Mode';
		$paymentconfig->config_key = 'MODULE_PAYMENT_PAYPAL_TESTMODE';
		$paymentconfig->config_value = 'test';
		$paymentconfig->config_description = 'The transaction is in test mode or not';
		//$paymentconfig->data_type;
		$paymentconfig->input_type = 'radio';
		$paymentconfig->input_options = 'test|live';	
		//$paymentconfig->date_added = 'NOW()';
		$paymentconfig->save();
		
	}
	
	public function remove(){
		$paymentmodules 	= PaymentModules::find_by_module_key( $this->module_key );
		$paymentmodules->enabled = 'N';
		$payment_module_id = $paymentmodules->id;
		$paymentmodules->save();
		
		PaymentConfig::delete_payment_config( $this->module_key );
	}
	
}

?>
