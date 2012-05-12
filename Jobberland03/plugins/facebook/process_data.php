<?php 
	if ( !defined( 'SMARTY' ) ) {
	   include_once("./../../initialise_file_location.php");
	}
   	global $db, $database;
				
   include_once (PLUGIN_PATH.DS."facebook/fbmain.php");
 
   echo  $config['baseurl']  =   FB_BASEURL;//"http://jobberland.com/demo/facebook/index.php";
	die;
    //if user is logged in and session is valid.
    if ($fbme){

        //Calling users.getinfo legacy api call example
        try{
            $param  =   array(
                'method'  => 'users.getinfo',
                'uids'    => $fbme['id'],
                'fields'  => 'id, email, first_name, last_name, name, current_location, profile_url',
                'callback'=> ''
            );
            $userInfo   =   $facebook->api($param);		
				foreach ( $userInfo as $key => $data ) {
					
					$first_name = $data['first_name'];
					$last_name = $data['last_name'];
					$email =$data['email'];
					$id = $data['id'];
				 }
				 die;
				  $pass = create_new_password();
				  $employee = new Employee();
				  $employee->terms = 1;
				  $username = explode("@", $email );
				  $employee->username 		= $username[0];
				  $employee->email_address 	= $email;
				  $employee->passwd 		= $pass;
				  $employee->confirm_passwd = $pass;
				  $employee->fname 			= $first_name;
				  $employee->sname 			= $last_name;
				  $employee->country = "UK";
				  $employee->employee_status = "active";
				  $employee->is_active = "Y";
				  $employee->extra_id = "facebook_".$id;
				 
				 if ($employee->save() ){
				  $user_id = $db->insert_id();
				  $employee->id = $user_id;
				  //$employee->active_user();
				  $employee->approved_account();
				  $user_found = Employee::find_by_id( $user_id );
				  $access = "User";
				//session_start();
				//$_SESSION['user_id'] = $user_id;
				//$_SESSION['username'] 		= $employee->username ;
				//$_SESSION['access_level'] 	= $access;
				
				//die;
				global $session;
				$session = new Session();
				$session->login ( $user_found, $access );
				
				 }else{
					$message = "<div class='error'> 
							".get_lang('following_errors')."
						<ul> <li />";
					$message .= join(" <li /> ", $employee->errors );
					$message .= " </ul> 
							</div>";
				$session->message ( $message );
				$smarty->assign( 'message', $message );	
				redirect_to( BASE_URL . "login/"); exit;
				}
				
				//echo $message;
				//die("error".$message);
				redirect_to( BASE_URL . "account/"); exit;
        }
        catch(Exception $o){
            //d($o);
        }
    }
redirect_to( BASE_URL . "login/"); 
exit;
?>