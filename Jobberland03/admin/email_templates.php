<?php  require_once( "../initialise_files.php" );  
	
	include_once("sessioninc.php");
	
	$allowedTags='<p><strong><em><u><img><span><style><blockquote>';
	$allowedTags.='<li><ol><ul><span><div><br><ins><del><a><span>';
	
	$email_template 	= new EmailTemplate();	
	
	if( isset($_POST['btn_add']) && $_POST['btn_add'] != "" ){

		$template_name 			= $email_template->email_template_name = strip_html($_POST['txt_tem_name']);
		$template_key 			= $email_template->template_key = strtoupper( strip_html($_POST['txt_key']) );
		$template_email 		= $email_template->from_email = strip_html($_POST['txt_from_email']);
		$template_frm_name 		= $email_template->from_name = strip_html($_POST['txt_from_name']);
		$template_subject 		= $email_template->email_subject = strip_html($_POST['txt_subject']);
		$template_body 			= $email_template->email_text = strip_tags( $_POST['txt_email_body'], $allowedTags );

		if($email_template->save()) {
			$session->message("Email Template has been added Successfully");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		} else {
			$message = "<div class='error'> 
						following error(s) found:
						<ul> <li />";
			$message .= join(" <li /> ", $email_template->errors);
			
			$message .= " </ul> 
					   </div>";
		}
	}
	
	if( isset($_POST['btn_update']) && $_POST['btn_update'] != "" ){
		$id 					= $email_template->id = (int)$_POST['id'];
		$template_name 			= $email_template->email_template_name = strip_html($_POST['txt_tem_name']);
		$template_key 			= $email_template->template_key = strtoupper( strip_html($_POST['txt_key']) );
		$template_email 		= $email_template->from_email = strip_html($_POST['txt_from_email']);
		$template_frm_name 		= $email_template->from_name = strip_html($_POST['txt_from_name']);
		$template_subject 		= $email_template->email_subject = strip_html($_POST['txt_subject']);
		$template_body 			= $email_template->email_text = strip_tags( $_POST['txt_email_body'], $allowedTags );
		
		if( $email_template->save() ) {
			$session->message("Email Template has been updated Successfully");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
			
		} else {
			$message = "Problem ";
		}
	}
	
	if( isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) )
	{
		//$sql = "Select * FROM email_templates WHERE id=".(int)$_POST['id'];
		$id  = (int)$_GET['id'];
		$email_template = EmailTemplate::find_by_id( $id );
	
		$template_name 			= strip_html( $email_template->email_template_name );
		$template_key			= strip_html( $email_template->template_key );
		$template_email 		= strip_html( $email_template->from_email );
		$template_frm_name 		= strip_html( $email_template->from_name );
		$template_subject 		= strip_html( $email_template->email_subject );
		$template_body 			= strip_tags( $email_template->email_text, $allowedTags );
	}

	$email_tempaltes = $email_template->find_all();
	
	include_admin_layout_template ("page_header.php");
?>

<script language="javascript" type="text/javascript">
  tinyMCE.init({
    theme : "advanced",
    mode: "exact",
    elements : "txt_email_body",
	skin : "o2k7",
    theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
    theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,"
							   + "justifyfull,fontselect,fontsizeselect,forecolor,backcolor",
	
	theme_advanced_buttons2 : "bullist, numlist, outdent, indent, |, cut,copy,paste,pastetext,"
							+ "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
	
	theme_advanced_buttons3 : "",
	
    height:"350px",
    width:"550px",
    file_browser_callback : 'myFileBrowser'
  });

</script>

<table id="main_tb">
<colgroup>
	<col width="20%;" />
    <col />
</colgroup>
  <tr>
    <td colspan="2"><?php include_admin_layout_template ("top.php"); ?></td>
  </tr>
  
  <tr>
  	<td valign="top"><?php include_admin_layout_template ("left_menu.php"); ?></td>
    <td valign="top">
    
    <div class="page_header"> Email Templates </div>
    
	<?php echo ( $message != "" ) ? output_message($message) : "	"; ?>
    
        
	<form action="" method="get" name="frm_email" id="frm_email" >
      <table width="100%" cellpadding="5" cellspacing="1" class="table_shade">
      	<colgroup>
          <col width="20%" />
          <col width="80%" />
        </colgroup>
        
        <tr>
          <td class="cell_shade"><label class="label">Templates: </label></td>
          <td class="cell_white">
            <select name="id" onchange="javascript: this.form.submit();">
              <option value="">Add Email Template</option>
              <?php  foreach ( $email_tempaltes as $email_tempalte ): ?>
             	<option value="<?php echo $email_tempalte->id; ?>" <?php echo ($email_tempalte->id == $_GET['id']) ?'selected="selected"' : ""; ?> ><?php echo $email_tempalte->email_template_name; ?></option>
             <?php endforeach;?>
            </select>
          </td>
        </tr>
      </table>
    </form>
    <br />  
	<form action="" method="post" name="frm_email_tem" id="frm_email_tem" >
    	<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
      <table width="100%" cellpadding="5" cellspacing="1" class="table_shade">
          <colgroup>
              <col width="20%" />
              <col width="80%" />
          </colgroup>
        <tr>
          <td class="cell_shade"><label class="label">Email Template Name: </label></td>
          <td class="cell_white"><input type="text" name="txt_tem_name" size="40" value="<?php echo $template_name; ?>" /></td>
        </tr>
        
         <tr>
          <td class="cell_shade"><label class="label">Key: </label></td>
          <td class="cell_white"><input type="text" name="txt_key" size="30" value="<?php echo $template_key; ?>" /></td>
        </tr>
        
        <tr>
          <td class="cell_shade"><label class="label">From Address: </label></td>
          <td class="cell_white"> <input type="text" name="txt_from_email" size="35" value="<?php echo $template_email; ?>" /></td>
        </tr>
        <tr>
          <td class="cell_shade"><label class="label">From Name: </label></td>
          <td class="cell_white"><input type="text" name="txt_from_name" size="30" value="<?php echo $template_frm_name; ?>" /></td>
        </tr>
        <tr>
          <td class="cell_shade"><label class="label">Subject: </label></td>
          <td class="cell_white"> <input type="text" name="txt_subject" size="50" value="<?php echo $template_subject; ?>" /></td>
        </tr>
        <tr>
          <td class="cell_shade"><label class="label">Email Text: </label></td>
          <td class="cell_white">
          <a href="javascript: void(0)" onclick="popup('email_template_help.html')">List of Commands</a>
          <textarea name="txt_email_body" id="txt_email_body"><?php echo $template_body; ?></textarea>
          <a href="javascript: void(0)" onclick="popup('email_template_help.html')">List of Commands</a>
          
          </td>
        </tr>
        
        <tr>
          <td class="cell_shade">&nbsp;</td>
          <td class="cell_white">
          <?php if( $_GET['id'] == "" || !isset($_GET['id']) ) { ?>
            	<input type="submit" name="btn_add" value="Add Template" class="button" />
            <?php } else{ ?>
            	<input type="submit" name="btn_update" value="Modify Template" class="button" />
            <?php } ?>
          </td>
        </tr>
        
      </table>
	 </form>
     
     
    </td>
  </tr>
</table>
<?php include_admin_layout_template ("page_footer.php"); ?>