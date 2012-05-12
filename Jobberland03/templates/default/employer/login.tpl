<table width="100%" >
  <tr>
   <td valign="top">
   <div class="header">{lang mkey="header" skey='Signin' }</div>

{if $message != "" } <br />{$message}<br /> {/if}

<form action="" method="post">
<table width="100%" class="border">
 <tr>
  <td colspan="3">&nbsp;</td>
 </tr>
 <tr>
  <td><img src="{$skin_images_path}required.gif" alt="" /></td>
  <td><span class="label">{lang mkey="label" skey='username' } </span></td>
  <td><input type="text" id="useranme_txt" name="useranme_txt" size="30" class="text_field required" value=""  /></td>
 </tr>

 <tr>
  <td><img src="{$skin_images_path}required.gif" alt="" /></td>
  <td><span class="label">{lang mkey="label" skey='password' } </span></td>
  <td><input type="password" id="pass_txt" name="pass_txt" size="15" class="text_field required" value="" /></td>
 </tr>

{if $ENABLE_SPAM_LOGIN && $ENABLE_SPAM_LOGIN == 'Y' }
 {*
 <tr>
  <td colspan="3"><span class="label">{lang mkey='security_code_txt'}</span></td>
 </tr>
 *}

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
   <a href="javascript:reloadCaptcha();" >
     <img src="{$BASE_URL}captcha/images/arrow_refresh.png" alt="Refresh Code" border="0" alt="" /></a> 
   </td>
 </tr> 

{/if}

 <tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><input type="submit" id="bt_login" name="bt_login" class="button login" value=" {lang mkey='button' skey='login' } &raquo; " /></td>
 </tr>
</table>
</form>

<br /><br />
<strong>{lang mkey='link_header' skey='login_forgot'}</strong><br />
 <a href="{$BASE_URL}employer/forgot_details/">{lang mkey='link' skey='employee_remindedup'}.</a>
<br /><br />

<strong>{lang mkey='link_header' skey='login_lostconf'}</strong><br />
<a href="{$BASE_URL}employer/resend_conflink/">{lang mkey='link' skey='employee_resendemail'}</a>

  </td>
  <td valign="top">

<div class="header">{lang mkey='header' skey='Newto'}</div>
    <p>{lang mkey='empreg' skey='info1'}</p>  
    <p><label id="titlelogin">{lang mkey='empreg' skey='info2'}</label><br />
    {lang mkey='empreg' skey='info3'}</p>
    <p align="center">
        <input name="bt_register" type="button" class="button" id="bt_cmd" value="{lang mkey='button' skey='continue' }" onclick="javascript:window.location = '{$BASE_URL}employer/register/'; " />
    </p>
  </td>
  
  </tr>
</table>