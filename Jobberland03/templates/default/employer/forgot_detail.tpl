<div class="header">{lang mkey='header' skey='forgot_details'}</div>

{if $message != "" } <br />{$message}<br /> {/if}

<form action="" method="post" >
    <table width="100%" border="0" id="forgot_password_table">
      
      <tr>
        <td colspan="4"><strong>{lang mkey='forgot_details' skey='1'}</strong></td>
      </tr>
      
      <tr>
        <td><img src="{$skin_images_path}required.gif" alt="" /></td>
        <td><span class="label">{lang mkey='label' skey='email_address'}: </span></td>
        <td>
          <input name="txt_email" type="text" size="35" class="text_field" value=""  /></td>
          <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>


 {if $ENABLE_SPAM_FD && $ENABLE_SPAM_FD == 'Y' }
  <tr>
    <td colspan="3"><span class="label">{lang mkey='security_code_txt'}</span></td>
  </tr>

  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td valign="top"><span class="label">{lang mkey='label' skey='security_code' }</span></td>
    <td>
    	<input type="text" name="spam_code" id="spam_code" value="" class="txt_field" size="10" />   
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td><img src="{$BASE_URL}captcha/SecurityImage.php"  alt="Security Code" id="spam_code_img" name="spam_code_img" alt="" />&nbsp;&nbsp;
	<a href="javascript:reloadCaptcha();" ><img src="{$BASE_URL}captcha/images/arrow_refresh.png" alt="Refresh Code" border="0" alt="" /></a> 
    </td>
  </tr> 
 {/if}
      
      <tr>
        <td>&nbsp;</td>
        <td>
          <input name="bt_username" type="submit" class="button" value="{lang mkey='button' skey='send_username'}" />
        </td>
        <td>
          <input name="bt_new_password" type="submit" class="button" value="{lang mkey='button' skey='send_new_pass'}" />
        </td>
        <td>&nbsp;</td>
      </tr>
      
    </table>
  </form>
