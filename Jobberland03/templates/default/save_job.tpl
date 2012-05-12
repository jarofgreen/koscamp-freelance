
{if $save_job && is_array($save_job) }
<div class="header">{lang mkey='header' skey='my_save_job'}</div>
<br />

{if $message != "" } {$message} {/if}

<br />
{foreach from=$save_job key=k item=i}

<div class="round">
	<div class="app_job_title"><a href='{$BASE_URL}{$i.job_url}'>{$i.job_title}</a></div>
    <div class='my_application_details'>
        <strong>{lang mkey='label' skey='app_post'}</strong>{$i.created_at}
        <br /><strong>{lang mkey='label' skey='date_saved'}</strong>{$i.date_saved}
        <br /><strong>{lang mkey='label' skey='app_cn'}</strong>{$i.contact_name}
        <br /><strong>{lang mkey='label' skey='app_ce'}</strong>{$i.poster_email}
        <br /><a href='?id={$i.id}&amp;job_id={$i.job_id}&amp;delete=true'>{lang mkey='button' skey='delete'}</a>
    </div>
</div>

<hr />
{/foreach}
{else}
	<div class='error'>{lang mkey='error' skey='no_save_job'}</div>
{/if}