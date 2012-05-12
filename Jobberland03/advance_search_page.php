<?php
	//$cat_values = Category::find_all();
	//$job_types = JobType::find_all();
	//$citys = City::find_all();

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

	$job_types	= JobType::find_all();
	if ( is_array($job_types) and !empty($job_types) ) {
		$job_t = array();
		$job_t[0] = get_lang("select_text");
		foreach( $job_types as $job_type ):
			$job_t[ $job_type->id ] = $job_type->type_name;
		endforeach; 
		$smarty->assign( 'job_type', $job_t );
	}

	$categories	= Category::find_all();
	if ( is_array($categories) and !empty($categories) ) {
		$category_t = array();
		//$category_t[0] = get_lang("select_text");
		foreach( $categories as $category ):
			$category_t[ $category->id ] = $category->cat_name;
		endforeach; 
		$smarty->assign( 'category', $category_t );
	}

   $search_in = ($_REQUEST['search_in'] != '' ) ? $_REQUEST['search_in'] : 2;
   $smarty->assign( 'search_in', $search_in );

   $smarty->assign( 'message', $message );	
   $smarty->assign('rendered_page', $smarty->fetch('advance_search.tpl') );
?>