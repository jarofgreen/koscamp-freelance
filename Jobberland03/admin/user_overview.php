<?php  require_once( "../initialise_files.php" );  

	include_once("sessioninc.php");
	
	$session->set_page( "register" );
	
	//$emp_join_today = ClintEmployer::member_join_today();
	
	
	include_admin_layout_template ("page_header.php");
?>
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
    <div class="page_header"></div>
	<?php echo ( $message != "" ) ? output_message($message) : "	"; ?>
              	
    <?php  echo $emp_join_today; ?>
    
    </td>
  </tr>
</table>
<?php include_admin_layout_template ("page_footer.php"); ?>