<?php

	$smarty->assign( 'message', $message );
	$smarty->assign('rendered_page', $smarty->fetch('employer/page-unavailable.tpl') );
?>