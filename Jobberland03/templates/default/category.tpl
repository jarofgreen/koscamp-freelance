
{if is_array ($cat) && $cat != "" }
<div class="header">{lang mkey='header' skey='browse_by_3' }</div>

    <ul class="browse">    
        {foreach from=$cat key=k item=i}
            <li> <a href="{$BASE_URL}category/{$i.var_name}/">{$i.cat_name|strip_tags} ( {$i.total} )</a></li>
        {/foreach}
    </ul>
{else}
		not found
{/if}