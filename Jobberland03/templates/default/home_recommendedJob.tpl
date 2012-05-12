{if $recommendedJobs && is_array($recommendedJobs) }
<div class="header">{lang mkey='header' skey='recommendedJob'}</div>
<div style="border:1px solid #CCC; padding-left:3px;">
   
    {foreach from=$recommendedJobs key=k item=i}
		<div class="clear_it">
        <a href="{$BASE_URL}job/{$i.var_name}/">{$i.job_title}</a> 
        <br />{$i.company_name}
        <br />{lang mkey="label" skey='posted'}: {$i.created_at}
        <br />{$i.location}
        </div>
        <br />
    {/foreach}
  
 <div class="button" style="width:180px; padding:3px;">
   <a href="{$BASE_URL}search_result/?q={$cvJob_title}&amp;location={$cvJob_city}">{lang mkey='label' skey='viewAllReJob'}</a>
 </div>
</div>   

{else}
   
{/if}
 
