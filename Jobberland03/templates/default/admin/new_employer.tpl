{strip}

{literal} 
<script language="javascript" type="text/javascript">
  tinyMCE.init({
    theme : "advanced",
    mode: "exact",
    elements : "txt_company_desc",
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

<div class="header">Add new Employer</div>
<h1>Registration</h1>

{if $message != "" } {$message} {/if}

<form action="" method="post" enctype="multipart/form-data">
<table width="100%">
    
    <tr>
        <td colspan="3">
            Fields marked with an asterisk (<img src="{$skin_images_path}required.gif" alt="" />) are mandatory
        </td>
    </tr>
    <tr>
        <td colspan="3"><img src="{$skin_images_path}required.gif" alt="" /> <strong>Required information</strong> </td>
    </tr>
    
    <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><div class='td_width'><span class="label">Username:</span></div></td>
        <td><input type="text" id="txt_username" name="txt_username" size="25" class="text_field required" value="{$smarty.session.Employer_Text.username}" /></td>
    </tr>
    <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">Email Address:</span></td>
        <td><input type="text" id="txt_email" name="txt_email" size="30" class="text_field required" value="{$smarty.session.Employer_Text.email}" />
            <br /><i>Please provide valid email address</i>
        </td>
    </tr>
    <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">Password: </span></td>
        <td><input type="password" id="txt_pass" name="txt_pass" size="20" class="text_field required" value="{$smarty.session.Employer_Text.pass}" />
            <br /><i>Password must be between 6 - 20 characters </i>
        </td>
    </tr>
    <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">Confirm Password: </span></td>
        <td><input type="password" id="txt_confirm_pass" name="txt_confirm_pass" size="20" class="text_field required" value="" /></td>
    </tr>
    <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">Company Name: </span></td>
        <td><input type="text" name="txt_company_name" size="35"  class="text_field required"  value="{$smarty.session.Employer_Text.company_name}" /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><span class="label">Contact Name: </span></td>
        <td><input type="text" id="txt_contact_name" name="txt_contact_name" size="25" class="text_field" value="{$smarty.session.Employer_Text.conatc_name}" /></td>
    </tr>
    
    <tr>
        <td>&nbsp;</td>
        <td><span class="label">Web Site: </span></td>
        <td>http://<input type="text" id="txt_site" name="txt_site" size="20" class="text_field" value="{$smarty.session.Employer_Text.site}" /></td>
    </tr>
    
    <tr>
        <td>&nbsp;</td>
        <td><span class="label">Address: </span></td>
        <td><input type="text" id="txt_address" name="txt_address" size="25" class="text_field" value="{$smarty.session.Employer_Text.address}"  /></td>
    </tr>
    
    <tr>
        <td>&nbsp;</td>
        <td><span class="label">Address2: </span></td>
        <td><input type="text" id="txt_address2" name="txt_address2" size="30" class="text_field" value="{$smarty.session.Employer_Text.address2}" /></td>
    </tr>
    

    <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">Country: </span></td>
        <td>
        
        <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
            {html_options options=$country selected=$smarty.session.loc.country}
        </select>
         </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td><span class="label">State / Province: </span></td>
        <td>
            <div id="stateprovince_auto">
            
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
        <td>&nbsp;</td>
        <td><span class="label">County / District: </span></td>
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
        <td>&nbsp;</td>
        <td><span class="label">City / Locality: </span></td>
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
        <td>&nbsp;</td>
        <td><span class="label">Post Code: </span></td>
        <td><input type="text" id="txt_pcode" name="txt_pcode" size="10" class="text_field" value="{$smarty.session.Employer_Text.pcode}" /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><span class="label">Phone Number:</span></td>
        <td><input type="text" id="txt_tele" name="txt_tele" size="20" class="text_field" value="{$smarty.session.Employer_Text.tel_no}" /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><span class="label">Logo: </span></td>
        <td><input type="file" id="txt_logo" name="txt_logo" class="text_field"  />
         <input type="hidden" name="MAX_FILESIZE" value="{$MAX_CV_SIZE}" />
        <br /><i>{$max_cv} max. 
        {$ALLOWED_FILE_TYPES_IMG} files only</i>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><span class="label">Company Description: </span></td>
        <td><textarea name="txt_company_desc" id="txt_company_desc" cols="60" rows="20" class="text_field" >{$smarty.session.Employer_Text.desc}</textarea></td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    
    <tr>
        <td></td>
        <td></td>
        <td><input type="submit" id="bt_register" name="bt_register" class="button register" value=" Register &raquo;" /></td>
    </tr>
    
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    
</table>
</form>
{/strip}