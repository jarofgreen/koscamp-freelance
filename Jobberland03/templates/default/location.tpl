<div class="header">{lang mkey='header' skey='browse_by_1'}</div>

{if is_array ($activeLink) && $activeLink != "" }
<div class="job_location" id="job_location">
  <ul>
{foreach from=$activeLink key=k item=i}
    <li><a href="{$BASE_URL}location/{$i.url}{$i.var_name}/">{$i.name|strip_tags}</a></li>
{/foreach}
  </ul>
 <div class="clearit" />&nbsp;</div>
</div>
{/if}


{if is_array ($location) && $location != "" }

<div class="clearit" >
    <ul class="browse" >    
        {foreach from=$location key=k item=i}
            <li> <a href="{$BASE_URL}location/{$i.url}{$i.var_name}/">{$i.name|strip_tags} ( {$i.total} )</a></li>
        {/foreach}
    </ul>
</div>

{else}
  {if  $activeLink == ""  && $location == "" }
	<div class="error">{lang mkey='error' skey='browse_not_found_1'}</div>
  {/if}
{/if}