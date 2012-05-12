<div class="header">Manage Employer </div>

{if $message != "" } {$message} {/if}

{if $manage_lists && is_array($manage_lists)}

<form action="" method="post" name="frm_manage_employers" id="frm_manage_employers" >
<p>
    Actions with Selected:<br>
    <input value="Deactivate" class="button" name="deactivate_all" type="submit">
    <input value="Delete" class="delete-button"  name="delete_all"
        onclick="if ( !confirm('Are you sure you want to delete this listing?') ) return false;" type="submit">
    <input value="Add Credits" class="button" name="credits_all" type="submit">
</p>

{if isset($smarty.post.reject_all) }
    <strong>Reject Reason: </strong><br /><textarea name="reject_reason"></textarea>
    <input type="submit" name="reject_reason_btn" value="Submit Reject" />
{/if}

{if isset($smarty.post.repost_btn) }
    Enter New date:
    <input type="text" name="txt_repost_date" value="" /> Leave it blank if posted from current time
    <br /><br />
{/if}

{if isset($smarty.post.credits_all)  }
    # Credits to add: <input type="text" name="txt_credits" value="" size="30" /><br />
    <input value="Add CV Credits" class="button" name="cv_credit_all" type="submit">
    <input value="Add Spotlight Credits" class="button" name="spotlight_credit_all" type="submit">
    <input value="Add Job Credits" class="button" name="job_credit_all" type="submit">
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
<td> &nbsp;&nbsp;Results: {$total_count} Employer(s) </td>
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
      <td class="tb_col_head">Username</td>
      <td class="tb_col_head">Email</td>
      <td class="tb_col_head">Total CV(s)</td>
      <td class="tb_col_head">Total Standard Job(s)</td>
      <td class="tb_col_head">Total Spotlight Job(s)</td>
      
      <td class="tb_col_head">Registration Date</td>
      <td class="tb_col_head">Last Login</td>
      <td class="tb_col_head">Status</td>
      <td class="tb_col_head">Action </td>
    </tr>
{foreach from=$manage_lists key=k item=i}
 
    <tr>
      <td class="tb_col_data">
        <input type="checkbox" name="employer_id[]" value="{$i.id}" 
            {if isset($employer_id) && is_array($employer_id)} 
            	{if in_array ($i.id, $employer_id)} checked="checked"{/if}
             {/if} />
       
      </td>
      <td class="tb_col_data">{$i.username}</td>
      <td class="tb_col_data">{$i.email_address}</td>
      <td class="tb_col_data">{$i.cv_qty}</td>
      <td class="tb_col_data">{$i.job_qty}</td>
      <td class="tb_col_data">{$i.spotlight_qty}</td>
      <td class="tb_col_data">{$i.date_register}</td>
      <td class="tb_col_data">{$i.last_login}</td>
      <td class="tb_col_data">{ if $i.is_active == "Y"} Active{else}Not Active{/if}</td>
      <td class="tb_col_data">
      
		<div id="menu_nav">
            <ul>
               <li><a href="#">Action</a>
                <ul id="user_nav">
                    {if $i.is_active == "Y" }
                        <li><a href="?id={$i.id}&amp;action=deactivate">Deactivate</a></li>
                    {else}
                        <li><a href="?id={$i.id}&amp;action=activate">Activate</a></li>
                    {/if}
                    <li><a href="edit_employer.php?id={$i.id}&amp;action=edit">Edit</a></li>
                    <li><a href="?id={$i.id}&amp;action=delete" onclick="if ( !confirm('Are you sure you want to delete this listing?') ) return false;">Delete</a></li>
                    <li><a href="new_job.php?employer_id={$i.id}&amp;username={$i.username}">Post new job</a></li>
                    <!--
                    <li><a href="employee_view.php?employer_id={$i.id}&amp;username={$i.username}">View Employer Profile</a></li>
                    -->
                </ul>
               </li>
             </ul>
		 </div>
               
      </td>
    </tr>
  {/foreach} 
  </table>	
 </form>   
{else}
    No Listing Found.
{/if}

