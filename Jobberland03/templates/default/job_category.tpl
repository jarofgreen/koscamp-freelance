{if is_array ($cat_by_job) && $cat_by_job != "" }    
	<div class="header"> {lang mkey='header' skey='browse_by_3_sub' } {$cat_name|strip_tags}</div>

{*
    <div class="result">
        {lang mkey='you_are_viewing'} {$offset+1} {lang mkey='to'} {$offset+$per_page} 
        <br /><br />
    </div>
*}

    <ul class="browse">
    {foreach from=$cat_by_job key=k item=i}
        <li><a href="{$BASE_URL}job/{$i.var_name}/">{$i.job_name|strip_tags}</a></li>
    {/foreach}
    </ul>

<br class='clear' />
<br class='clear' />
    
<center>
<div class="page_num">
 {if $total_pages > 1}
    { if $has_previous_page} 
        <a href="{$BASE_URL}category/{$cat_var_name}/{$previous_page}/">&laquo; {lang mkey='previous'}</a> 
    {else}
            &laquo; {lang mkey='previous'}
    {/if}
    {section name=page start=1 loop=$total_pages+1 step=1 }
        {if $smarty.section.page.index == $page }
            <span class="selected">{$smarty.section.page.index}</span>
        {else}
            <a href="{$BASE_URL}category/{$cat_var_name}/{$smarty.section.page.index}/">{$smarty.section.page.index}</a> 
        {/if}
    {/section}
    
    {if $has_next_page} 
        <a href="{$BASE_URL}category/{$cat_var_name}/{$next_page}/">{lang mkey='next'} &raquo;</a> 
    {else} {lang mkey='next'} &raquo;{/if}
{/if}

 <br /><br />
</div>
</center>
{*end of numbers*}

{else}
	not found
{/if}