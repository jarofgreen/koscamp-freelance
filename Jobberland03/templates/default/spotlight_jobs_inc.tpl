{if is_array ($spotlight) && $spotlight != "" }
    <div id="spotlight_jobs" >
      <p style="padding-top:5px;padding-bottom:5px;">{lang mkey='spotlight_job'}</p>  
    {foreach from=$spotlight key=k item=i}
       { if $i.job_title != '' }
        <div class='spotlight' style="width:{$size}%;">
            <a href="{$BASE_URL}job/{$i.var_name}/">{$i.job_title}</a>    
            <br />{$i.job_description}
            <br /><strong>{lang mkey='label' skey='location'}</strong>{$i.location}
            <br /><strong>{lang mkey='label' skey='posted_on'} </strong>{$i.created_at}
        </div>
        {/if}
        {if $i.new_line == 1 }<div class='clearit'>&nbsp;</div><br />{/if}
    {/foreach}
     <div class="clearit" />&nbsp;</div>
    </div>
{/if}