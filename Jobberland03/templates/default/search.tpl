{$search_bx}

<a href="{$BASE_URL}save_search/?action=save&amp;name={$save_reference_name}&amp;reference={$save_reference}">Save Search</a>


{if is_array ($list_jobs) && $list_jobs != "" }
<table width="100%" border="0" id="search_tb" cellpadding="0" cellspacing="0">
<colgroup>
    <col width="11.8%" />
    <col width="51%" />
    <col width="8%" />
    <col width="12%" />
    <col />
</colgroup>

  <tr>
    <td colspan="5">
    <div class="result">
        <strong>{$total_count} {lang mkey='results_found'}</strong>
        <br />
        {lang mkey='you_are_viewing'} {$offset+1} {lang mkey='to'} {$offset+$per_page} 
        <br />
    </div>
    
    <div class="page_num">
     {if $total_pages > 1}
        { if $has_previous_page} 
            <a href="?{if $query != ''}{$query}&amp;{/if}page={$previous_page}">&laquo; {lang mkey='previous'}</a> 
        {else}
        	    &laquo; {lang mkey='previous'}
        {/if}
        {section name=page start=1 loop=$total_pages+1 step=1 }
            {if $smarty.section.page.index == $page }
                <span class="selected">{$smarty.section.page.index}</span>
            {else}
                <a href="?{if $query != ''}{$query}&amp;{/if}page={$smarty.section.page.index}">{$smarty.section.page.index}</a> 
            {/if}
        {/section}
        
        {if $has_next_page} 
            <a href="?{if $query != ''}{$query}&amp;{/if}page={$next_page}">{lang mkey='next'} &raquo;</a> 
        {else} {lang mkey='next'} &raquo;{/if}
    {/if}

     <br /><br />
    </div>
    
    </td>
  </tr>

  <tr class="search_header" style="color:#FFF;">
    <th class="left_black">&nbsp;&nbsp;{lang mkey='label' skey='date_posted'}</th>
    <th>{lang mkey='label' skey='job_details_pre'}</th>
    <th>{lang mkey='label' skey='job_type'}</th>
    <th>{lang mkey='label' skey='salary'}</th>
    <th class="right_black">{lang mkey='label' skey='location'}</th>
  </tr>

{foreach from=$list_jobs key=k item=i}

  <tr>
    <td><label title="{lang mkey='label' skey='created_at'} {$i.created_at}">{$i.created_at}</label>
    </td>
    <td><a href="{$BASE_URL}job/{$i.job_var_name}/">{$i.job_title}</a>
        <br /><br />
        {$i.job_description}
        
        &nbsp;&nbsp;&nbsp;
        <div class="more_bt">
        <a href="{$BASE_URL}job/{$i.job_var_name}/"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </a></div>
        
        <br /><br />
            {lang mkey='label' skey='advertise_by'}
            <a href="{$BASE_URL}company/{$i.company_var_name}/">{$i.company_name}</a>
        <br />
    </td>
    <td>{$i.type_name}</td>
    <td>{$i.salary}</td>
    <td><a href="{$BASE_URL}location/{$i.city_url}">{$i.location}</a>
         <br /><br />
          <a href="{$BASE_URL}save_job/?id={$i.id}&amp;action=save_job">{lang mkey='link' skey='save_job'}</a>
    </td>
  </tr>
  
  <tr class="divider">
    <td colspan="5">
      <div class="hr-dotted"><hr /></div>
    </td>
  </tr>

  {/foreach}
  

  <tr>
    <td colspan="5">
    <div class="result">&nbsp;</div>
    
    <div class="page_num">

     {if $total_pages > 1}
        { if $has_previous_page} 
            <a href="?{if $query != ''}{$query}&amp;{/if}page={$previous_page}">&laquo; {lang mkey='previous'}</a> 
        {else}
        	    &laquo; {lang mkey='previous'}
        {/if}
        {section name=page start=1 loop=$total_pages+1 step=1 }
            {if $smarty.section.page.index == $page }
                <span class="selected">{$smarty.section.page.index}</span>
            {else}
                <a href="?{if $query != ''}{$query}&amp;{/if}page={$smarty.section.page.index}">{$smarty.section.page.index}</a> 
            {/if}
        {/section}
        
        {if $has_next_page} 
            <a href="?{if $query != ''}{$query}&amp;{/if}page={$next_page}">{lang mkey='next'} &raquo;</a> 
        {else} {lang mkey='next'} &raquo;{/if}
    {/if}

	<p>&nbsp;</p>
    
    </div>
    </td>
  </tr>
  
</table>
{else}
<br />
<div class='error'>
<p>{lang mkey='errormsg' skey=01}</p>
    <ul>
        <li>{lang mkey='errormsg' skey=02}</li>
        <li>{lang mkey='errormsg' skey=03}.</li>
        <!-- <li>Expand your job location radius.</li> -->
        <li>{lang mkey='errormsg' skey=04}.</li>
    </ul>
</div>
<br />

{/if}