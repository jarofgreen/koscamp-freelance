<h1 class="header">{lang mkey='header' skey='rsce'}</h1>

<p>
    {lang mkey='label' skey='rsce_1'}
</p>

	{if $message != "" } <br />{$message}<br /> {/if}

<form action="" method="post" >
<table width="100%">
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><label class="label">{lang mkey='label' skey='email_address'}</label> </td>
    <td><input type="text" name="txtresend" size="35" class="" /></td>
  </tr>
{if $ENABLE_SPAM_RSC && $ENABLE_SPAM_RSC == 'Y' }
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   </tr>

  <tr>
    <td colspan="3"><span class="label">{lang mkey='security_code_txt'}</span></td>
  </tr>

  <tr>
    <td valign="top"><img src="{$skin_images_path}required.gif" alt="" /></td>
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
    <td>&nbsp;</td>
    <td><input type="submit" name="bt_resend" class="button" value="{lang mkey='button' skey='rsce'}" /></td>
   </tr>
   
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   </tr>
   
 </table>
</form>