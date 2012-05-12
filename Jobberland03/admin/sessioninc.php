<?php require_once( "../initialise_files.php" );  
	if( !$session->get_admin() ){
		redirect_to("index.php");
		die;
	}
 //include_once('sessioninc.php');


?>