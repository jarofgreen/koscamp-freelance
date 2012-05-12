<?php if( !defined('SITE_ROOT') ){include_once("../../initialise_file_location.php");}
 
 $paymentconfig = PaymentConfig::find_by_module_key( 'paypal' );
		foreach( $paymentconfig as $confitem ) {
			$paymod_data[ $confitem->config_key ] = $confitem->config_value;
		}
		unset($confdata);
		
$paypal_email = $paymod_data['MODULE_PAYMENT_PAYPAL_ID'];
		
 // change these to your paypal settings
 //$paypal_email = MODULE_PAYMENT_PAYPAL_ID;//PAYPAL_EMAIL;
 $paypal_currency = CURRENCY_NAME;//CURRENCY;
 //$shipping = "0";//SHIPPING_FEE;

function processing ( $payment_status, $params ){
	global $paypal_email, $paypal_currency;
	$invoice_id = $params['item_number'];
	
	$invoice = PackageInvoice::find_by_id( $invoice_id );
	
	switch ($payment_status):
		case "Canceled_Reversal":
			$invoice->package_status = 'Canceled_Reversal';
			$invoice->update_package_status();
			break;
		case "Completed":
			if ( $paypal_email == $params['receiver_email'] 
				 && $paypal_currency == $params['mc_currency']
				 && $invoice->amount == $params['mc_gross']
				 && $invoice->package_status != "Completed"
			   )
			{
				$param['payment_status'] 	= "Completed"; //what is the status of the payment
				$param['amount'] 			= $params['mc_gross']; // how much was paid for this total amount for each item
				$param['currency'] 			= $paypal_currency; //what currecy they used to pay for this
				$param['receiver_id'] 		= $params['receiver_id']; // what is the id of person who is paying
				$param['payment_email'] 	= $params['payer_email']; // what email have they used to pay
				$param['txn_id'] 			= $params['txn_id']; // txt id
				$param['txn_type'] 			= $params['txn_type']; // how are they pay for this web or ext.
				$param['payer_status'] 		= $params['payer_status']; //is user verfied by the method they pay from
				$param['residence_country'] = $params['residence_country']; //which country does user belogn to
				//$params['origin'] = ""; //where is the payment come from
				$param['payment_method'] 	= "paypal"; // what methoid of payment they used e.g. paypal, ccbill
				$param['payment_vars'] 		= addslashes(serialize($params));; //get all var which are return from online site.
				$param['payment_type']		= $params['payment_type']; //how they pay for this
				$param['reason'] 			= ""; // if they cancel then tell user why
		
				process_payment( $invoice_id, $param);				
			}
			
			break;
		case "Denied":
			// denied by merchant
			//$invoice->id = $invoice_id;
			$invoice->package_status = 'Denied';
			$invoice->update_package_status();
			break;
		case "Failed":
			// only happens when payment is from customers' bank account
			//$invoice->id = $invoice_id;
			$invoice->package_status = 'Failed';
			$invoice->update_package_status();
			break;
		case "Pending":
			//$invoice->id = $invoice_id;
			$invoice->package_status = 'Pending';
			$invoice->update_package_status();
			break;
		case "Refunded":
			//$invoice->id = $invoice_id;
			$invoice->package_status = 'Refunded';
			$invoice->update_package_status();
			break;
		case "Reversed":
			//$invoice->id = $invoice_id;
			$invoice->package_status = 'Reversed';
			$invoice->update_package_status();
			break;
		case "Expired":
			//$invoice->id = $invoice_id;
			$invoice->package_status = 'Expired';
			$invoice->update_package_status();
			break;
		
		default:
			break;
	endswitch;
}

$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

$mode = $paymod_data['MODULE_PAYMENT_PAYPAL_TESTMODE']; //MODULE_PAYMENT_PAYPAL_TESTMODE;
if ($mode == 'test') {
	$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
} else {
	$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
}

if (!$fp) {
// HTTP ERROR
 die ("Error");
} else {
	
	fputs ($fp, $header . $req);
	while (!feof($fp)) {
	$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) {
			processing ( $_POST['payment_status'], $_POST );		
		}
		else if (strcmp ($res, "INVALID") == 0) {
			
		}
	}
	fclose ($fp);
}
?>