<table width="100%">
 <tr>
  <td valign="top">

<strong>Add New Employee</strong>

<!-- RIGESTER -->
  <form action="" method="post" id="frm_register" name="frm_register" >
    <table width="100%">        
        <tr>
            <td colspan="3"> {if $message != "" } {$message} {/if} </td>
        </tr>
        <tr>
            <td colspan="3"> Fields marked with an asterisk (<img src="{$skin_images_path}required.gif" alt="" />) are mandatory  </td>
        </tr>
        
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">Username:</span></td>
            <td><input type="text" id="reg_username" name="reg_username" size="25" 
                class="text_field required" value="{$smarty.session.reg.username}" /></td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">Email Address:</span></td>
            <td><input type="text" id="reg_email" name="reg_email" size="30" class="text_field required" 
                value="{$smarty.session.reg.email}" />
                <br /><i>Please provide valid email address</i>
            </td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">Password: </span></td>
            <td><input type="password" id="reg_pass" name="reg_pass" size="20" 
                class="text_field required" value="{$smarty.session.reg.pass}" />
                <br /><i>Password must be between 6 - 20 characters </i>
            </td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">Confirm Password: </span></td>
            <td><input type="password" id="reg_confirm_pass" name="reg_confirm_pass" size="20" 
                class="text_field required" value="" /></td>
        </tr>
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">Firstname: </span></td>
            <td><input type="text" id="reg_fname" name="reg_fname" size="25" class="text_field required" 
                value="{$smarty.session.reg.fname}" /></td>
        </tr>
        
        <tr>
            <td><img src="{$skin_images_path}required.gif" alt="" /></td>
            <td><span class="label">Surname: </span></td>
            <td><input type="text" id="reg_sname" name="reg_sname" size="20" class="text_field required" 
                value="{$smarty.session.reg.sname}" /></td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="submit" id="bt_register" name="bt_register" class="button register" value=" Register &raquo;" /></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
    </table>
  </form>
  </td>
 </tr>
</table>
  
