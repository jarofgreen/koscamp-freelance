{if $message != "" } {$message} {/if}

{if isset($action) && $action == "add" }    

<div class="header">Add new Job Types </div>
<a href="view_job_type.php">Go Back</a>

<form action="" method="post"> 
<table>
<tr>
  <td></td>
  <td><label class="label">Type Name: </label></td>
  <td><input type="text" name="txt_type_name" size="35" /></td>
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
  <td><input type="submit" name="bt_add" value="Add Job Type" class="button" /></td>
</tr>    
</table>
</form>

{elseif isset($action) && $action == "edit" && isset($id) }
<br /><br />

<div class="header">Update Job Types </div>
<a href="view_job_type.php">Go Back</a>

<form action="" method="get">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="id" value="{$id}" />
<label class="label">Job Type Name: </label>
<input type="text" name="txt_name" value="{$jt_name2}" size="45" />
<select name="txt_active">
  <option { if $is_active == "Y" } selected="selected" {/if} >Y</option>
  <option { if $is_active == "N" } selected="selected" {/if} >N</option>
</select>
<input type="submit" name="bt_update" value="Update" class="button" />
</form>
<br /><br />

{else}
<div class="header">List of Job Types </div>

<a href="?action=add">Add new Job Types</a>

<table width="100%" cellpadding="5" cellspacing="1" class="tb_1">

  <tr class="shade_tb">
    <td>ID</td>
    <td>Job Type Name</td>
    <td>Is Active</td>
    <td>Action</td>
  </tr>

{foreach from=$manage_lists key=k item=i}

  <tr>
    <td>#{$i.id}</td>
    <td>{$i.type_name}</td>
    <td>{$i.is_active}</td>
    <td>
      <a name="{$i.id}" href="?action=edit&amp;id={$i.id}">
        <img src="{$skin_images_path}edit.png" alt="Edit" /></a>
      <a href="?action=delete&amp;id={$i.id}"  onclick="if ( !confirm('Are you sure you wont to delete this Job Type') ) return false;" >
        <img src="{$skin_images_path}delete.png" alt="Delete" />
      </a>
    </td>
  </tr>
 {/foreach}  
</table>
{/if}