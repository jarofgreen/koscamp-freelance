<?php
	$session->logout();
	facebook_logout();
	redirect_to(BASE_URL.'login/');	
?>