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

<div class="header">Contact Information</div>
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
    <td><span class="label">Contact Name: </span></td>
    <td><input name="txt_contact_name" type="text" class="text_field required" id="txt_contact_name" size="35" value="{$smarty.session.add_job.cname}" />
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="label">Contact Telephone No: </span></td>
    <td>
     <input name="txt_telephone"  type="text" class="text_field" id="txt_telephone" size="15" maxlength="13" value="{$smarty.session.add_job.tn}" />
    </td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">Email Address: </span></td>
    <td>
        <input name="txt_email"  type="text" class="text_field required" id="txt_email" size="35" value="{$smarty.session.add_job.email}" />
          <br /><i>Email will not be shown, it is used to send Application </i>
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><span class="label">Site Link:</span> </td>
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

<div class="header">Job Information</div>
<table width="100%" border="0" id="job_table" cellpadding="2" cellspacing="2" >
    <colgroup>
      <col />
      <col class="job_col" />
      <col class="job_co2" />
    </colgroup>
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">Reference code: </span></td>
    <td>
      <input name="txt_ref_code" type="text" class="text_field" id="txt_ref_code" size="40" value="{$smarty.session.add_job.job_ref}" />
    </td>
  </tr>

  <tr valign="top">
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">Job Title:</span></td>
    <td>
      <input name="txt_job_title" type="text" class="text_field required" id="txt_job_title" size="40" maxlength="100" value="{$smarty.session.add_job.job_title}" />
         <br />(e.g. "Web Developer", "Graphic Artist")
   </td>
  </tr>
  
  <tr valign="top">
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">Job Description:</span></td>
    <td>
      <textarea name="txt_job_desc" id="txt_job_desc" cols="5" rows="20" class="text_field required" >{$smarty.session.add_job.job_desc}</textarea>
       <br />1000 characters allowed. 
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">Position:</span></td>
    <td>
      <input name="txt_position" type="text" class="text_field" id="txt_position"  size="40" value="{$smarty.session.add_job.job_postion}" />
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">Start Date:</span></td>
    <td>
      <input name="txt_start_date" type="text" class="text_field" id="txt_start_date" maxlength="50" size="40" value="{$smarty.session.add_job.jsd}" />
          <br /><i> e.g. ASAP,  </i>
    </td>
  </tr>
  
  <tr valign="top">
    <td colspan="3">
    
     <div class="label1">
        <table width="100%">
          <tr valign="top">
            <td><div class="job_col">
                <img src="{$skin_images_path}required.gif" alt="" />
                <span class="label job">Job Type:</span></div></td>
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
            <td><img src="{$skin_images_path}required.gif" alt="" /><span class="label job">Job Status:</span></td>
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
    <td><span class="label">Salary range:</span></td>
    <td>
      <input name="txt_salary" type="text" class="text_field" id="txt_salary" size="25" value="{$smarty.session.add_job.salary}" />
      <select name="txt_salaryfreq" class="text_field">
        <option value=""></option>
        	{html_options options=$salaryfreq selected=$smarty.session.add_job.freq}
      </select>
    <br />
    <i>(e.g. 25000-30000 , 10 , 8.5, 123, 300, 25k-45k ) </i>
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">Education:</span></td>
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
    <td><span class="label">Career Level:</span></td>
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
    <td><span class="label">Year Of Experience: </span></td>
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
    <td><span class="label">Job Location: </span></td>
    <td><input type="hidden" name="txt_country" id="txt_country" value="{$countrycode}" />
        
        <div style="float:left; min-width:178px; padding-right:10px;"><label>State: </label>
            <div id="stateprovince_auto">
                {if $lang.states|@count > 0}
                    <select class="select" name="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
                    {html_options options=$lang.states selected=$smarty.session.loc.stateprovince}
                    </select>
                { else }
                    <input class="text_field required" name="txtstateprovince" type="text" size="30" maxlength="100" value="{$smarty.session.loc.stateprovince}" />
               { /if}                
            </div>
        </div>
        
        <div style="float:left; min-width:175px; padding-right:10px;"> <label>County : </label>
        <div id="county_auto">
          { if $lang.counties|@count > 0}
            <select class="select" name="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
            {html_options options=$lang.counties selected=$smarty.session.loc.countycode}
            </select>
          { else }
            <input name="txtcounty" type="text" size="30" maxlength="100" value="{$smarty.session.loc.countycode}" />
          { /if}
        
        </div>
        </div>
        
        <div style="float:left; min-width:175px; padding-right:10px;">
            <label>City: </label>
            <div id="city_auto">
              { if $lang.cities|@count > 0}
                <select class="select" name="txtcity" >
                  {html_options options=$lang.cities selected=$smarty.session.loc.citycode}
                </select>
              { else }
                <input name="txtcity" type="text" size="30" maxlength="100" value="{$smarty.session.loc.citycode}" />
              { /if}
        
            </div>
         </div>
        <div class="clear">&nbsp;</div>
    </td>
  </tr>
  
  <tr valign="top">
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td valign="top"><span class="label">Select Categories:</span></td>
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
                <a onclick="return check_box('{$k}', 'txt_category[]', 10);">{$v|strip_tags}</a>
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
  <input name="bt_add" id="bt_add" type="submit"  value="Post Job" class="button" />
  <input name="bt_reset" type="reset"  value=" Reset "  class="button" />

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
