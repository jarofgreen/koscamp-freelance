<?php $_SESSION['direct_to_emp'] = "credits/"; 	
	 
	 include_once('sessioninc.php');
	destroy_my_session();
	$username = $session->get_username();
	$user_id = $session->get_user_id();

	$package = new Package();
	$all_packages = $package->find_all_active();
	if( $all_packages ) {
		$package_standard = array();
		$package_spotlight = array();
		$package_cv = array();
		$package_combination = array();
		
		$stand=1;
		$spot=1;
		$cv=1;
		$com=1;
		
		foreach( $all_packages as $list ){
			//standard packages
			if( $list->standard == 'Y' && $list->spotlight == 'N' && $list->cv_views == 'N' ){
				$package_standard[$stand]['package_name'] 	= $list->package_name;
				$package_standard[$stand]['package_price'] 	= $list->package_price;
				$package_standard[$stand]['package_desc']	= $list->package_desc;
				$package_standard[$stand]['package_job_qty']= $list->package_job_qty;
				$package_standard[$stand]['id']			 	= $list->id;

				$package_standard[$stand]['standard']  = $list->standard;
				$package_standard[$stand]['spotlight'] = $list->spotlight;
				$package_standard[$stand]['cv_views']  = $list->cv_views;

				//if( $i < sizeof($standard_credits) ) $package_list[$stand]['line']= true;
				//else $package_list[$i]['line']= false;
				$stand++;
			}
			//spotlight packages
			elseif( $list->standard == 'N' && $list->spotlight == 'Y' && $list->cv_views == 'N' ){
				$package_spotlight[$spot]['package_name'] 	= $list->package_name;
				$package_spotlight[$spot]['package_price'] = $list->package_price;
				$package_spotlight[$spot]['package_desc']	= $list->package_desc;
				$package_spotlight[$spot]['package_job_qty']= $list->package_job_qty;
				$package_spotlight[$spot]['id']			 = $list->id;

				$package_spotlight[$spot]['standard']  = $list->standard;
				$package_spotlight[$spot]['spotlight'] = $list->spotlight;
				$package_spotlight[$spot]['cv_views']  = $list->cv_views;

				//if( $i < sizeof($standard_credits) ) $package_list[$i]['line']= true;
				//else $package_list[$i]['line']= false;
				$spot++;
			}
			//cv packages
			elseif( $list->standard == 'N' && $list->spotlight == 'N' && $list->cv_views == 'Y' ){
				$package_cv[$cv]['package_name'] 	= $list->package_name;
				$package_cv[$cv]['package_price'] 	= $list->package_price;
				$package_cv[$cv]['package_desc']	= $list->package_desc;
				$package_cv[$cv]['package_job_qty']	= $list->package_job_qty;
				$package_cv[$cv]['id']			 	= $list->id;

				$package_cv[$cv]['standard']  = $list->standard;
				$package_cv[$cv]['spotlight'] = $list->spotlight;
				$package_cv[$cv]['cv_views']  = $list->cv_views;

				//if( $i < sizeof($standard_credits) ) $package_list[$i]['line']= true;
				//else $package_list[$i]['line']= false;
				$cv++;
			}
			//all other packages
			else{
				$package_combination[$com]['package_name'] 	= $list->package_name;
				$package_combination[$com]['package_price'] 	= $list->package_price;
				$package_combination[$com]['package_desc']	= $list->package_desc;
				$package_combination[$com]['package_job_qty']	= $list->package_job_qty;
				$package_combination[$com]['id']			 	= $list->id;

				$package_combination[$com]['standard']  = $list->standard;
				$package_combination[$com]['spotlight'] = $list->spotlight;
				$package_combination[$com]['cv_views']  = $list->cv_views;

				//if( $i < sizeof($standard_credits) ) $package_list[$i]['line']= true;
				//else $package_list[$i]['line']= false;
				
				$com++;
			}
		}
		$smarty->assign('standard_credits', $package_standard);
		$smarty->assign('spotlight_credits', $package_spotlight);
		$smarty->assign('cv_credits', $package_cv);
		$smarty->assign('combination_credits', $package_combination);
	}

	
/**	
	$package = new Package();
	$standard_credits 	= $package->find_all_active_standard();
	if( $standard_credits ) {
		$package_list = array();
		$i=1;
		foreach( $standard_credits as $list ){
			$package_list[$i]['package_name'] 	= $list->package_name;
			$package_list[$i]['package_price'] 	= $list->package_price;
			$package_list[$i]['package_desc']	= $list->package_desc;
			$package_list[$i]['package_job_qty']	= $list->package_job_qty;
			$package_list[$i]['id']			 	= $list->id;
			if( $i < sizeof($standard_credits) ) $package_list[$i]['line']= true;
			else $package_list[$i]['line']= false;
			
			$i++;	
		}
		$smarty->assign('standard_credits', $package_list);
	}

	$spotlight_credits 	= $package->find_all_active_spotlight();
	if( $spotlight_credits ) {
		$package_list = array();
		$i=1;
		foreach( $spotlight_credits as $list ){
			$package_list[$i]['package_name'] 	= $list->package_name;
			$package_list[$i]['package_price'] 	= $list->package_price;
			$package_list[$i]['package_desc']	= $list->package_desc;
			$package_list[$i]['package_job_qty']	= $list->package_job_qty;
			$package_list[$i]['id']			 	= $list->id;
			if( $i < sizeof($spotlight_credits) ) $package_list[$i]['line']= true;
			else $package_list[$i]['line']= false;
			
			$i++;	
		}
		$smarty->assign('spotlight_credits', $package_list);
	}

	$cv_credits 		= $package->find_all_active_cv();
	if( $cv_credits ) {
		$package_list = array();
		$i=1;
		foreach( $cv_credits as $list ){
			$package_list[$i]['package_name'] 	= $list->package_name;
			$package_list[$i]['package_price'] 	= $list->package_price;
			$package_list[$i]['package_desc']	= $list->package_desc;
			$package_list[$i]['package_job_qty']	= $list->package_job_qty;
			$package_list[$i]['id']			 	= $list->id;
			if( $i < sizeof($cv_credits) ) $package_list[$i]['line']= true;
			else $package_list[$i]['line']= false;
			
			$i++;	
		}
		$smarty->assign('cv_credits', $package_list);
	}
*/
	
	$clint->username = $username;
	
	$total_post 			= $clint->total_job_post();
	$smarty->assign('total_post', $total_post);
	
	$total_spotlight_post 	= $clint->total_spotlight_job_post();
	$smarty->assign('total_spotlight_post', $total_spotlight_post);
	
	$total_cv				= $clint->total_cv();
	$smarty->assign('total_cv', $total_cv);


$invoice = new PackageInvoice();
$invoice->fk_employer_id = $user_id;
$recent_orders = $invoice->recent_order_by_clint();

if($recent_orders){
	$package_list = array();
	$i=1;
	foreach( $recent_orders as $list ){
		$package_list[$i]['invoice_date'] 	= strftime(DATE_FORMAT, strtotime($list->invoice_date) );
		$package_list[$i]['id'] 			= $list->id;
		$package_list[$i]['item_name']		= $list->item_name;
		$package_list[$i]['package_status']	= $list->package_status;
		$package_list[$i]['amount']			= $list->amount;
		$package_list[$i]['package_id']		= $list->fk_package_id;
		$i++;	
	}
	$smarty->assign('recent_orders', $package_list);
}


$smarty->assign('dont_include_left', true);

$html_title 		= SITE_NAME . " - ".format_lang('page_title','credits');
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('employer/credits.tpl') );
?>