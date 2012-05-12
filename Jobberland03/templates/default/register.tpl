<table width="100%">
 <tr>
  <td valign="top">

<fieldset class="round">
    <legend><strong>{lang mkey='header' skey='not_register_yet' }</strong></legend>
    
  <!-- RIGESTER -->
  <form action="" method="post" id="frm_register" name="frm_register" >
    <table class="register_table">
        
        <tr>
            <td colspan="3"> {if $message != "" } {$message} {/if} </td>
        </tr>
        <tr>
            <td colspan="3"> {lang mkey='required_info_indication'  }</td>
        </tr>
        
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">{lang mkey='label' skey='username'  }</span></td>
            <td><input type="text" id="reg_username" name="reg_username" size="25" 
                class="text_field required" value="{$smarty.session.reg.username}" /></td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">{lang mkey='label' skey='email_address'  }</span></td>
            <td><input type="text" id="reg_email" name="reg_email" size="30" class="text_field required" 
                value="{$smarty.session.reg.email}" />
                <br /><i>{lang mkey='info' skey='email_address'}</i>
            </td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">{lang mkey='label' skey='password'  }</span></td>
            <td><input type="password" id="reg_pass" name="reg_pass" size="20" 
                class="text_field required" value="{$smarty.session.reg.pass}" />
                <br /><i>{lang mkey='info' skey='password'}</i>
            </td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">{lang mkey='label' skey='confirm_password'  }</span></td>
            <td><input type="password" id="reg_confirm_pass" name="reg_confirm_pass" size="20" 
                class="text_field required" value="" /></td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">{lang mkey='label' skey='firstname'  }</span></td>
            <td><input type="text" id="reg_fname" name="reg_fname" size="25" class="text_field required" 
                value="{$smarty.session.reg.fname}" /></td>
        </tr>
        
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">{lang mkey='label' skey='surname'  }</span></td>
            <td><input type="text" id="reg_sname" name="reg_sname" size="20" class="text_field required" 
                value="{$smarty.session.reg.sname}" /></td>
        </tr>
        
    <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">{lang mkey='label' skey='country' }</span></td>
        <td>
        
        <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
            {html_options options=$country selected=$smarty.session.loc.country}
        </select>
         </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td><span class="label">{lang mkey='label' skey='state'  }</span></td>
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
        <td><span class="label">{lang mkey='label' skey='county'  }</span></td>
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
        <td><span class="label">{lang mkey='label' skey='city' }</span></td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td colspan="3"> <img src="{$skin_images_path}required.gif" alt="" /> 
               <input type="checkbox" name="txt_terms" value="1" />
                	{lang mkey="label" skey='terms'} <a href="{$BASE_URL}page/terms/" target="_blank">{lang mkey="link" skey='register_terms'}</a>.
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td></td>
            <td><input type="submit" id="bt_register" name="bt_register" class="button register" value=" {lang mkey='button' skey='register' } &raquo;" /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
    </table>
  </form>
  </fieldset>
  </td>
  <td valign="top">
    <fieldset class="round">
    <legend><strong>{lang mkey="header" skey='register_now_benefit'}:</strong></legend>
	
    <div>&nbsp;</div>
    
    <img src="{$skin_images_path}jabber_protocol.png" alt="" style="float:left;" />
        <div style="float:left; width:80%;">
          <strong>{lang mkey="register" skey='header1'}</strong>
          <br />{lang mkey="register" skey='info1'}
        </div>
        
    <div class="clear">&nbsp;</div> 
    <img src="{$skin_images_path}jabber_protocol.png" alt="" style="float:left;" />
        <div style="float:left; width:80%;">
          <strong>{lang mkey="register" skey='header2'}</strong>
          <br />{lang mkey="register" skey='info2'}<br />
        </div>

   <div class="clear">&nbsp;</div>
   <img src="{$skin_images_path}jabber_protocol.png" alt="" style="float:left;" />
        <div style="float:left; width:80%;">
          <strong>{lang mkey="register" skey='header3'}</strong>
 			<br />{lang mkey="register" skey='info3'}
            <br />
        </div>
        
 	<div class="clear">&nbsp;</div>
   	{*
    <img src="{$skin_images_path}jabber_protocol.png" alt="" style="float:left;"/>
    <div style="float:left; width:80%;">
        <strong>{lang mkey="register" skey='header4'}</strong>
        <br />{lang mkey="register" skey='info4'}
        <br />
    </div>  
 	*}
    </fieldset>
  </td>
 </tr>
</table>
  
