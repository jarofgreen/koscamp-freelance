<?php
	/** if user already logged in take them to index page */
	$session = new Session();
	if( !$session->get_recuriter() ){
		redirect_to(BASE_URL."employer/login/?error=1");
		die;
	}
?>