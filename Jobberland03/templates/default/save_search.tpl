
{if $save_search && is_array($save_search) }
<div class="header">{lang mkey='header' skey='save_search'}</div>
<br />

{if $message != "" } {$message} {/if}

<br />
{foreach from=$save_search key=k item=i}

<div class="round">
	<div class="app_job_title"><a href='{$BASE_URL}{$i.job_url}'>{$i.job_title}</a></div>
    <div class='my_application_details'>
        <strong>{lang mkey='label' skey='saved_search_ref'}</strong> 
        {*<a href="?action=search&amp;search_id={$i.id}">*}
        <a href="{$BASE_URL}search_result/?{$i.reference}">
        {$i.reference_name}</a>
        <br /><strong>{lang mkey='label' skey='date_saved'}</strong> {$i.created_at}
    </div>
    <a href="?action=delete&amp;search_id={$i.id}">Delete</a>
</div>
<hr />

{/foreach}

{else}
	<div class='error'>{lang mkey='error' skey='no_save_search'}</div>
{/if}