{literal} 
<script language="javascript" type="text/javascript">
  tinyMCE.init({
    theme : "advanced",
    mode: "exact",
    elements : "txt_job_desc",
	skin : "o2k7",
    theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
    theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,"
							   +"justifyfull,fontselect,fontsizeselect,forecolor,backcolor",
	
	theme_advanced_buttons2 : "bullist, numlist, outdent, indent, |, cut,copy,paste,pastetext,"
							+ "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
	
	theme_advanced_buttons3 : "",
	
    height:"350px",
    width:"550px",
    file_browser_callback : 'myFileBrowser'
  });

</script>
{/literal} 

{if $message != "" } {$message} {/if}

<form action="" method="post" id="job_form" name="job_form">
<p>
	{$credit_remaining}
</p>
<div class="header">{lang mkey='header' skey='contact_information'}</div>
<table width="100%" border="0" id="company_table" cellpadding="2" cellspacing="2" >
    <colgroup>
      <col />
      <col class="job_col" />
      <col class="job_co2" />
    </colgroup>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">{lang mkey='label' skey='company_contact_name'}: </span></td>
    <td><input name="txt_contact_name" type="text" class="text_field required" id="txt_contact_name" size="35" value="{$smarty.session.add_job.cname}" />
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="label">{lang mkey='label' skey='ContactTelNo'}: </span></td>
    <td>
     <input name="txt_telephone"  type="text" class="text_field" id="txt_telephone" size="15" maxlength="13" value="{$smarty.session.add_job.tn}" />
    </td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">{lang mkey='label' skey='email_address'}: </span></td>
    <td>
        <input name="txt_email"  type="text" class="text_field required" id="txt_email" size="35" value="{$smarty.session.add_job.email}" />
          <br /><i>{lang mkey='info' skey='jobemail'}</i>
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><span class="label">{lang mkey='label' skey='company_site_link'}:</span> </td>
    <td>
      http://<input name="txt_site_link" type="text" class="text_field" id="txt_site_link" size="50" value="{$smarty.session.add_job.sl}" />
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  </table>

<div class="header">{lang mkey='header' skey='JobInfo'}</div>
<table width="100%" border="0" id="job_table" cellpadding="2" cellspacing="2" >
    <colgroup>
      <col />
      <col class="job_col" />
      <col class="job_co2" />
    </colgroup>
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">{lang mkey='label' skey='ref_code'}: </span></td>
    <td>
      <input name="txt_ref_code" type="text" class="text_field" id="txt_ref_code" size="40" value="{$smarty.session.add_job.job_ref}" />
    </td>
  </tr>

  <tr valign="top">
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">{lang mkey='label' skey='job_title'}:</span></td>
    <td>
      <input name="txt_job_title" type="text" class="text_field required" id="txt_job_title" size="40" maxlength="100" value="{$smarty.session.add_job.job_title}" />
         <br />{lang mkey='info' skey='job_titlehelp'}
   </td>
  </tr>
  
  <tr valign="top">
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">{lang mkey='label' skey='job_desc'}:</span></td>
    <td>
      <textarea name="txt_job_desc" id="txt_job_desc" cols="5" rows="20" class="text_field required" >{$smarty.session.add_job.job_desc}</textarea>
       <br />{lang mkey='info' skey='job_desc_cha_all'} 
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">{lang mkey='label' skey='position'}:</span></td>
    <td>
      <input name="txt_position" type="text" class="text_field" id="txt_position"  size="40" value="{$smarty.session.add_job.job_postion}" />
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">{lang mkey='label' skey='start_date'}:</span></td>
    <td>
      <input name="txt_start_date" type="text" class="text_field" id="txt_start_date" maxlength="50" size="40" value="{$smarty.session.add_job.jsd}" />
          <br /><i> {lang mkey='info' skey='job_str_info'}  </i>
    </td>
  </tr>
  
  <tr valign="top">
    <td colspan="3">
    
     <div class="label1">
        <table width="100%">
          <tr valign="top">
            <td><div class="job_col">
                <img src="{$skin_images_path}required.gif" alt="" />
                <span class="label job">{lang mkey='label' skey='job_type'}:</span></div></td>
            <td>
                {foreach from=$job_type key=k item=v}
                    <input type="checkbox" value="{$k}" 
                    	{foreach from=$type_selected key=kk item=vv}
                      	  {if $k eq $vv } checked="checked" {/if}
                    	{/foreach}
                     onclick="return check_max_checkbox('txt_job_type[]', 1 );" name="txt_job_type[]" /> {$v}
                    <br />
                {/foreach}

                {*html_checkboxes name='txt_job_type' options=$job_type checked=$type_selected separator='<br />'*}
            </td>
            <td><img src="{$skin_images_path}required.gif" alt="" /><span class="label job">{lang mkey='label' skey='JobStatus'}:</span></td>
            <td>
                {foreach from=$job_status key=k item=v}
                    <input type="checkbox" value="{$k}"  
                        {foreach from=$status_selected key=kk item=vv}
                      	  {if $k eq $vv } checked="checked" {/if}
                    	{/foreach}
                    onclick="return check_max_checkbox('txt_job_status[]', 1 ); " name="txt_job_status[]" /> {$v}
                    <br />
                {/foreach}

            
            {*html_checkboxes name='txt_job_status' options=$job_status selected=$status_selected separator='<br />'*}
         </td>
          </tr>
        </table>
    </div>
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">{lang mkey='label' skey='SalaryRange'}:</span></td>
    <td>
      <input name="txt_salary" type="text" class="text_field" id="txt_salary" size="25" value="{$smarty.session.add_job.salary}" />
      <select name="txt_salaryfreq" class="text_field">
        <option value=""></option>
        {html_options options=$salaryfreq selected=$smarty.session.add_job.freq}
      </select>
    <br />
    <i>{lang mkey='info' skey='salary_help'} </i>
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">{lang mkey='label' skey='education'}:</span></td>
    <td>
       <div class="small_box box">	
        {*html_checkboxes name='txt_education' options=$education checked=$education_selected separator='<br />'*}
        
        	{foreach from=$education key=k item=v}
            	<div class='new_job' >
                <input type="checkbox" value="{$k}"  
                    {foreach from=$education_selected key=kk item=vv}
                      {if $k eq $vv } checked="checked" {/if}
                    {/foreach}
                onclick="return check_max_checkbox('txt_education[]', 1 ); " name="txt_education[]" /> {$v}
                </div>
        	{/foreach}
        </div>   
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">{lang mkey='label' skey='career_level'}:</span></td>
    <td>
        <div class="small_box box">	
            {*html_checkboxes name='txt_career' options=$career selected=$career_selected separator='<br />'*}
         	{foreach from=$career key=k item=v}
            	<div class='new_job' >
                <input type="checkbox" value="{$k}"  
                    {foreach from=$career_selected key=kk item=vv}
                      {if $k eq $vv } checked="checked" {/if}
                    {/foreach}
                onclick="return check_max_checkbox('txt_career[]', 1 ); " name="txt_career[]" /> {$v}
                </div>
        	{/foreach}

        </div>
    
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">{lang mkey='label' skey='YearOfExperience'}: </span></td>
    <td>
      <div class="small_box box">	
        {*html_checkboxes name='txt_experience' options=$experience selected=$experience_selected separator='<br />'*}
         	{foreach from=$experience key=k item=v}
            	<div class='new_job' >
                <input type="checkbox" value="{$k}" 
                    {foreach from=$experience_selected key=kk item=vv}
                      {if $k eq $vv } checked="checked" {/if}
                    {/foreach}
                onclick="return check_max_checkbox('txt_experience[]', 1 ); " name="txt_experience[]" /> {$v}
                </div>
        	{/foreach}

      </div>
    </td>
  </tr>
  
  <tr valign="top">
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">{lang mkey='label' skey='job_location'}: </span></td>
    <td>
      <table width="100%">
        <tr>
          <td>{lang mkey='label' skey='country'}:</td>
          <td>
            <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
              {html_options options=$country selected=$smarty.session.loc.country}
            </select>
          </td>
        </tr>
        
        <tr>
          <td><label>{lang mkey='label' skey='state'}: </label></td>
          <td><div id="stateprovince_auto">
                {if $lang.states|@count > 0}
                    <select class="select" name="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
                    {html_options options=$lang.states selected=$smarty.session.loc.stateprovince}
                    </select>
                { else }
                    <input class="text_field required" name="txtstateprovince" type="text" size="30" maxlength="100" value="{$smarty.session.loc.stateprovince}" />
               { /if}                
            </div>
           </td>
        </tr>
        
        <tr>
          <td><label>{lang mkey='label' skey='county'} : </label></td>
          <td>
              <div id="county_auto">
              { if $lang.counties|@count > 0}
                <select class="select" name="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
                {html_options options=$lang.counties selected=$smarty.session.loc.countycode}
                </select>
              { else }
                <input name="txtcounty" type="text" size="30" maxlength="100" value="{$smarty.session.loc.countycode}" />
              { /if}            
            </div>
          </td>
        </tr>
        
        <tr>
          <td><label>{lang mkey='label' skey='city'}: </label></td>
          <td>
             <div id="city_auto">
              { if $lang.cities|@count > 0}
                <select class="select" name="txtcity" >
                  {html_options options=$lang.cities selected=$smarty.session.loc.citycode}
                </select>
              { else }
                <input name="txtcity" type="text" size="30" maxlength="100" value="{$smarty.session.loc.citycode}" />
              { /if}
        
            </div>
           </td>
        </tr>
        
        <tr>
          <td></td>
          <td></td>
        </tr>
        
      </table>
    </td>
  </tr>
  
  <tr valign="top">
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td valign="top"><span class="label">{lang mkey='label' skey='SelectCategories'}:</span></td>
    <td>
        <div class="large_box box">	
    		{*html_checkboxes class='add_job' name='txt_category' options=$category selected=$category_selected separator='<br />'*}
    	
         	{foreach from=$category key=k item=v}
            	<div class='new_job' >
                <input type="checkbox" value="{$k}"  
                    {foreach from=$category_selected key=kk item=vv}
                      {if $k eq $vv } checked="checked" {/if}
                    {/foreach}
                onclick="return check_max_checkbox('txt_category[]', 10 ); " name="txt_category[]" />
                <a onclick="return check_box('{$k}', 'txt_category[]', 10 );">{$v|strip_tags}</a>
                </div>
        	{/foreach}

        </div>
                
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>
  <input name="bt_add" id="bt_add" type="submit"  value="{lang mkey='button' skey='PostJob'}" class="button" />
  <input name="bt_reset" type="reset"  value=" {lang mkey='button' skey='Reset'} "  class="button" />

</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
</form>

{literal} 
<script language="javascript" type="text/javascript">
	check_max_checkbox('txt_job_type[]',1);
	check_max_checkbox('txt_job_status[]',1);
	check_max_checkbox('txt_education[]',1);
	check_max_checkbox('txt_career[]',1);
	check_max_checkbox('txt_experience[]',1);
	check_max_checkbox('txt_city[]',1);
	check_max_checkbox('txt_category[]', 10 );
</script>
{/literal} 
