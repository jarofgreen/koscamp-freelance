{if is_array ($location) && $location != "" }
	<div class="header">{lang mkey='header' skey='browse_by_1_sub'} {$location_name|strip_tags}</div>
    <ul class="browse">
    {foreach from=$location key=k item=i}
        <li><a href="{$BASE_URL}job/{$i.var_name}/">{$i.job_name|strip_tags}</a></li>
    {/foreach}
    </ul>
{else}
	<div class="error">{lang mkey='error' skey='browse_not_found_1'}</div>
{/if}