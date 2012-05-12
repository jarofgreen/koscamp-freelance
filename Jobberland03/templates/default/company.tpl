
{if is_array ($company) && $company != "" }
<div class="header">{lang mkey='header' skey='browse_by_2'}</div>

    <ul class="browse">    
        {foreach from=$company key=k item=i}
            <li> <a href="{$BASE_URL}company/{$i.var_name}/">{$i.name|strip_tags} ( {$i.total} )</a></li>
        {/foreach}
    </ul>
{else}
	not found	
{/if}