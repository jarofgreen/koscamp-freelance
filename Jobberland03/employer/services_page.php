<?php $package = new Package();
	//spotlight
	$package_spotlights = $package->find_all_active_spotlight();
	if( $package_spotlights ) {
		$package_list = array();
		$i=1;
		foreach( $package_spotlights as $list ){
			$package_list[$i]['package_name'] 	= $list->package_name;
			$package_list[$i]['package_price'] 	= $list->package_price;
			$package_list[$i]['package_desc']	= $list->package_desc;
			$package_list[$i]['id']			 	= $list->id;
			if( $i < sizeof($package_spotlights) ) $package_list[$i]['line']= true;
			else $package_list[$i]['line']= false;
			
			$i++;	
		}
		$smarty->assign('package_spotlights', $package_list);
	}
	
	//standard
	$packages 			= $package->find_all_active_standard();
	if( $packages ) {
		$package_list = array();
		$i=1;
		foreach( $packages as $list ){
			$package_list[$i]['package_name'] 	= $list->package_name;
			$package_list[$i]['package_price'] 	= $list->package_price;
			$package_list[$i]['package_desc']	= $list->package_desc;
			$package_list[$i]['id']			 	= $list->id;
			if( $i < sizeof($package_spotlights) ) $package_list[$i]['line']= true;
			else $package_list[$i]['line']= false;
			
			$i++;	
		}
		$smarty->assign('package_list', $package_list);
	}

	//all service
	$packages 			= $package->find_all_active();
	if( $packages ) {
		$package_list = array();
		$i=1;
		foreach( $packages as $list ){			
				$package_list[$i]['package_name'] 	= $list->package_name;
				$package_list[$i]['package_price'] 	= $list->package_price;
				$package_list[$i]['package_desc']	= nl2br($list->package_desc);
				
				$package_list[$i]['standard']  = $list->standard;
				$package_list[$i]['spotlight'] = $list->spotlight;
				$package_list[$i]['cv_views']  = $list->cv_views;
				
				$package_list[$i]['id']			 	= $list->id;
				if( $i < sizeof($package_spotlights) ) $package_list[$i]['line']= true;
				else $package_list[$i]['line']= false;
			$i++;	
		}
		$smarty->assign('all_package', $package_list);
	}


$html_title 		= SITE_NAME . " - ".format_lang('page_title','services');
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('employer/services.tpl') );
//services_page.php	
?>