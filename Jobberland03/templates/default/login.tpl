<fieldset>
<table>
<tr>
  <td valign="top">  
  <fieldset class="round">
  <legend> <strong>{lang mkey='header' skey='login_already'}</strong> </legend>
  <!-- LOGIN TABLE -->
  <form action="" method="post">
  <table class="login_table">
   
   <tr>
    <td colspan="3">
	{if $message != "" } {$message} {/if}
    </td>
   </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">{lang mkey='label' skey='username'}:</span></td>
    <td>
     <input type="text" id="useranme_txt" name="useranme_txt" size="30" class="text_field required" value="{$username}"  /></td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td><span class="label">{lang mkey='label' skey='password'}:</span></td>
    <td><input type="password" id="pass_txt" name="pass_txt" size="15" class="text_field required" value="" /></td>
  </tr>
 
{if $ENABLE_SPAM_LOGIN && $ENABLE_SPAM_LOGIN == 'Y' }
{*
  <tr>
    <td colspan="3"><span class="label">{lang mkey='security_code_txt'}</span></td>
  </tr>
*}
  <tr valign="top">
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td valign="top"><span class="label">{lang mkey='label' skey='security_code' }:</span></td>
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
    <td></td>
    <td></td>
    <td><input type="submit" id="bt_login" name="bt_login" class="button login" value=" {lang mkey='button' skey='login'} &raquo;" />
    
    {if $LINKEDIN == 'Y'}
    	<a href="{$LINKEDIN_CALLBACKURL}">
          <img src="{$BASE_URL}/plugins/linkedin/img/login.png" border="0" width="100" />
        </a>
      {*include file='facebook.tpl'*}
    {/if}
    
    </td>
  </tr>
  
</table>
</form>

<br />
    <strong>{lang mkey='link_header' skey='login_forgot'}</strong><br />
    <a href="{$BASE_URL}forgot_details/">{lang mkey='link' skey='employee_remindedup'}.</a>
<br /><br />

    <strong>{lang mkey='link_header' skey='login_lostconf'}</strong><br />
    <a href="{$BASE_URL}resend_conflink/">{lang mkey='link' skey='employee_resendemail'}</a>

</fieldset>
</td>

<td valign="top">
<fieldset class="round">
<legend> <strong> {lang mkey='header' skey='login_register'} </strong> </legend>
{lang mkey='login' skey='info'}

 <!-- <p> Let jobs come to you with our arsenal of tools, including daily and instant job alerts.
  Upload and activate your CV and allow prospective employers to find you.</p> -->
  
 <input type="button" value="{lang mkey='button' skey='register'}" class="button" onclick="go_to('{$BASE_URL}register/');"/>

  <br />
        <h3>{lang mkey='login' skey='why_register' }</h3>
        
        <img src="{$skin_images_path}easymoblog.png" alt="" style="float:left;" />
        <div style="float:left; width:79%;">
          <strong>{lang mkey='login' skey='header1' }</strong>
          <br />{lang mkey='login' skey='info1' }<br />
        </div>
        
        <div class="clear">&nbsp;</div>
        <img src="{$skin_images_path}search.png" alt="" style="float:left;" /> 
        <div style="float:left;width:79%;">
          <strong>{lang mkey='login' skey='header2' }</strong>
          <br />{lang mkey='login' skey='info2' }<br />
        </div>
        
        <div class="clear">&nbsp;</div>
        <img src="{$skin_images_path}keditbookmarks.png" alt="" style="float:left;" /> 
        <div style="float:left;width:79%;">
            <strong>{lang mkey='login' skey='header3' }</strong>
          <br />{lang mkey='login' skey='info3' }<br />
        </div>
        
        <div class="clear">&nbsp;</div> 
        <img src="{$skin_images_path}knotes.png" alt="" style="float:left;" /> 
        <div style="float:left;width:79%;">
            <strong>{lang mkey='login' skey='header4' }</strong>
          <br />{lang mkey='login' skey='info4' }<br /> 
        </div>
        
        <div class="clear">&nbsp;</div>
        <img src="{$skin_images_path}mouse.png" alt="" style="float:left;" /> 
        <div style="float:left;width:79%;">
            <strong>{lang mkey='login' skey='header5' }</strong>
          <br />{lang mkey='login' skey='info5' }<br />
        </div>
        
        <div class="clear">&nbsp;</div>
        <img src="{$skin_images_path}kate.png" alt="" style="float:left;" /> 
        <div style="float:left;width:79%;">
            <strong>{lang mkey='login' skey='header6' }</strong>
          <br />{lang mkey='login' skey='info6' }<br />
        </div>

</fieldset>

</td>
</tr>
</table>
</fieldset>
