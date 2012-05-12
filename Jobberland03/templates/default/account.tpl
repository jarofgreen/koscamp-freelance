<div class="header">{lang mkey='header' skey='account_overview'}</div>

{lang mkey='account' skey='info1'}

<p> 

	{if $message != "" } {$message} {/if}
    
<br />
<form action="" method="post" name="account_form">
<div class="header">{lang mkey='header' skey='personal_details'}</div>

<table width="100%" class="small">
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td>{lang mkey='label' skey='title'} </td>
    <td>
         {html_options name=title_txt options=$titles selected=$smarty.session.account.title}
    </td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td>{lang mkey='label' skey='firstname'}</td>
    <td><input type="text" name="txt_fname" class="" value="{$fname}" size="25" /> </td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td>{lang mkey='label' skey='surname'}</td>
    <td><input type="text" name="txt_sname" class="" value="{$sname}" size="30" /></td>
  </tr>
  
  <tr>
    <td></td>
    <td>{lang mkey='label' skey='address'}</td>
    <td><input type="text" name="txt_address" class="" value="{$address}" size="40" /></td>
  </tr>
  
  <tr>
    <td></td>
    <td>{lang mkey='label' skey='address2'}</td>
    <td><input type="text" name="txt_address2" class="" value="{$address2}" size="40" /></td>
  </tr>

    <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">{lang mkey='label' skey='country'}</span></td>
        <td>
        
        <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
            {html_options options=$country selected=$smarty.session.loc.country}
        </select>
         </td>
    </tr>
    
    <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">{lang mkey='label' skey='state'} </span></td>
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
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">{lang mkey='label' skey='county'}</span></td>
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
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">{lang mkey='label' skey='city'}</span></td>
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
    <td>{lang mkey='label' skey='post_code'}</td>
    <td><input type="text" name="txt_post_code" class="" value="{$post_code}" size="10" /></td>
  </tr>
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td>{lang mkey='label' skey='home_tel'}</td>
    <td><input type="text" name="txt_phone_number" class="" value="{$phone_number}" size="30" /></td>
  </tr>
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td>{lang mkey='label' skey='email_address'}</td>
    <td>
      <input type="text" name="txt_email_address" class="" value="{$email_address}" size="35" disabled="disabled" />
      <br /><a href="{$BASE_URL}account/update_email/">{lang mkey='account' skey='link_update_email' }</a>
      
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
    <td><input type="submit" name="account_btn" value="{lang mkey='button' skey='save_my_profile'}" class="button" /></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>

</form>

<p>
    <div class="header">{lang mkey='header' skey='ac_login_email' }</div>
    <table class="contact_view" width="100%">
        <tr>
          <td></td>
        </tr>
        <tr>
          <td>
              <strong>{lang mkey='label' skey='username'} </strong>{$smarty.session.username}<br />
              <strong>{lang mkey='label' skey='password'} </strong><a href="{$BASE_URL}account/change_password/">{lang mkey='account' skey='link_change_pass' }</a><br />
              <strong>{lang mkey='label' skey='email_address'} </strong><a href="{$BASE_URL}account/update_email/">{lang mkey='account' skey='link_update_email' }</a>
          </td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td>
            <input name="bt_delete" type="submit" id="bt_cmd" value="{lang mkey='button' skey='delete_account'}" class="button" onclick="javascript: redirect_to('{$BASE_URL}account/delete_account/');" />
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
   </table>

</p>