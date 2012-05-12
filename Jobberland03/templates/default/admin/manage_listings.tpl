<div class="header">Manage Listings</div>

{if $message != "" } {$message} {/if}

{if is_array ($manage_lists) && $manage_lists != "" }
<form action="" method="post" name="frm_manage_jobs" id="frm_manage_jobs" >
<p>
    Actions with Selected:<br>
    <input value="Activate" class="button" name="activate_all" type="submit">
    <input value="Deactivate" class="button" name="deactivate_all" type="submit">
    <input value="Delete" class="delete-button"  name="delete_all"
        onclick="if ( !confirm('Are you sure you want to delete this listing?') ) return false;" type="submit">
    <input value="Approve" class="button" name="approve_all" type="submit">
    <input value="Reject" class="button" name="reject_all" type="submit">
    <input id="repost_btn" name="repost_btn" value="Repost job" class="button" type="submit">
    <input id="act_spotlight_all" name="act_spotlight_all" value="Set Job to Spotlight" class="button" type="submit">
    <input id="dea_spotlight_all" name="dea_spotlight_all" value="Set job to Standard" class="button" type="submit">
</p>

{if isset($smarty.post.reject_all) }
    <strong>Reject Reason: </strong><br /><textarea name="reject_reason"></textarea>
    <input type="submit" name="reject_reason_btn" value="Submit Reject" />
{/if}

{ if  isset($smarty.post.repost_btn) }
    Enter New date:
    <input type="text" name="txt_repost_date" value="" /> Leave it blank if posted from current time
    <br /><br />
{/if}


<table border="0" cellpadding="0" cellspacing="0" width="100%">
<colgroup>
    <col />
    <col width="20%" />
    <col width="80%" />
    <col />
</colgroup>
<tr class="searchcv_nav">
<td class="TableSRNav-L">&nbsp;</td>
<td> &nbsp;&nbsp;Results: {$total_count} Job(s) </td>
<td>
    <div class="nav">
     {if $total_pages > 1}
        { if $has_previous_page} 
            <a href="?{if $query != ''}{$query}&amp;{/if}page={$previous_page}">&laquo; Previous</a> 
        {else}
        	    &laquo; Previous
        {/if}
		
        {section name=page start=1 loop=$total_pages+1 step=1 }
            {if $smarty.section.page.index == $page }
                <span class="selected">{$smarty.section.page.index}</span>
            {else}
                <a href="?{if $query != ''}{$query}&amp;{/if}page={$smarty.section.page.index}">{$smarty.section.page.index}</a> 
            {/if}
        {/section}

        
        {if $has_next_page} 
            <a href="?{if $query != ''}{$query}&amp;{/if}page={$next_page}">Next &raquo;</a> 
        {else} Next &raquo;{/if}
    {/if}
    </div>
</td>
<td class="TableSRNav-R">&nbsp;</td>
</tr>
</table>

<br />
  <table width="100%" cellpadding="5" cellspacing="1" class="tb_table">
    <tr>
      <td class="tb_col_head"><input type="checkbox" name="all_chk" onclick="checkUncheckAll(this);"  /></td>
      <td class="tb_col_head">ID</td>
      <td class="tb_col_head">Job Title</td>
      <td class="tb_col_head">Listing Type</td>
      <td class="tb_col_head">Created On</td>
      <td class="tb_col_head">User</td>
      <td class="tb_col_head">Views </td>
      <td class="tb_col_head">App</td>
      <td class="tb_col_head">Status</td>
      <td class="tb_col_head">Approval Status </td>
      <td class="tb_col_head">Action </td>
    </tr>
{foreach from=$manage_lists key=k item=i}
    <tr>
      <td class="tb_col_data">
        <input type="checkbox" name="job_id[]" value="{$i.id}" 
            {if isset($job_id) && is_array($job_id)} 
            	{if in_array ($i.id, $job_id)} checked="checked"{/if}
             {/if} />
      </td>
      <td class="tb_col_data">{$i.id}</td>
      <td class="tb_col_data">{$i.job_title}</td>
      <td class="tb_col_data">{$i.spotlight}</td>
      <td class="tb_col_data">{$i.created_at}</td>
      <td class="tb_col_data">{$i.employer_name}</td>
      <td class="tb_col_data">{$i.views_count}</td>
      <td class="tb_col_data">{$i.apply_count}</td>
      <td class="tb_col_data">{$i.is_active}</td>
      <td class="tb_col_data">{$i.job_status}</td>
      <td class="tb_col_data">

{if $i.is_active == "Active"}
	<a href="?id={$i.id}&amp;action=deactivate">Deactivate</a>
{else}
	<a href="?id={$i.id}&amp;action=activate">Activate</a>
{/if}
    <br />
    <a href="edit_job.php?id={$i.id}&amp;employer_id={$i.employer_id}">Edit</a>
    <br />
    <a href="?id={$i.id}&amp;action=delete" 
        onclick="if ( !confirm('Are you sure you want to delete this listing?') ) return false;">Delete</a>
      </td>
    </tr>
{/foreach}

  </table>	
 </form>   

{else}
    No Listing Found.
{/if}