<?php
	/** if user already logged in take them to index page */

	if( !$session->get_job_seeker() ){
		redirect_to(BASE_URL."login/?error=1");
		die;
	}

if( !$_POST && empty($_POST) ) {destroy_my_session();}

?>