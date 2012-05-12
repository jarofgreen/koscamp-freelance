{$search_bx}

{if HOME_DISPLAY == 'topten'}
<div style="font-size:16px; font-weight:bold;">Latest top jobs</div>
<p>These are the latest top dates, which few jobs listed on these days. Click on links to see the latest job ads.</p>

{foreach from=$gorup_jobs_by_dates key=k item=jobs}

<span id="display_date">{$k}</span>

	{foreach from=$jobs key=kk item=i}
	  
      <div id="group_by_dates" class="group_by_dates_light">
        <div>
        	<a href="{$BASE_URL}job/{$i.var_name}">{$i.job_title}@{$i.company_name} ({$i.location}) </a>
        </div>
        <div id="job_description">
        	{$i.job_description}
            <span id="more_link" >
      	      <a href="{$BASE_URL}job/{$i.var_name}">more...</a>
            </span>
        </div>    
   </div>    
    {/foreach}
{/foreach}

<p>&nbsp;</p>

{else}

<div class="job_seeker_info">
    <label>{lang mkey='home' skey='header1'}</label>
    <div>
         {lang mkey='home' skey='info1'}
    </div>
    
    <div>
        <a href="{$BASE_URL}employer/services" class="link">{lang mkey='link' skey='read_more'}</a>
    </div>
    
</div>

<div class="job_seeker_info">
    <label>{lang mkey='home' skey='header2'}</label>
    <div>
         {lang mkey='home' skey='info2'}
    </div>
    
     <div>
        <a href="{$BASE_URL}employer/services" class="link">{lang mkey='link' skey='read_more'}</a>
    </div>
    
</div>

<div class="clear">&nbsp;</div>

<div class="employee_info">
    <label>{lang mkey='home' skey='header3'}</label>
    <div>
         {lang mkey='home' skey='info3'}
    </div>
    
    <div>
        <a href="{$BASE_URL}login/" class="link">{lang mkey='link' skey='read_more'}</a>
    </div>
    
</div>

<div class="employee_info">
    <label>{lang mkey='home' skey='header4'}</label>
    <div>
         {lang mkey='home' skey='info4'}
    </div>
    
    <div>
        <a href="{$BASE_URL}login/" class="link">{lang mkey='link' skey='read_more'}</a>
    </div>
    
</div>
<div class="clear">&nbsp;</div>

{/if}