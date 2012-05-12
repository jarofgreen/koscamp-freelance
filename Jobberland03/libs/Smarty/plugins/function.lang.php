<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_function_lang($params, &$smarty )
{  global $db, $database;
   $arkey = $params['mkey'];
   $key = $params['skey'];
   $code = $params['ckey'];
   
  	global $lang;
	//return format_lang( $arkey, $key );
	if(  !empty($code) ){
		//return format_lang( $arkey, $key );
		//return $lang[$arkey][$key][$code];
	}elseif( empty($key) ){
		return format_lang( $arkey, null );
		//return $lang[$arkey];
	}else{
		return format_lang( $arkey, $key );
		//return $lang[$arkey][$key];
	}
}

?>
