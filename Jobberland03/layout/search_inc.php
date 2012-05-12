<?php
	
	$_SESSION['loc']['country'] = $country_code = empty($_REQUEST['txt_country']) ? DEFAULT_COUNTRY : $_REQUEST['txt_country'];

	$country 	= Country::find_all_order_by_name();
	if ( is_array($country) && !empty($country) ) {
		$country_t = array();
		$country_t['AA'] = 'All Countries';
		foreach( $country as $co ):
			if ($val['code'] != 'AA') {
				$country_t[ $co->code ] = $co->name;
			}
		endforeach; 
		$smarty->assign( 'country', $country_t );
	}

	$smarty->assign( 'message', $message );	
	$smarty->assign('search_bx', $smarty->fetch('basic_search.tpl') );
?>