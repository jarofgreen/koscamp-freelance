<?php $_SESSION['direct_to'] = BASE_URL."curriculum_vitae/"; 	
	 include_once('sessioninc.php');
	
	$req = return_url();	
	$action = $req[1];
	$id = $req[2];
	$review = $req[3];
	
	$username = $session->get_username();
	$user_id = $session->get_user_id();
	$employee = Employee::find_by_id( $user_id );
	
	$cv_setting = new CVSetting();
	$cv_setting->fk_employee_id 	= $user_id;
	$total_max_cv = CVSetting::count_all_by_employee( $user_id );
	$smarty->assign( 'total_max_cv', $total_max_cv );

function check_total(){
	global $total_max_cv, $session;
	if( $total_max_cv >= MAX_CV ){
		$session->message("<div class='error'>".format_lang('errormsg',52)."</div>");
		redirect_to( BASE_URL."curriculum_vitae/" );
		die;
	 }
}

$lang["max_file_size"] = size_as_text( MAX_CV_SIZE );

	
//Are you sure you want to do this? You will lose this CV.

switch ( $action ){
	case "add":
		check_total();
		if( isset($_POST['bt_cv_add']) ){
			
			$_SESSION['addcv']['name'] = $cv_setting->cv_title 		= $_POST['txt_title'];
			$_SESSION['addcv']['desc'] = $cv_setting->cv_description = $_POST['txt_desc'];
			$cv_setting->fk_employee_id 	= $user_id;
			$cv_setting->attach_file( $_FILES['txt_file_cv'] );
			
			$cv = array();
			$cv = $_FILES['txt_file_cv'];
			
			if( $cv_setting && $cv_setting->save() ){
				destroy_my_session();
				$session->message("<div class='success'>".format_lang('success','cv_save_success')."</div>");
				
				$email_template = get_lang('email_template', 'save_cv');
				$subject 	= str_replace("#SiteName#", SITE_NAME, $email_template['email_subject']);
				
				$body = $email_template['email_text'];
				$body = str_replace("#FullName#", 	$employee->full_name(), $body );
				$body = str_replace("#SiteName#", 	SITE_NAME, $body);
				$body = str_replace("#Domain#", 	$_SERVER['HTTP_HOST'], $body );
				//$body = str_replace("#Link#", 		BASE_URL, $body);

				$to 	= array("email" => $employee->email_address, "name" => $employee->full_name() );
				$from 	= array("email" => NO_REPLY_EMAIL, "name" => SITE_NAME );
				
				$mail = send_mail( $body, $subject, $to, $from, "", "" );
				
				unset($_SESSION['addcv']);
				redirect_to( BASE_URL."curriculum_vitae/" );
			}else{
				$message = "<div class='error'> 
								".format_lang('following_errors')."
							<ul> <li />";
				$message .= join(" <li /> ", $cv_setting->errors );
				$message .= " </ul> 
							</div>";
			}
		}
	
		$html_title  = SITE_NAME . " - ".format_lang('page_title','cv_add_new') ." ". $employee->full_name();
		$smarty->assign( 'message', $message );	
		$smarty->assign('rendered_page', $smarty->fetch('addcv.tpl') );
		//exit;	
	break;
	
	case "rename":
				$cv = CVSetting::find_by_user_and_id( $id, $user_id );
				$name = $cv->cv_title;
				$notes = $cv->cv_description;
				$smarty->assign( 'name', $name );
				$smarty->assign( 'notes', $notes );
				$smarty->assign( 'id', $id );
				
		if( isset($_POST['bt_save']) ){
			
			$cv_name = $_POST['txt_title'];
			$cv->cv_description = $_POST['txt_desc'];
			$cv->cv_title = $cv_name;
			
			if ( $cv->save() ){
				$session->message("<div class='success'>".format_lang('success','cv_rename_success')."</div>");
				redirect_to( BASE_URL."curriculum_vitae/" );
			}else{
				$message = "<div class='error'>".format_lang('errormsg',53)."</div>";
			}
		}
		
		$html_title 		= SITE_NAME . " - ". ucfirst(format_lang('edit') ). " ".$name;
		$smarty->assign( 'message', $message );	
		$smarty->assign('rendered_page', $smarty->fetch('rename_cv_name.tpl') );
		//exit;
	break;
	
	case "delete":
		$id = (int)$id;
		$cv_setting = CVSetting::find_by_id( $id );
		unset($cv_setting->fk_employee_id);
		$cv_setting->fk_employee_id 	= $user_id;
		
		if($cv_setting->destroy()) {
			$session->message("<div class='success'>".format_lang('success','cv_delete')."</div>");
		}else{
			$session->message("<div class='error'>".format_lang('errormsg',54)."</div>");
		}
		redirect_to( BASE_URL."curriculum_vitae/" );
		//exit;
	break;
	
	case "copy":
		check_total();
		global $db;
		
		$copy_cv = $cv_setting->copy_cv($user_id, (int)$id );
		unset($copy_cv->id);
		$old = $copy_cv->cv_file_path.$copy_cv->cv_file_name;
		$copy_cv->cv_file_name  	= $copy_cv->fk_employee_id."_".time().".". $copy_cv->cv_file_exe;
		$new = $copy_cv->cv_file_path 	= SITE_ROOT . DS . FILE_UPLOAD_DIR . DS . $copy_cv->cv_file_name;
		$copy_cv->cv_status = "Private";
		$copy_cv->no_views  = 0;
		$copy_cv->default_cv = "N";
		
		if ( copy ( $old , $new ) ){
			if ( $copy_cv->save() )
			{
				$session->message("<div class='success'>".format_lang('success','cv_copied')."</div>");
				redirect_to( BASE_URL."curriculum_vitae/rename/".$db->insert_id()."/" );
				exit;
			}else{
				$session->message("<div class='error'>".format_lang('errormsg',56)."</div>");
			}
		}else{
			$session->message("<div class='error'>".format_lang('errormsg',57)."</div>");
		}
		redirect_to( BASE_URL."curriculum_vitae/" );
		exit;
	break;
	
	case "default":
		$cv_setting->fk_employee_id  = $user_id;
		$cv_setting->id 			 = (int)$id;
		if( $cv_setting->make_defult() ){ redirect_to( BASE_URL."curriculum_vitae/" ); }
		exit;
	break;
	
	case "resume":
		
		switch( $review ){
			case "change":
				include_once("resume_change.php");			
			break;
			default:
				include_once("view_resume.php");
			break;
		}
	
	break;
	
	
	case "download":
		$id    = (int)$id;
		$download = CVSetting::download_by_employee( $id, $user_id );
		$file_name 		= $download->cv_file_name;
		$orginal_name 	= $download->original_name;
		$file_type		= $download->cv_file_type;
		$file_size		= $download->cv_file_size;
		$file_path		= $download->cv_file_path;
		
		$location = $file_path.$file_name;
	
		//header("Content-Disposition: attachment; filename=".strip_tags(stripcslashes($orginal_name) ) . " ");
		header("Content-Disposition: attachment; filename=\"".$orginal_name."\""); // use 'attachment' to force a download
		header("Content-length: ".$file_size);
		header("Content-type: ".$file_type);
		
		readfile( $location );
		die;
	break;
	
	default:
	//if no cv has been upload then take them to add new cv screen
	if( $total_max_cv <=0 && $action != "add" ) redirect_to( BASE_URL."curriculum_vitae/add/" );
		
		//list of cover letter
		$my_cvs = CVSetting::employee_find_all($user_id);

		//$my_cls = CovingLetter::employee_find_all($user_id);
		
		if ( is_array($my_cvs) and !empty($my_cvs) ) {
			$cv_t = array();
			$i=1;
			foreach( $my_cvs as $my_cv ):
				if( $my_cv->is_defult == 'Y' ) 
				{
					//$letter = empty($_POST['txt_letter']) ? $my_letter->cl_text : safe_output( $_POST['txt_letter'] );
				}
					$cv_t[$i]["id"]  			= $my_cv->id;
					$cv_t[$i]["fk_employee_id"] = $my_cv->fk_employee_id;
					$cv_t[$i]["cv_title"]  		= $my_cv->cv_title;
					$cv_t[$i]["cv_status"]  	= $my_cv->cv_status;
					$cv_t[$i]["no_views"]  		= $my_cv->no_views;
					$cv_t[$i]["created_at"]  	= strftime(DATE_FORMAT, strtotime($my_cv->created_at) );
					$cv_t[$i]["modified_at"]  	= strftime(DATE_FORMAT, strtotime($my_cv->modified_at) );
					$cv_t[$i]["default_cv"]  	= $my_cv->default_cv;
					$i++;
			endforeach;
			$smarty->assign( 'my_cvs', $cv_t );
		}

		$html_title 		= SITE_NAME . " - ".format_lang('page_title','cv_show_default') . " ".$employee->full_name();
		$smarty->assign( 'message', $message );	
		$smarty->assign('rendered_page', $smarty->fetch('cv.tpl') );
		//exit;
	break;
}
?>