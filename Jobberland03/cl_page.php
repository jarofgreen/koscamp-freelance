<?php $_SESSION['direct_to'] = BASE_URL."covering_letter/"; 	
	 include_once('sessioninc.php');
	
	$req = return_url();	
	$action = $req[1];
	$id = $req[2];
	
	$username = $session->get_username();
	$user_id = $session->get_user_id();
	
	$employee = Employee::find_by_id($user_id);	
	$covingletter 	= new CovingLetter();
	
	$total_max_cl = CovingLetter::count_all_by_employee( $user_id );
	$smarty->assign( 'total_max_cl', $total_max_cl );	
		
switch ( $action ){
	case "add":
	
		if( $total_max_cl >= MAX_COVER_LETTER ){
			$v = format_lang('errormsg', 8);
			//exit;
			$session->message("<div class='error'>".format_lang('errormsg', 8)."</div>");
			redirect_to( BASE_URL."covering_letter/"  );
			die;
		}
	
		//when add button is clicked
		if( isset($_POST['bt_cl_add']) ){
			
			if( $total_max_cl >= MAX_COVER_LETTER ){
				$session->message("<div class='error'>".format_lang('errormsg', 8)."</div>");
				redirect_to( BASE_URL."covering_letter/"  );
				die;
			}
			
			$_SESSION['cl']['title'] = $covingletter->cl_title 	= strip_html($_POST['txt_name']);
			$_SESSION['cl']['text']  = $covingletter->cl_text 	= strip_tags ($_POST['txt_letter'], "\n\t");
			//$covingletter->cl_text = 0;
			
			$covingletter->fk_employer_id 	= $user_id;
			//echo "bt was clicked ";
			if( $covingletter && $covingletter->save() ){
				$session->message("<div class='success'>".format_lang('success','cl_save_success')."</div>");
				
				//$employee = Employee::find_by_username( $username );
				//$email_tem = EmailTemplate::find_by_key( "SAVE_CV" );
				//$subject 	= str_replace("#SiteName#",SITE_NAME, $email_tem->email_subject);
				
				//$body = $email_tem->email_template_body();
	
				//$to 	= array("email" => $employee->email_address, "name" => $employee->full_name() );
				//$from 	= array("email" => $email_tem->from_email, "name" => $email_tem->from_name );
				
				//$mail = send_mail( $body, $subject, $to, $from, "", "" );
				
				redirect_to( BASE_URL."covering_letter/" );
			}else{
				$message = "<div class='error'> 
								".get_lang('following_errors')."
							<ul> <li />";
				$message .= join(" <li /> ", $covingletter->errors );
				$message .= " </ul> 
							</div>";
			}
		}
		$html_title 		= SITE_NAME . " - ".format_lang('page_title','newcoverletter');
		$smarty->assign( 'message', $message );	
		$smarty->assign('rendered_page', $smarty->fetch('add_cover_letter.tpl') );
	break;

	case "edit":
		//editing
		if( isset($id) ){
			$id = (int)$id;
			$edit_cl = CovingLetter::find_by_id_username( $id, $user_id );
			$edit_title = $edit_cl->cl_title;
			$smarty->assign( 'cl_title', $edit_title );
			$edit_text = $edit_cl->cl_text ;
			$smarty->assign( 'cl_text', $edit_text );
		}
		
		//edit buttn
		if( isset($_POST['bt_cl_edit']) ){
			//$id =  $_POST['id'];
			$covingletter->id 				= (int)$id;
			$covingletter->cl_title 		= strip_html($_POST['txt_name']);
			$covingletter->cl_text 			= strip_tags ($_POST['txt_letter'], "\n\t");
			$covingletter->fk_employer_id 	= $user_id;
			
			if( $covingletter && $covingletter->save() ){
				$session->message("<div class='success'>".format_lang('success','cl_update_success')."</div>");
				redirect_to( BASE_URL."covering_letter/" );
			}else{
				$message = "<div class='error'> 
								".get_lang('following_errors')."
							<ul> <li />";
				$message .= join(" <li /> ", $covingletter->errors );
				$message .= " </ul> 
							</div>";
			}
		}
		$html_title 		= SITE_NAME . " - ".ucfirst( format_lang('edit') ) . $edit_title;
		
		$smarty->assign( 'message', $message );	
		$smarty->assign('rendered_page', $smarty->fetch('edit_cover_letter.tpl') );
	break;
			
	case "delete":			
		//deleting
		if( isset($id)){
			$id = (int)$id;
			$covingletter->fk_employer_id 	= $user_id;
			$covingletter->id 			= $id;
			if($covingletter->delete_by_user()) {
				$session->message("<div class='success'>".format_lang('success','cl_delete')."</div>");
			}else{
				$session->message("<div class='error'>".format_lang('errormsg',49)."</div>");
			}
		}
		redirect_to( BASE_URL."covering_letter/" );
	break;
	
	case "default":
		//making it defult
		if( isset($id) ){
			$covingletter->fk_employer_id 	= $user_id;
			$covingletter->id 				= (int)$id;
			if( $covingletter->make_defult() ){ 
				redirect_to( BASE_URL."covering_letter/" ); 
			}else{
				$session->message("<div class='error'>".format_lang('errormsg',48)."</div>");
			}
		}
	break;
	
	default:
		if( $total_max_cl <=0 && $action != "add" ) redirect_to( BASE_URL."covering_letter/add/" );
		
		//list of cover letter
		$my_cls = CovingLetter::employee_find_all($user_id);
		if ( is_array($my_cls) and !empty($my_cls) ) {
			$cl_t = array();
			$i=1;
			foreach( $my_cls as $my_letter ):
				if( $my_letter->is_defult == 'Y' ) 
				{
					$letter = empty($_POST['txt_letter']) ? $my_letter->cl_text : safe_output( $_POST['txt_letter'] );
				}
					$cl_t[$i]["id"]  			= $my_letter->id;
					$cl_t[$i]["fk_employer_id"] = $my_letter->fk_employer_id;
					$cl_t[$i]["cl_title"]  		= $my_letter->cl_title;
					$cl_t[$i]["cl_text"]  		= $my_letter->cl_text;
					$cl_t[$i]["created_at"]  	= strftime(DATE_FORMAT, strtotime($my_letter->created_at) );
					$cl_t[$i]["modified_at"]  	= strftime(DATE_FORMAT, strtotime($my_letter->modified_at) );
					$cl_t[$i]["is_defult"]  	= $my_letter->is_defult;
					$i++;
			endforeach;
			$smarty->assign( 'my_letters', $cl_t );
		}
		
		$html_title 		= SITE_NAME . " - ".format_lang('page_title','cl_show_default'). " " . $employee->full_name();
		$smarty->assign( 'message', $message );	
		$smarty->assign('rendered_page', $smarty->fetch('cover_letter.tpl') );
	break;
}	
?>