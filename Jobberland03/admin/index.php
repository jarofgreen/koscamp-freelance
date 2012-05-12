<?php  require_once( "../initialise_files.php" );  
	
	if( $session->get_admin()){
		redirect_to("cpanel.php");
		die;
	}
	
	if( isset($_POST['bt_login'] ) ){
		$username = $_POST['txt_user'];
		$password = $_POST['txt_pass'];
		
		if( $username == "" || $password == "" ){
			$message = "<div class='error'>Please enter username and password.</div>";
		}else{		
			$user_found = Admin::authenticate( $username, $password );
			
			if( $user_found ){
					$access = "Admin";
					$session->login ( $user_found, $access );
					redirect_to("cpanel.php");
			}else{
				$message = "<div class='error'>Incorrect username or password.</div>";
			}
		}
	}

$html_title = SITE_NAME . " Add New Employer ";
$smarty->assign('lang', $lang);
$smarty->assign( 'message', $message );	
//$smarty->display('admin/login.tpl');
unset( $_SESSION['message']);
$smarty->assign('rendered_page', $smarty->fetch('admin/login.tpl') );
$smarty->display('admin/index.tpl');

//login.tpl
?>