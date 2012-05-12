{if $message != "" } {$message} {/if}

{if !$jobs}
	<div class="error"> {lang mkey='error' skey='job_not_found' }</div>
	
{else}

<div id="job_details">

<div id="job">
	<fieldset class="round ref_code">
      <div style="min-height:10px; padding:5px;">
        <div style="float:left;"><label><strong>{lang mkey='label' skey='ref_code'} </strong></label> {$job_ref|strip_tags}</div>
        <div style="float:right;">
          <input name="bt_apply_online" type="button" id="bt_cmd" value=" {lang mkey='button' skey='apply'} "  class="button" 
                  onclick="javascript:window.location = '{$BASE_URL}apply/{$var_name}';" />
        </div>
        <br />
      </div>
    </fieldset>
    
    <div class="clear">&nbsp;</div>
    <div>
        
        <div id="job_title">{$job_title|strip_tags}</div>
        <div class="application app">
            {if $apply_count == 0 }0{else} {$apply_count} {/if}
                <p>{lang mkey='label' skey='applicants' }</p>
        </div>
        <div class="views_count app">{$views_count}
            <p>{lang mkey='label' skey='views'}</p>
        </div>
    </div>

    <div class="clear">&nbsp;</div>

    <div style="float:right;">
       <img src="{$BASE_URL}images/company_logo/{$company_logo}" alt="" class="companylogo" />
    </div>
    <div>{$job_description}</div>

    <div class="clear">&nbsp;</div>

<div class="sub_header">{lang mkey='header' skey='additional_info'}</div>

<div class="border_around">
<table width="100%" >
    <tr>
        <td><strong>{lang mkey='label' skey='location'}</strong></td>
        <td>
        	<a href="{$BASE_URL}location/{$country_url}">{$country}</a> |
            <a href="{$BASE_URL}location/{$state_url}">{$state}</a> |
            <a href="{$BASE_URL}location/{$county_url}">{$county}</a> |
            <a href="{$BASE_URL}location/{$city_url}">{$city}</a>
        </td>
        <td><strong>{lang mkey='label' skey='start_date'}</strong> </td>
        <td>{$start_date}</td>
    </tr>

    <tr>
        <td><strong>{lang mkey='label' skey='job_type'}</strong></td>
        <td> 
        {foreach from=$jobtype item=i key=k}
            <a href="{$BASE_URL}search_result/?job_type={$i.var_name}">{$i.name}</a><br />
        {/foreach}
        </td>
        <td><strong>{lang mkey='label' skey='salary'} </strong></td>
        <td>{$job_salary}</td>
    </tr>

    <tr>
        <td><strong>{lang mkey='label' skey='career_level'} </strong></td>
        <td>
        	{if $careers != '' }
        	  <a href="{$BASE_URL}search_result/?career={$career_var_name}">{$career}</a>
        	{else}
            	{$career}
            {/if}
        </td>
        <td><strong>{lang mkey='label' skey='work_experience'} </strong></td>
        <td>
        	{if $experiences != '' }
            	<a href="{$BASE_URL}search_result/?experience={$experience_var_name}">{$experience}</a>
            {else}
            	{$experience}
            {/if}
         </td>
    </tr>

    <tr>
        <td><strong>{lang mkey='label' skey='education_level'} </strong></td>
        <td>
          {if $educations != '' }
            <a href="{$BASE_URL}search_result/?education={$education_var_name}">{$education}</a>
          {else}
            {$education}
          {/if}
        </td>
        <td><strong>{lang mkey='label' skey='created_at'}</strong></td>
        <td>{$created_at}</td>
    </tr>

</table>
</div>

<br /><br />

<div class="sub_header">{lang mkey='header' skey='contact_information'}</div>
<div class="border_around">
<table width="100%">
    <tr>
        <td><strong>{lang mkey='label' skey='company_name'}</strong></td>
        <td><a href="{$BASE_URL}company/{$employer_var_name}/">{$company_name}</a></td>
        <td><strong>{lang mkey='label' skey='company_tel_no'}</strong></td>
        <td>{$contact_telephone}</td>
    </tr>
    
    <tr>
        <td><strong>{lang mkey='label' skey='company_contact_name'}</strong></td>
        <td>{$contact_name}</td>
        <td><strong>{lang mkey='label' skey='company_site_link'}</strong></td>
        <td>{$site_link}</td>
    </tr>

    <tr>
        <td colspan="4" class="bottom_additional">&nbsp;</td>
    </tr>

</table>
</div>
</div>
</div>

<br />

<div>
<input name="bt_share" type="button" id="bt_cmd" value=" {lang mkey='button' skey='share_with_friends'} "  class="button" onclick="redirect_to( '{$BASE_URL}share/{$var_name}');" /> &nbsp; &nbsp; &nbsp; &nbsp;

<input name="bt_apply_online" type="button" id="bt_cmd" value=" {lang mkey='button' skey='apply_online'}"  class="button" onclick="redirect_to( '{$BASE_URL}apply/{$var_name}');" /> &nbsp; &nbsp; &nbsp; &nbsp;

<input name="bt_print" type="button" id="bt_cmd" value=" {lang mkey='button' skey='print_this_job'} "  class="button" onclick="print_job('job_details');" />

</div>
 <br />
 
{/if}
