<?php   require_once( "../initialise_files.php" );  
	include_once("sessioninc.php");

	if( $session->get_admin() ){
		$username = $session->get_username();
	}

	if( isset($_POST['bt_change']) ){
		$admin 	= new Admin();
		
		$admin->username = $username;
		$admin->passwd	= $_POST['txt_new_pass'];
		$old_pass		= $_POST['txt_old_pass'];
		if( Admin:: authenticate($username, $old_pass ) ) {
			if($admin->change_password()){
				$session->message ("<div class='success'> Password has been change. </div>");
				redirect_to( $_SERVER['PHP_SELF'] );
				die;
			}
		}else{
			$message = "<div class='error'>Sorry old password does not match</div>";
		}
		
	}

$html_title = SITE_NAME . " - Change Password ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/change_password.tpl') );
$smarty->display('admin/index.tpl');
unset($_SESSION['message']);
?>