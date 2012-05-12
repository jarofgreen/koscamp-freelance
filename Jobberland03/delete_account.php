<?php $user_id = $session->get_user_id();
	  $username = $session->get_username();

	if( isset($_POST['bt_delete_no']) )
	{
		$session->message ("<div class='success'>".format_lang('success','account_not_delete')."</div>");
		redirect_to(BASE_URL."account/");
		exit;
	}
	
	if( isset($_POST['bt_delete_yes']) )
	{
		$employee = new Employee();
		$employee->id = $user_id;
		$employee->username = $username;
		//$employee->is_active = "N";
		//$employee->employee_status = 'deleted';
		//if( $employee->deactive_user() )
		if( $employee->delete_user() )
		//if( $employee->delete() )
		{
			$session->message ("<div class='success'>".format_lang('success','account_delete')."</div>");
			$session->logout();
			redirect_to(BASE_URL."login/");
			exit;
		}else{
			$message = "<div class='error'>".format_lang('errormsg',58)."</div>";
		}
	}

$html_title = SITE_NAME . " - ". format_lang('page_title','delete_account')." ( " . $user->full_name() . " ) ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('delete_account.tpl') );
?>