{if $message != "" } <br />{$message}<br /> {/if}

{if is_array ($list_cv) && $list_cv != "" }
  <div class="header">{lang mkey='header' skey='CVSearchResults'}</div>
    <br /><br />
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <colgroup>
            <col />
            <col width="20%" />
            <col width="80%" />
            <col />
        </colgroup>
     <tr class="searchcv_nav">
        <td class="TableSRNav-L">&nbsp;</td>
        <td> &nbsp;&nbsp;{lang mkey='label' skey='Results'}: {$total_count} {lang mkey='CV'} </td>
        <td>
            <div class="sc_nav_">
            {* nav menu here *}
            </div>
        </td>
        <td class="TableSRNav-R">&nbsp;</td>
     </tr>
    </table>
    <br />

  <table width="100%" cellpadding="0" cellspacing="0" >
    <tr class="cv_search_tr">
     <td class="TableSC-L">&nbsp;</td>
     <td>{lang mkey='label' skey='name'}: </td>
     <td>{lang mkey='label' skey='CVTitle'}: </td>
     <td>{lang mkey='label' skey='job_title'}: </td>
     <td>{lang mkey='label' skey='JobStatus'}: </td>
     <td>{lang mkey='label' skey='RJobTitle'}: </td>
     <td>{lang mkey='label' skey='city'}: </td>
     <td>{lang mkey='label' skey='LastUpdated'}: </td>
     <td class="TableSC-R">&nbsp;</td>
    </tr>
    
{foreach from=$list_cv key=k item=i}

    <tr>
     <td colspan="2">{$i.employee_name}</td>
     <td><a href="{$BASE_URL}employer/review_cv/?id={$i.id}&amp;u={$i.employee_id}">{$i.cv_title}</a></td>
     <td>
        {$i.look_job_title}
        <br />{$i.look_job_title2}
     </td>
     <td>{$i.look_job_status} </td>
     <td>{$i.recent_job_title} </td>
     <td>{$i.city}</td>
     <td colspan="2">{$i.modified_at}</td>
    </tr>
{/foreach}

  </table>
  
  <br />
  
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <colgroup>
            <col />
            <col width="20%" />
            <col width="80%" />
            <col />
        </colgroup>
     <tr class="searchcv_nav">
        <td class="TableSRNav-L">&nbsp;</td>
        <td> &nbsp;&nbsp;{lang mkey='label' skey='Results'}: {$total_count} {lang mkey='CV'} </td>
        <td>
            <div class="sc_nav_">
            {* nav menu here 
            *}
            </div>
        </td>
        <td class="TableSRNav-R">&nbsp;</td>
     </tr>
    </table>
  
{else}
    <div class="error">{lang mkey='error' skey='cvSearchNoResult'}</div>
{/if}
    
  <a href="{$BASE_URL}employer/search/">{lang mkey='e_link' skey='backSearchP'}</a>  