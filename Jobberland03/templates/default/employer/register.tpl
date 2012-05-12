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

<table width="100%" >
 <colgroup>
   <col width="70%" />
   <col />
 </colgroup>
<tr>
<td>
<div class="header">{lang mkey='header' skey='Registration'}</div>

<div class="border">
  <form action="" method="post" enctype="multipart/form-data">
    <table class="register_table2" width="100%">
        
        <tr>
            <td colspan="3">
                {if $message != "" } {$message} {/if}
                
                {lang mkey='required_info_indication'}
            </td>
        </tr>
        
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><div class='td_width'><span class="label">{lang mkey='label' skey='username'}: </span></div></td>
            <td><input type="text" id="txt_username" name="txt_username" size="25" class="text_field required" 
            	value="{$smarty.session.add_emp.username}" /></td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">{lang mkey='label' skey='email_address'}:</span></td>
            <td><input type="text" id="txt_email" name="txt_email" size="30" class="text_field required" value="{$smarty.session.add_emp.email}"/>
                <br /><i>{lang mkey='info' skey='email_address'}</i>
            </td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">{lang mkey='label' skey='password'}: </span></td>
            <td><input type="password" id="txt_pass" name="txt_pass" size="20" class="text_field required" value="{$smarty.session.add_emp.pass}" />
                <br /><i>{lang mkey='info' skey='password'}</i>
            </td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">{lang mkey='label' skey='confirm_password'}: </span></td>
            <td><input type="password" id="txt_confirm_pass" name="txt_confirm_pass" size="20" 
                class="text_field required" value="" /></td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">{lang mkey='label' skey='company_name'}: </span></td>
            <td><input type="text" name="txt_company_name" size="35"  class="text_field required"  value="{$smarty.session.add_emp.com_name}" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><span class="label">{lang mkey='label' skey='company_contact_name'}: </span></td>
            <td><input type="text" id="txt_contact_name" name="txt_contact_name" size="25" class="text_field" value="{$smarty.session.add_emp.contactName}" /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><span class="label">{lang mkey='label' skey='WebSite'}: </span></td>
            <td>http://<input type="text" id="txt_site" name="txt_site" size="20" class="text_field"  value="{$smarty.session.add_emp.url}" /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><span class="label">{lang mkey='label' skey='address'}: </span></td>
            <td><input type="text" id="txt_address" name="txt_address" size="25" class="text_field" value="{$smarty.session.add_emp.address}"  /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><span class="label">{lang mkey='label' skey='address2'}: </span></td>
            <td><input type="text" id="txt_address2" name="txt_address2" size="30" class="text_field" value="{$smarty.session.add_emp.address2}"  /></td>
        </tr>
        
    <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">{lang mkey='label' skey='country'}: </span></td>
        <td>
        
        <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
            {html_options options=$country selected=$smarty.session.loc.country}
        </select>
         </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td><span class="label">{lang mkey='label' skey='state'}: </span></td>
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
        <td><span class="label">{lang mkey='label' skey='county'}: </span></td>
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
        <td><span class="label">{lang mkey='label' skey='city'}: </span></td>
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
            <td><span class="label">{lang mkey='label' skey='post_code'}: </span></td>
            <td><input type="text" id="txt_pcode" name="txt_pcode" size="10" class="text_field" value="{$smarty.session.add_emp.pCode}"  /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><span class="label">{lang mkey='label' skey='PhoneNumber'}:</span></td>
            <td><input type="text" id="txt_tele" name="txt_tele" size="20" class="text_field" value="{$smarty.session.add_emp.tel}"  /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><span class="label">{lang mkey='label' skey='Logo'}: </span></td>
            <td><input type="file" id="txt_logo" name="txt_logo" class="text_field"  />
             <input type="hidden" name="MAX_FILESIZE" value="{$MAX_CV_SIZE}" />
            <br /><i>{$cv_max_size} max. {$ALLOWED_FILE_TYPES_IMG} files only</i>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><span class="label">{lang mkey='label' skey='CompanyDesc'}: </span></td>
            <td><textarea name="txt_company_desc" id="txt_company_desc" cols="5" rows="20" class="text_field" >{$smarty.session.add_emp.comDesc}</textarea></td>
        </tr>
 
        {if $ENABLE_SPAM_REGISTER && $ENABLE_SPAM_REGISTER == 'Y' }
      <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td valign="top"><span class="label">{lang mkey='label' skey='security_code' }</span></td>
        <td>
            <input type="text" name="spam_code" id="spam_code" value="" class="txt_field" />   
        </td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td><img src="{$BASE_URL}captcha/SecurityImage.php"  alt="Security Code" id="spam_code_img" name="spam_code_img" />&nbsp;&nbsp;
        <a href="javascript:reloadCaptcha();" ><img src="{$BASE_URL}captcha/images/arrow_refresh.png" alt="Refresh Code" border="0" /></a> 
        
        </td>
      </tr> 

        {/if}
        
        <tr>
            <td colspan="3"><img src="{$skin_images_path}required.gif" alt="" /> 
               <input type="checkbox" name="txt_terms" value="1" />
                	{lang mkey="label" skey='terms'} <a href="{$BASE_URL}employer/page/terms/" target="_blank">{lang mkey="link" skey='register_terms'}</a>.
            </td>
        </tr>
        
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>


        <tr>
            <td></td>
            <td></td>
            <td><input type="submit" id="bt_register" name="bt_register" class="button register" value=" {lang mkey='button' skey='register'} &raquo;" /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
    </table>
  </form>
</div>

</td>
<td valign="top">&nbsp;</td>
</tr>
</table>