<?php //$package = new Package();
	//all service
	//$packages 			= $package->find_all_active();
	
	$sql = "SELECT * FROM ".TBL_PACKAGE . " ORDER BY RAND() LIMIT 1";
	$packages = Package::find_by_sql($sql);
	
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

$smarty->assign('lang', $lang);
$smarty->assign('left_side', $smarty->fetch('employer/left_side.tpl') );
?>