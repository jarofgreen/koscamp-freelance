{if $application && is_array($application) }

<div class="header">{lang mkey='header' skey='my_application'}</div>

{if $message != "" } <br />  {$message} <br /> {/if}

<div class="my_application_info">
	{lang mkey='app' skey='1'}
</div>

<br />

{foreach from=$application key=k item=i}

<div class="round">
	<div class="app_job_title"><a href='{$BASE_URL}{$i.job_url}'>{$i.job_title}</a></div>
    <div class='my_application_details'>
        <strong>{lang mkey='label' skey='app_post'} </strong>{$i.created_at}
        <br /><strong>{lang mkey='label' skey='app_app'} </strong>{$i.date_apply}
        <br /><strong>{lang mkey='label' skey='app_cv'} </strong>{$i.cv_name}
        <br /><strong>{lang mkey='label' skey='app_cl'}</strong>{$i.cover_letter}
        <br /><strong>{lang mkey='label' skey='app_cn'}</strong>{$i.contact_name}
        <br /><strong>{lang mkey='label' skey='app_ce'}</strong>{$i.poster_email}
        <br /><a href='?id={$i.id}&amp;job_id={$i.job_id}&amp;delete=true'>{lang mkey='button' skey='delete_app'}</a>
    </div>
</div>

<hr />
{/foreach}
{else}
	{if $message != "" } <br />  {$message} <br /> {/if}
    
    <div class='error'>{lang mkey='error' skey='no_app_found'}</div>
    
{/if}