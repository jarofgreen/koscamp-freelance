<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	$total_posting 		= (int)Job::count_all();

$smarty->assign('total_posting', $total_posting);
	
	/** approved */
	$total_active_approved				= (int)Job::count_all_active_approved();
$smarty->assign('total_active_approved', $total_active_approved);
	$total_not_active_approved			= (int)Job::count_all_not_active_approved();
$smarty->assign('total_not_active_approved', $total_not_active_approved);
	//today
	$total_active_approval_today		= (int)Job::count_all_active_approval_today();
$smarty->assign('total_active_approval_today', $total_active_approval_today);
	$total_not_active_approval_today	= (int)Job::count_all_not_active_approval_today();
$smarty->assign('total_not_active_approval_today', $total_not_active_approval_today);
	//week
	$total_active_approval_week			= (int)Job::count_all_active_approval_week();
$smarty->assign('total_active_approval_week', $total_active_approval_week);
	$total_not_active_approval_week		= (int)Job::count_all_not_active_approval_week();
$smarty->assign('total_not_active_approval_week', $total_not_active_approval_week);
	//month
	$total_active_approval_month		= (int)Job::count_all_active_approval_month();
$smarty->assign('total_active_approval_month', $total_active_approval_month);
	$total_not_active_approval_month	= (int)Job::count_all_not_active_approval_month();
$smarty->assign('total_not_active_approval_month', $total_not_active_approval_month);
	
	/** pending */
	$total_active_pending				= (int)Job::count_all_active_pending();
$smarty->assign('total_active_pending', $total_active_pending);
	$total_not_active_pending			= (int)Job::count_all_not_active_pending();
$smarty->assign('total_not_active_pending', $total_not_active_pending);
	
	$total_active_pending_today			= (int)Job::count_all_active_pending_today();
$smarty->assign('total_active_pending_today', $total_active_pending_today);
	$total_not_active_pending_today		= (int)Job::count_all_not_active_pending_today();
$smarty->assign('total_not_active_pending_today', $total_not_active_pending_today);
	
	$total_active_pending_week			= (int)Job::count_all_active_pending_week();
$smarty->assign('total_active_pending_week', $total_active_pending_week);
	$total_not_active_pending_week		= (int)Job::count_all_not_active_pending_week();
$smarty->assign('total_not_active_pending_week', $total_not_active_pending_week);
	
	$total_active_pending_month			= (int)Job::count_all_active_pending_month();
$smarty->assign('total_active_pending_month', $total_active_pending_month);
	$total_not_active_pending_month		= (int)Job::count_all_not_active_pending_month();
$smarty->assign('total_not_active_pending_month', $total_not_active_pending_month);
	
	
	/** rejected */
	$total_active_rejected				= (int)Job::count_all_active_rejected();
$smarty->assign('total_active_rejected', $total_active_rejected);
	$total_not_active_rejected			= (int)Job::count_all_not_active_rejected();
$smarty->assign('total_not_active_rejected', $total_not_active_rejected);
	
	$total_active_rejected_today		= (int)Job::count_all_active_rejected_today();
$smarty->assign('total_active_rejected_today', $total_active_rejected_today);
	$total_not_active_rejected_today	= (int)Job::count_all_not_active_rejected_today();
$smarty->assign('total_not_active_rejected_today', $total_not_active_rejected_today);
	
	$total_active_rejected_week			= (int)Job::count_all_active_rejected_week();
$smarty->assign('total_active_rejected_week', $total_active_rejected_week);
	$total_not_active_rejected_week		= (int)Job::count_all_not_active_rejected_week();
$smarty->assign('total_not_active_rejected_week', $total_not_active_rejected_week);
	
	$total_active_rejected_month		= (int)Job::count_all_active_rejected_month();
$smarty->assign('total_active_rejected_month', $total_active_rejected_month);
	$total_not_active_rejected_month	= (int)Job::count_all_not_active_rejected_month();
$smarty->assign('total_not_active_rejected_month', $total_not_active_rejected_month);
	
	/** expired */
	$total_active_expired				= (int)Job::count_all_active_expired();
$smarty->assign('total_active_expired', $total_active_expired);
	$total_not_active_expired			= (int)Job::count_all_not_active_expired();
$smarty->assign('total_not_active_expired', $total_not_active_expired);
	
	$total_active_expired_today			= (int)Job::count_all_active_expired_today();
$smarty->assign('total_active_expired_today', $total_active_expired_today);
	$total_not_active_expired_today		= (int)Job::count_all_not_active_expired_today();
$smarty->assign('total_not_active_expired_today', $total_not_active_expired_today);
	
	$total_active_expired_week			= (int)Job::count_all_active_expired_week();
$smarty->assign('total_active_expired_week', $total_active_expired_week);
	$total_not_active_expired_week		= (int)Job::count_all_not_active_expired_week();
$smarty->assign('total_not_active_expired_week', $total_not_active_expired_week);
	
	$total_active_expired_month			= (int)Job::count_all_active_expired_month();
$smarty->assign('total_active_expired_month', $total_active_expired_month);
	$total_not_active_expired_month		= (int)Job::count_all_not_active_expired_month();
$smarty->assign('total_not_active_expired_month', $total_not_active_expired_month);


$html_title = SITE_NAME . " Job Overview ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/job_overview.tpl') );
$smarty->display('admin/index.tpl');
?>