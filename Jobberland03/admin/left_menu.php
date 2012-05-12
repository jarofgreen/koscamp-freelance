<?php  require_once( "../initialise_files.php" );  

	include_admin_layout_template ("page_header.php");
?>
<table id="main_tb">
<colgroup>
	<col width="20%;" />
    <col />
</colgroup>
  <tr>
  	<td><?php include_admin_layout_template ("left_menu.php"); ?></td>
    <td>
    
    
<ul class="menu_body">
  <li><a href="#">About Us</a></li>
  <li><a href="#">Portfolio</a></li>

  <li><a href="#">Clients</a></li>
  <li><a href="#">Blog</a></li>
  <li><a href="#">Support Forums</a></li>

  <li><a href="#">Gallery</a></li>
  <li><a href="#">Contact Us</a></li>
</ul>


    </td>
  </tr>
</table>
<?php include_admin_layout_template ("page_footer.php"); ?>