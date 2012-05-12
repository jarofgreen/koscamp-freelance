<?php
function __autoload( $class_name ){
	$class_name = strtolower( $class_name );
	$path = LIB_PATH.DS."class.{$class_name}.php";
	
	if( file_exists($path) ){
		require_once($path);
	}else{
		die("The file {$class_name}.php could not be found. ");
	}
}

function process_payment( $invoice_id=null, $params){
	$success=false;
	$invoice = PackageInvoice::find_by_id( $invoice_id );
 	// process payment
	$clint = Employer::find_by_id( $invoice->fk_employer_id );

	if( $invoice->cv_views == "Y" ){
		$clint->cv_qty = $invoice->posts_quantity;
		$clint->add_cvs();
		$success=true;
	}
	if( $invoice->spotlight == "Y" ){
		$clint->spotlight_qty = $invoice->posts_quantity;
		$clint->add_more_spotlight_job_post();
		$success=true;
	}
	if ( $invoice->standard == "Y" ) {
		$clint->job_qty = $invoice->posts_quantity;
		$clint->add_more_job_post();
		$success=true;
	}else{}

	if( $success ){
		$invoice->package_status 	= 'Completed';
		$invoice->processed_date 	= date("Y-m-d H:i:s", time() );
		$invoice->update_package_status();
		
		$invoice_item = new Invoice;
		/* start **/
/**		
		$param['payment_status'] = ""; //what is the status of the payment
		$param['amount'] = ""; // how much was paid for this total amount for each item
		$param['currency'] = ""; //what currecy they used to pay for this
		$param['receiver_id'] = ""; // what is the id of person who is paying
		$param['payment_email']; // what email have they used to pay
		$param['txn_id'] = ""; // txt id
		$param['txn_type'] = ""; // how are they pay for this web or ext.
		$param['payer_status'] = ""; //is user verfied by the method they pay from
		$param['residence_country'] = ""; //which country does user belogn to
		//$param['origin'] = ""; //where is the payment come from
		$param['payment_method'] = ""; // what methoid of payment they used e.g. paypal, ccbill
		$param['payment_vars'] = ""; //get all var which are return from online site.
		$param['payment_type'] = ""; //how they pay for this
		$param['reason'] = ""; // if they cancel then tell user why
**/
		
	$invoice_item->fk_invoice_id 	= $invoice_id;
	$invoice_item->payment_status 	= $params['payment_status'];
	$invoice_item->payment_type  	= $params['payment_type'];
	$invoice_item->amount 			= $params['amount'];
	$invoice_item->currency			= $params['currency'];
	$invoice_item->receiver_id 		= $params['receiver_id'];
	$invoice_item->payment_email 	= $params['payment_email'];
	$invoice_item->txn_id 			= $params['txn_id'];
	$invoice_item->txn_type 		= $params['txn_type'];
	$invoice_item->payer_status		= $params['payer_status'];
	$invoice_item->residence_country= $params['residence_country'];
	$invoice_item->payment_date		= date("Y-m-d H:i:s", time() );
	$invoice_item->reason			= $params['reason'];
	$invoice_item->origin			= $params['payment_method'];
	$invoice_item->payment_vars 	= $params['payment_vars'];
	
	if( $invoice_item->save() ){
		/** EMAIL TEXT **/
		$email_template = get_lang('email_template','confirm_order' );
		$subject= str_replace("#SiteName#", SITE_NAME, $email_template['email_subject']);
			
		$body = $email_template['email_text'];
		
		$body 	= str_replace("#FullName#", $clint->full_name(), $body);
		$body 	= str_replace("#SiteName#", SITE_NAME, $body );
		$body 	= str_replace("#InvoiceId#", $invoice_id, $body);
		$body 	= str_replace("#Qty#", $invoice->posts_quantity, $body);
		$body 	= str_replace("#Amount#", $invoice->amount, $body);
		$body 	= str_replace("#PayMethod#", 'None', $body);
		$body 	= str_replace("#Domain#", 	$_SERVER['HTTP_HOST'], $body );
		$body 	= str_replace("#ContactUs#", 	ADMIN_EMAIL, $body );
		$body 	= str_replace("#Link#", 	BASE_URL, $body );
		
		$to 	= array("email" => $clint->email_address, "name" => $clint->full_name() );
		$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME );
		/** end email text **/
			
		$mail = send_mail( $body, $subject, $to, $from, "", "" );
		//redirect_to(BASE_URL."employer/credits/");
		//die;
		return $mail;
	}
   }
	return false;
}
function create_new_password(){
	$alphanum  = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
	$new_pass = substr(str_shuffle($alphanum), 0, 10);
	return $new_pass;
}

function destroy_my_session(){
	unset( $_SESSION['package'], $_SESSION['lang'], $_SESSION['loc'], $_SESSION['reg']);
	unset( $_SESSION['add_job'], $_SESSION['account'], $_SESSION['apply'], $_SESSION['cl'], $_SESSION['share']);
	unset($_SESSION['addcv'], $_SESSION['spam_code'], $_SESSION['resume'], $_SESSION['feedback']);
}

function return_url(){
	$array1 =  $_SERVER['REQUEST_URI'];
	$array1 = str_replace('%20',' ',$array1);
	$array1 = preg_split('#/#', $array1 );
	
	$array2 = preg_split('#/#', DOC_ROOT);
	$result  = array_diff($array1, $array2);
	
	$array1_new = array();
	//for( $i=0; $i<sizeof($result); $i++){
	foreach ($result as $results ){
		if(!empty ($results) && $results != "" )
			$array1_new[] = $results;
	}
	
	return $array1_new;
}

function seo_words ( $str ){
	$str = remove_accent( $str );
	$str = strip_html( $str );
	$str = str_replace("&","",$str );
	$str = str_replace("&amp;", "", $str);
	return $str;
}



/*********** mod re-write ************/
function remove_accent( $str ){
	$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'Ð', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', '?', '?', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', '?', '?', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', '?', 'O', 'o', 'O', 'o', 'O', 'o', 'Œ', 'œ', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'Š', 'š', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Ÿ', 'Z', 'z', 'Z', 'z', 'Ž', 'ž', '?', 'ƒ', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?', '?');
	
	$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
  
  return str_replace($a, $b, $str);
}

function mod_url_rewriter($str){
	return strtolower(preg_replace( array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('-', '-', ''), remove_accent($str)));
} 

function redirect_to ( $url = NULL ){
	if( $url != NULL ){
		if( !headers_sent() ) {
			header("Location: {$url}");
			exit;
		}else{
			echo "<meta http-equiv=\"refresh\" content=\"0;url={$url}\">\r\n";
			exit;
		}
	}
}

function output_message ( $message="" ){
	if( !empty($message) ){
		return "<p class=\"message\">".$message."</p>";
	}else{
		return "";
	}
}

/** subtrack string */
function subtrack_string($string, $lenght ){
	$body = strip_tags($string);
	$line=$body;
	if (preg_match('/^.{1,'.$lenght.'}\b/s', $body, $match))
	{
		return $match[0];
	}
	return false;
}

/**check user which is being used***/
function check_username( $username ){
	//The username should contain only letters, numbers and underscores.
	$check = eregi_replace('([a-zA-Z0-9_]+)', "", $username);
	if(empty($check))
	{
		return true;
	}else{
		return false;
	}
}

/***
*Validate email address
return email
**/
function check_email($email){
	//check for vaild email user@demain.com/co.uk/net
	if( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) )
	{ 
		return $email;
	}
	return false;
}

function makeTimeStamp($year='', $month='', $day='')
{
   if(empty($year)) {
       $year = strftime('%Y');
   }
   if(empty($month)) {
       $month = strftime('%m');
   }
   if(empty($day)) {
       $day = strftime('%d');
   }
  
 $date= mktime(0, 0, 0, $month, $day, $year);		
			
   return $date;//mktime(0, 0, 0, $month, $day, $year);
}

function strip_html( $value ){
	$value = strip_tags($value);
	$value = preg_replace('/[^(\x20-\x7F)]*/','', $value);
	$value = preg_replace('/[^(\x20-\x7F)\x0A]*/','', $value);
	$value = str_replace("&bull;","",$value );
	$value = stripslashes($value);
	//$value = htmlentities($value);
	return $value;
}

function size_as_text( $size ) {
	if($size < 1024) {
		return "{$size} bytes";
	} elseif($size < 1048576) {
		$size_kb = round($size/1024);
		return "{$size_kb} KB";
	} else {
		$size_mb = round($size/1048576, 1);
		return "{$size_mb} MB";
	}
}

function stripHTMLTags( $content ) {

    $search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                     "'<\s*br\s*(\/)?>'i",              // Replace brs to spaces
                     "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                     "'([\r\n])[\s]+'",                 // Strip out white space
                     "'&(quot|#34);'i",                 // Replace html entities
                     "'&(amp|#38);'i",
                     "'&(lt|#60);'i",
                     "'&(gt|#62);'i",
                     "'&(nbsp|#160);'i",
                     "'&(iexcl|#161);'i",
                     "'&(cent|#162);'i",
                     "'&(pound|#163);'i",
                     "'&(copy|#169);'i",
                     "'&#(\d+);'");

    $replace = array ("",
                      " ",
                      "",
                      "\\1",
                      "\"",
                      "&",
                      "<",
                      ">",
                      " ",
                      chr(161),
                      chr(162),
                      chr(163),
                      chr(169),
                      "chr(\\1)");

    $content = preg_replace ($search, $replace, $content);

    return $content;
}

function allowedTags( $text ){
	$allowedTags='<p><strong><em><u><img><span><style><blockquote>';
	$allowedTags.='<li><ol><ul><span><div><br><ins><del><a><span>';
	
	return strip_tags( stripslashes($text), $allowedTags);
}

function DeleteCacheFiles($fromdir, $tm, $recursed = 1 ) {
	if ($fromdir == "" or !is_dir($fromdir)) {
		echo ('Invalid directory');
		exit;
		return false;
	}

	$filelist = array();
	$dir = opendir($fromdir);

	while($file = readdir($dir)) {
		if($file == "." || $file == ".." || $file == 'readme.txt' || $file == 'index.html' || $file == 'index.htm' || $file == 'lasttime.dat' ) {
			continue;
		} elseif (is_dir($fromdir."/".$file)) {
			if ($recursed == 1) {
				$temp = DeleteCacheFiles($fromdir."/".$file, $recursed);
			}
		} elseif (file_exists($fromdir."/".$file) && filemtime($fromdir."/".$file) < $tm) {
			unlink($fromdir."/".$file);
		}
	}

	closedir($dir);

	return true;
}


function deleteCache() {
	global $config;
	/* This function will delete cache files.. */
	//$tm = time() - $config['time_cache_expiry']*60;
	$tm = time() - 1*60;
	$lasttime = 0;
	if (is_readable(CACHE_DIR.DS.'lasttime.dat')) {
		$lt = file(CACHE_DIR.DS.'lasttime.dat');
		$lasttime = trim($lt[0]);
	}
	
	if ($lasttime < $tm) {
		DeleteCacheFiles(CACHE_DIR,$tm);
		
		$fp = @fopen(CACHE_DIR.DS.'lasttime.dat','wb');
		if ($fp) {
			fwrite($fp, time());
			fclose($fp);
		}
	}
}

function delete_template_c_files() {
	/* Remove files from templates_c directory */
	if ( $handle = opendir( TEMPLATE_C_DIR ) ) {
		while ( false !== ( $file = readdir( $handle ) ) ) {
			if ( $file != '.' && $file != '..' && $file != 'index.html' && $file != 'index.htm') {
				unlink( TEMPLATE_C_DIR .DS. $file );
			}
		}
		closedir($handle);

	}
	/* Remove cache files */
	if ( $handle = opendir( CACHE_DIR ) ) {
		while ( false !== ( $file = readdir( $handle ) ) ) {
			if ( $file != '.' && $file != '..' && $file != 'index.html' && $file != 'index.htm' && !is_dir($file) ) {
				unlink( CACHE_DIR .DS. $file );
			}
		}
		closedir($handle);
	}
}

function make_templateTPL ($resource_type, $resource_name, &$template_source, &$template_timestamp, &$smarty_obj)
{	
	//global 
	$skin_name = TEMPLATE;
	if ( !is_readable ( $resource_name )) {
		
		// create the template file, return contents.
		$new_resource = preg_replace( "/\b".$skin_name."\b/", 'default/', $smarty_obj->template_dir);
		$new_resource = $new_resource .$resource_name;
		
		$template_timestamp = filemtime($new_resource);
		$template_source = file_get_contents($new_resource);
		return true;
	}

}


//format my english text and then return back.
function format_lang($mkey=null, $skey=null ){
	global $lang;	
	if( empty($skey) ){
		$lang_v = get_lang($mkey);
	}else{
		$lang_v = get_lang ($mkey, $skey);
	}
	
	$lang_v = str_replace("#MAX_CV#", MAX_CV , $lang_v );
	$lang_v = str_replace("#SITE_NAME#", SITE_NAME , $lang_v );
	$lang_v = str_replace("#MAX_CV_SIZE#", size_as_text( MAX_CV_SIZE ) , $lang_v );
	$lang_v = str_replace("#skin_images_path#", skin_images_path , $lang_v );
	$lang_v = str_replace("#BASE_URL#", BASE_URL , $lang_v );
	$lang_v = str_replace("#CURRENCY_NAME#", CURRENCY_NAME , $lang_v );
	$lang_v = str_replace("#MAX_COVER_LETTER#", MAX_COVER_LETTER , $lang_v );
	$lang_v = str_replace("#JOBLASTFOR#", JOBLASTFOR , $lang_v );
	$lang_v = str_replace("#SITE_NAME#", SITE_NAME , $lang_v );
	$lang_v = str_replace("#SITE_NAME#", SITE_NAME , $lang_v );
	
	$lang_v = str_replace("#MINPASS#", 6 , $lang_v );
	$lang_v = str_replace("#MAXPASS#", 20 , $lang_v );

	$lang_v = str_replace("#CITIZEN#", 'UK/EU' , $lang_v );
	$lang_v = str_replace("#COUNTRY#", DEFAULT_COUNTRY , $lang_v );
	
	//ADD NEW JOB
	$lang_v = str_replace("#TOTAL_POST#", TEMP_TOTAL_POST , $lang_v );
	$lang_v = str_replace("#TOTAL_SPOTLIGHT_POST#", TEMP_TOTAL_SPOTLIGHT_POST , $lang_v );
	$lang_v = str_replace("#TOTAL_CV#", TEMP_TOTAL_CV , $lang_v );

	
	
	return $lang_v;
}






/*******************************************************/
/***********# OLD FUNCTION *****************************/
/**####################################################*/




###################################################################################



/** send array and return values which can be used in mysql query **/
function mysql_IN_values( $attributes ){
	$attribute_pairs = array();
	foreach($attributes as $key => $value) {
		if ( isset($value) && $value != "" ) {
			$attribute_pairs[] = "'{$value}'";
		}
	}
	return join(", ", $attribute_pairs);
}

function format_number( $value = 0) {
	$value = number_format( $value, 2, ".","" );
	return $value;
}




//remove zeros from date
/*
*$string 
* return string
*/
function strip_zeros_from_date( $string="" ){
	//first remove the zeros
	$no_zeros = str_replace('*0','', $string );
	
	//remove any remaining marks
	$clean_string = str_replace( '*','', $string );
	return $clean_string;
}






function validateURL($url){
	
return is_valid_url ( $url );

/*	
	
	$pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
	return preg_match($pattern, $url);
*/
}

function is_valid_url ( $url )
{
		$url = @parse_url($url);

		if ( ! $url) {
			return false;
		}

		$url = array_map('trim', $url);
		$url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];
		$path = (isset($url['path'])) ? $url['path'] : '';

		if ($path == '')
		{
			$path = '/';
		}

		$path .= ( isset ( $url['query'] ) ) ? "?$url[query]" : '';

		if ( isset ( $url['host'] ) AND $url['host'] != gethostbyname ( $url['host'] ) )
		{
			if ( PHP_VERSION >= 5 )
			{
				$headers = get_headers("$url[scheme]://$url[host]:$url[port]$path");
			}
			else
			{
				$fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30);

				if ( ! $fp )
				{
					return false;
				}
				fputs($fp, "HEAD $path HTTP/1.1\r\nHost: $url[host]\r\n\r\n");
				$headers = fread ( $fp, 128 );
				fclose ( $fp );
			}
			$headers = ( is_array ( $headers ) ) ? implode ( "\n", $headers ) : $headers;
			return ( bool ) preg_match ( '#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers );
		}
		return false;
}


function check_http( $url ){
	$link = substr($url,0,7);
	
	if( strtolower($link) == "http://" ){
		return $url;
	}
	$link = substr($url,0,8);
	if( strtolower($link) == "https://" ){
		return $url;
	}
	return "http://".$url;
}

/***
function innerHTML( $element, $text){

 	return "JavaScript: innerHTML( ".$element.", ".$text.");"; 
}

function return_setting_input_type( $setting ){
	//print_r($setting);
	$size = ( strlen($setting->value) > 35 ) ? strlen($setting->value) : strlen($setting->value)+10;
	
	if( $setting->input_type == "text" ){
		$option = "<input type='text' name='setting[".$setting->_name."]' value='".$setting->value."' size='{$size}'>";
	}
	
	elseif( $setting->input_type == "select"  ){
		
		if($setting->value=="Y") {$check_yes =  " selected='selected' ";}
		else {$check_no =  " selected='selected' ";}
		
		$option = "<select name='setting[".$setting->_name."]' >";
		$option .= "<option value='Y' {$check_yes} >Yes</option>";
		$option .= "<option value='N' {$check_no} >No</option>";
		$option .= "</select>";
	}
	
	elseif( $setting->input_type == "option" ){
		if($setting->value=="true") {$check_yes =  " selected='selected' ";}
		else {$check_no =  " selected='selected' ";}
		
		$option = "<select name='setting[".$setting->_name."]' >";
		$option .= "<option value='true' {$check_yes} >true</option>";
		$option .= "<option value='false' {$check_no} >false</option>";
		$option .= "</select>";
	}
	elseif( $setting->input_type == "textarea" ){
		
		$option = "<textarea name='setting[".$setting->_name."]' cols='40' rows='5' >".$setting->value."</textarea>";
	}
	
	elseif( $setting->input_type == "template" )
	{
		$dir = PUBLIC_PATH."/templates";
		if(is_dir($dir)){
			$option = "<select name='setting[".$setting->_name."]' >\n";
			if($dir_handle=opendir($dir)){
				while ($floder = readdir($dir_handle)) {
					if( is_dir("$dir/$floder") ){
						if( $floder != "." && $floder != ".." ){
							$option .= "<option>$floder</option>\n";
						}
					}
				}
				closedir($dir_handle);
			}
			$option .= "</select>\n";
		}
		//$option = templates ( "setting[".$setting->_name."]" );
	}
	return $option;
}

*/

function templates($name){
	$dir = PUBLIC_PATH."/templates";
	if(is_dir($dir)){
		$template_select = "<select name='$name' >\n";
		if($dir_handle=opendir($dir)){
			while ($floder = readdir($dir_handle)) {
				if( is_dir("$dir/$floder") ){
					if( $floder != "." && $floder != ".." ){
						$template_select .= "<option>$floder</option>\n";
					}
				}
			}
			closedir($dir_handle);
		}
		$template_select .= "</select>\n";
	}
	return $template_select;
}

/*
*out put information safely
*/
function safe_output($string) {
	$string = trim($string);
	if (empty($string)) { return ''; }
	
	$string = strip_tags($string, '<b><strong>');
	$string = htmlentities($string);
	return $string;
}

// strips out escape characters
function stripslashes_deep($value)
{
  $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
	return $value;
}



/*************************************************************************/

/***
*Check post code and vaildate the post code.
*return postcode if correct else return nothing
**/
function post_code($post_code) {
  $post_code = strtoupper(str_replace(chr(32),'',$post_code));
 
	if(ereg("^(GIR0AA)|(TDCU1ZZ)|((([A-PR-UWYZ][0-9][0-9]?)|"
			."(([A-PR-UWYZ][A-HK-Y][0-9][0-9]?)|"
			."(([A-PR-UWYZ][0-9][A-HJKSTUW])|"
			."([A-PR-UWYZ][A-HK-Y][0-9][ABEHMNPRVWXY]))))"
			."[0-9][ABD-HJLNP-UW-Z]{2})$", $post_code))
		return $post_code;
	else
		return false;
}//end of function


/***
*Validate phone number
**/
function phone_number($number){
	$number = str_replace( " ","",$number );
	$number = str_replace( "-","",$number );
	
	if ( strlen($number) == 11 ){
		if (eregi( "[0-9]{11}", $number)){
			return $number;
		}		
	}
	return false;
}


function validate_telephone_number($number){
	$formats = array('####-###-####',
					 '(####) ###-####',
					 '#### #### ####', 
					 '###########',
					 '#############',
					 '###############',
					 '(####) ###########',
					 '++#############'
					 );

	$format = trim(ereg_replace("[0-9]", "#", $number));

	return (in_array($format, $formats)) ? true : false;
}




/***
*validate string only, Must be string no numbers or anything else
*return string;
**/
function string_only( $str ){
	if ( ereg('^[A-Za-z_][A-Za-z_]*$', $str )){
		return $str;
	}
	return false;
}//end of function

function hour_rate(){
	$rateHours = array( "Not Specified" 		=> "None", 
					    "Below &pound;7" 		=> "7 ", 
					    "&pound;7-&pound;15" 	=> "7-15", 
					    "&pound;16-&pound;20" 	=> "16-20", 
					    "&pound;20-&pound;30" 	=> "20-30",
					    "&pound;30-&pound;40" 	=> "30-40",
					    "&pound;40-&pound;50" 	=> "40-50",
					    "&pound;50-&pound;60" 	=> "50-60",
					    "&pound;60-&pound;70" 	=> "60-70",
					    "&pound;70-&pound;80" 	=> "70-80",
					    "&pound;80-&pound;100" 	=> "80-100",
					    "Above  &pound;100"		=> "100"
					   );
	return $rateHours;
}


/*************************************************************************/

function getIpAddress(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    
    return $ip;
}


/* tell a friend **/
/**
function tell_a_friend(){
	$error = array();
	$session = new Session();
	$name = safe_output( $_POST['invite_name'] );
	if( empty($name) ){ $error[] = "Please enter your name";}
	
	$email = safe_output( $_POST['invite_email'] );
	if( empty($email) ){ $error[] = "Please enter your Friend's Email";}
	
	if( sizeof($error) == 0  )
	{
		$notes= $name." thought you might find this site of interest ";
		$notes.="<br /><br />http://www.".$_SERVER['HTTP_HOST'];
		$subject = SITE_NAME." - a friend thinks you may find this site useful";
		$send_to 	= array("email" => $email, "name" => $email );
		$send_from 	= array("email" => NO_REPLY_EMAIL, "name" => NO_REPLY_EMAIL );
		
		$mail = send_mail( $notes, $subject, $send_to, $send_from, null, null );
		
		if($mail){
			$session->message ( "<div class='success'>Your request has been sent successfully.</div>" );
			//redirect_to( $_SERVER['PHP_SELF']. !empty($_SERVER['QUERY_STRING']) ? "?".$_SERVER['QUERY_STRING'] : "" );
		}else{
			$session->message ( "<div class='error'>Problem sending email, please try again.</div>" );
		}
		
	}
	else
	{
		
		$message = "<div class='error'> 
						following error(s) found:
					<ul> <li />";
		$message .= join(" <li /> ", $error);
		
		$message .= " </ul> 
				   </div>";	
		$session->message ( $message );
	}
	$query_string="";
	if ( !empty( $_SERVER['QUERY_STRING'] ) || $_SERVER['QUERY_STRING'] != "" ){
		$query_string = "?".$_SERVER['QUERY_STRING'];
	}
	redirect_to( $_SERVER['PHP_SELF']. $query_string );
}

/*****/

function send_mail( $notes, $subject, $to, $from, $cv_file, $cv_letter ){
	
	if($cv_file || !empty($cv_file) || is_array($cv_file)) {
		$temp_path  = $cv_file['tmp_name'];
		//exit;
		$filename   = basename($cv_file['name']);
		$type       = $cv_file['type'];
		$size       = $cv_file['size'];
	}
	//to
	$send_to 	  = $to["email"];
	$send_to_name = $to["name"];
	//from
	$send_from 	    = $from["email"];
	$send_from_name	= $from["name"];


	if ( !MAILER_HOST && MAILER_HOST == "" )
	{
		require_once(LIB_PATH.DS."Rmail".DS."Rmail.php");
		/**
		* Now create the email it will be attached to
		*/
		$mail = new Rmail();
		
		if($cv_file || !empty($cv_file) || is_array($cv_file)) {			
			$mail->AddAttachment (new namedFileAttachment($temp_path, $filename, $type) );
		}
		
		//who is send the email
		$mail->setFrom($send_from_name.' <'.$send_from.'>');
		$mail->setSubject($subject);
		// body of the text
		$mail->setText($notes);
		$mail->setHTML($notes);
	   
		$result  = $mail->send($addresses = array( $send_to ));
		
		return $result;
		
	}else{
		
		if( MAILER_TEST &&  MAILER_TEST == 'true'):
			$mail = new PHPMailer(true);
			$mail->SMTPDebug  = 2;  // enables SMTP debug information (for testing)
		else:
			$mail = new PHPMailer();
		endif;
		
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host     = MAILER_HOST; // SMTP server
		$mail->SMTPAuth = MAILER_AUTH; // turn on SMTP authentication
		
		$mail->Host     = MAILER_HOST; // SMTP server
		$mail->Port     = MAILER_PORT;
		$mail->Username = MAILER_USERNAME; // SMTP username
		$mail->Password = MAILER_PASSWORD; // SMTP password
		
		try {
			$mail->AddAddress($send_to, $send_to_name);
			$mail->SetFrom($send_from, $send_from_name); //email, name
			
			$mail->Subject = $subject;
			$mail->AltBody = $notes; // optional - MsgHTML will create an alternate automatically
			$mail->MsgHTML($notes); //message 
			
			if($cv_file || !empty($cv_file) || is_array($cv_file)) {
				$mail->AddAttachment($temp_path, $filename, "base64", $type); // attachment
			}
			
			return $mail->Send();
			
		} catch (phpmailerException $e) {
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
			die;
		} catch (Exception $e) {
			echo $e->getMessage(); //Boring error messages from anything else!
			die;
		}
	}

}


//pluin test.

function facebook_logout(){
	echo '<script type="text/javascript">';
	echo 'FB.logout(function(response) {
  		    // user is now logged out
	     })';
	echo '</script>';
}
?>