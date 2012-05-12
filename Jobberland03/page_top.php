<?php
	if( $session->get_job_seeker() ){ 
		$user_id = $session->get_user_id();
		$user = Employee::find_by_id( $user_id );
		$loggin_user =  format_lang('Loggedinas')." <strong>" . $user->full_name() . "</strong> &nbsp; &nbsp; &nbsp; &nbsp;"; 
		$smarty->assign( 'loggin_user', $loggin_user );
		
		$smarty->assign('lang', $lang);
		$smarty->assign( 'message', $message );	
		$smarty->assign('top_header', $smarty->fetch('page_top_logo.tpl') );	
	}
?>