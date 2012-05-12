{if $application}

<div class="header">{lang mkey='header' skey='jobAppHis'}</div>

<div style="border:1px solid #CCC; clear:both; padding-left:3px;">

    {foreach from=$application key=k item=i}
      <div>
       <a href='{$BASE_URL}{$i.job_url}'>{$i.job_title}</a>
       <br />{lang mkey='label' skey='datePosted'}: {$i.created_at}
       <br />{lang mkey='label' skey='appliedOn'}: {$i.date_apply}
      </div>
      <br />
    {/foreach}

 <div class="button" style="width:180px; padding:3px;">
  <a href="{$BASE_URL}applications/">{lang mkey="label" skey='viewAllAppHis'}</a>
 </div>


</div>
{else}
  {*<div class='error'>{lang mkey='error' skey='no_app_found'}</div>*}
{/if}
