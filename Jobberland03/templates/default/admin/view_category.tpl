<div class="page_header">Category</div>
{if $message != "" } {$message} {/if}

{if isset($action) && $action == "add" }    

<form action="" method="post"> 
<br /><br />
<a href="view_category.php">Go Back</a>
<div class="page_header">Add new category</div>
<table>
    <tr>
      <td></td>
      <td><label class="label">Category Name: </label></td>
      <td><input type="text" name="txt_cat" size="35" /> <input type="submit" name="bt_add" value="Add Category" class="button" />
      </td>
    </tr>
</table>
<br /><br />
</form>

{elseif isset($action) && $action == "edit" && isset($id) }

<br /><br />
<a href="view_category.php">Go Back</a>
<div class="page_header">Update category</div>
   <form action="" method="get">
    <input type="hidden" name="action" value="{$action}" />
    <input type="hidden" name="id" value="{$id}" />
    <label class="label">Category Name: </label>
    <input type="text" name="txt_cat_name" value="{$cat_name}" size="45" />
    <input type="submit" name="bt_update" value="Update Category" class="button" />
   </form>
   <br /><br />

{else}

<p><a href="?action=add">Add new Category</a></p>

<table width="100%" cellpadding="5" cellspacing="1" class="tb_1">

  <tr class="shade_tb">
    <td>ID</td>
    <td>Category Name</td>
    <td>Is Active</td>
    <td>Action</td>
  </tr>
{foreach from=$manage_lists key=k item=i}

  <tr>
    <td>#{$i.id}</td>
    <td>{$i.cat_name}</td>
    <td>Y</td>
    <td>
      <a name="{$i.id}" href="?action=edit&amp;id={$i.id}"><img src="{$skin_images_path}edit.png" alt="Edit" /></a>
      <a href="?action=delete&amp;id={$i.id}" onclick="if ( !confirm('Are you sure you wont to delete this category') ) return false;">
        <img src="{$skin_images_path}delete.png" alt="Delete" />
      </a>
    </td>
  </tr>
{/foreach}
</table>
{/if}