<?php  require_once( "../initialise_files.php" );  

include_once('sessioninc.php');

if( isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) ) { 
		if( isset($_GET['bt_update']) ){
			$city = new City();
			$city->id = (int)$_GET['id'];
			$city->city_name = $_GET['txt_name'];
			$city->city_code = $_GET['txt_code_name'];
			$city->is_active = $_GET['txt_active'];
			
			if($city->save()){
				$session->message ("City updated ");
				redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
				die;
			}else{
				$message = join("<br />", $city->errors );
			}
		}
}

if( isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) ) { 
	$city = new City();
	$city->id = (int)$_GET['id'];
	if( $city->delete() ){
		$session->message ("City deleted ");
		redirect_to( $_SERVER['PHP_SELF']."?#". $_GET['id'] );
		die;
	}else{
		$message = join("<br />", $city->errors );
	}
	
}

if( isset($_GET['action']) && $_GET['action'] == "add" ) { 
	if( isset($_POST['bt_add']) ){
		$city_name 	= $_POST['txt_city_name'];
		$city_code 	= $_POST['txt_city_code'];
		$active 	= $_POST['txt_is_active'];
		if ( !City::find_by_city_name( $city_name ) ) {
			$city = new City();
			$city->city_code	= $city_code;
			$city->city_name	= $city_name;
			$city->is_active	= $active;
			
			if( $city->save() ){
				$session->message("<div class='success'>City <span style='color:blue;'>". $city_name ."</span> added </div>");
				redirect_to( $_SERVER['PHP_SELF']."?action=".$_GET['action'] );
				die;
			}else{
				$message = join("<br />", $city->errors );
			}
		}else{
			$session->message( "<div class='error'>unable to add <span style='color:blue;'>". $city_name ."</span></div>" );
			redirect_to( $_SERVER['PHP_SELF']."?action=".$_GET['action'] );
			die;
		}
	}
}

	$delete_message = "Are you sure you wont to delete this City name";
	
	$order_by 	= safe_output( urlencode($_GET['order_by']) );
	$order 		= safe_output( urlencode($_GET['order']) );
	
	//$city = City::find_all_city($order_by, $order );


###############################################################################
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$per_page = 30;
		$total_count = sizeof(City::find_all_city($order_by, $order ) );
		
		$pagination = new Pagination( $page, $per_page, $total_count );
		
		$offset = $pagination->offset();
		
		$sql=" SELECT * FROM " .TBL_CITY;
		$order_city = " ORDER BY city_name ASC ";
		if( isset($order_by) && $order_by != "" ){
			 $order_city = " ORDER BY {$order_by} {$order}";
		}
		
		$sql .= $order_city;
		$sql.=" LIMIT {$per_page} ";
		$sql.=" OFFSET {$offset} ";

		$city = City::find_by_sql( $sql );


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
    <div class="page_header">Cities </div>
	<?php echo ( $message != "" ) ? output_message($message) : "	"; ?>
    <?php if( isset($_GET['action']) && $_GET['action'] == "add" ) {  
			if( isset($_GET['id']) ){
				$id = (int)$_GET['id'];
				$jt_name = City::find_by_id( $id );
				
				$city_name 	= $jt_name->city_name;
				$city_code 	= $jt_name->city_code;
				$active 	= $jt_name->is_active;
			}else{
				$city_name 	= "";
				$city_code 	= "";
				$active 	= "";
			}
	?>
       <form action="" method="post"> 
        <table>
            
            <tr>
              <td></td>
              <td><label class="label">City Code: </label></td>
              <td><input type="text" name="txt_city_code" size="20" /></td>
            </tr>
            
            <tr>
              <td></td>
              <td><label class="label">City Name: </label></td>
              <td><input type="text" name="txt_city_name" size="35" /></td>
            </tr>
            
            <tr>
              <td></td>
              <td><label class="label">Is Active: </label></td>
              <td>
                <select name="txt_is_active" >
                  <option value="Y">Yes</option>
                  <option value="N">No</option>
                </select>
              </td>
            </tr>
            
            <tr>
              <td></td>
              <td></td>
              <td>
              	<input type="submit" name="bt_add" value="Add City" class="button" />
                
              </td>
            </tr>
            
        </table>
       </form>
   
    <?php }else if( isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) ) { 
		$id = (int)$_GET['id'];
		$jt_name = City::find_by_id( $id );
		
		$city_name = $jt_name->city_name;
		$city_code = $jt_name->city_code;
		$active = $jt_name->is_active;
	?>
    <br /><br />
       <form action="" method="get">
       
       	<input type="hidden" name="action" value="<?php echo $_GET['action']; ?>" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <label class="label">City Name: </label>
        <input type="text" name="txt_name" value="<?php echo $city_name;?>" size="45" />
        
        <br /> <label class="label">City Code: </label>
        <input type="text" name="txt_code_name" value="<?php echo $city_code;?>" size="20" />
        
        <br /> 
        <label class="label">Active: </label>
        <select name="txt_active">
          <option <?php echo $active == "Y"? 'selected="selected"':""; ?> >Y</option>
          <option <?php echo $active == "N"? 'selected="selected"':""; ?> >N</option>
        </select>
        <br /> 
        
        <input type="submit" name="bt_update" value="Update" class="button" />
        
       </form>
       <br /><br />
    <?php } ?>
    
    <a href="?action=add">Add new City</a> | 
    <a href="auto_add_city.php">Auto Add Cities </a>
    
    <div>
    <?php 
        if( $pagination->total_pages() > 1 ){ ?>
        
        <br />
        <div style="float:left;">
    <?php
			if($pagination->has_previous_page()) { 
                echo "<a href=\"?".$query."&amp;page=";
                echo $pagination->previous_page();
                echo "\">&laquo; Previous</a> "; 
            }else{
				echo "&laquo; Previous";
			}
	?>
    	</div>
        <div style="float:right;">
      <?php
            if($pagination->has_next_page()) { 
                echo " <a href=\"?".$query."&amp;page=";
                echo $pagination->next_page();
                echo "\">Next &raquo;</a> "; 
            }else{echo "Next &raquo;";}
	?>
      </div>
      
       <div style="clear:both;">&nbsp;<br /></div>
    <?php
            for($i=1; $i <= $pagination->total_pages(); $i++) {
                if($i == $page) {
                    echo " <span class=\"selected\">{$i}</span> ";
                } else {
                    echo " <a href=\"?".$query."&amp;page={$i}\">{$i}</a> "; 
                }
            }
        }
        ?>
      </div>
      
	<table width="100%" cellpadding="5" cellspacing="1" class="tb_1">
    
      <tr class="shade_tb">
        <td>ID</td>
        <td><a href="?order_by=city_code&amp;order=<?php echo ($_GET['order'] == "ASC") ? "DESC" : "ASC";  ?>">City Code</a></td>
        <td><a href="?order_by=city_name&amp;order=<?php echo ($_GET['order'] == "ASC") ? "DESC" : "ASC";  ?>">City Name</a></td>
        <td><a href="?order_by=is_active&amp;order=<?php echo ($_GET['order'] == "ASC") ? "DESC" : "ASC";  ?>">Is Active</a></td>
        <td>Action</td>
      </tr>
     <?php foreach( $city as $v ): ?> 
      <tr>
        <td>#<?php echo $v->id; ?></td>
        <td><?php echo $v->city_code; ?></td>
        <td><a name="<?php echo $v->id; ?>" href="?action=edit&amp;id=<?php echo $v->id; ?>"><?php echo $v->city_name; ?></a></td>
        <td><?php echo $v->is_active; ?></td>
        <td>
          <a name="<?php echo $v->id; ?>" href="?action=edit&amp;id=<?php echo $v->id; ?>">
          <img src="images/edit.png" alt="Edit" /></a>
          <a href="?action=delete&amp;id=<?php echo $v->id; ?>" 
          	onclick="return delete_item('<?php echo $delete_message; ?>');">
          	<img src="images/delete.png" alt="Delete" />
          </a>
        </td>
      </tr>
     <?php endforeach; ?>  
    </table>
    
    
    
    </td>
  </tr>
</table>
<?php include_admin_layout_template ("page_footer.php"); ?>