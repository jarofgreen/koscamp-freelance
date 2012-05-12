<h1 class="header">{lang mkey='header' skey='feedback'}</h1>
<div>

{if $message != "" } <br /> {$message} <br />  {/if}

<form action="" method="post" name="feedback_form" id="feedback_form" >
<table width="100%" border="0">
  <tr>
    <td colspan="2"></td>
  </tr>
  
  <tr>
    <td colspan="2">{lang mkey='required_info_indication'}<br /><br /></td>
  </tr>
  
  <!-- fullname input text field -->
  <tr valign="top">
    <td width="31%" height="25"><span class="label">{lang mkey='label' skey='fullname'} <img src="{$skin_images_path}required.gif" alt="" /></span></td>
    <td width="66%">
      <input name="txt_first_name1" type="text" class="text_Field" size="35" maxlength="35" value="{$smarty.session.feedback.name}" /></td>
    <td width="3%"></td>
  </tr>

  <!-- email input text field-->
  <tr>
    <td height="25"><span class="label">{lang mkey='label' skey='email_address'}
        <img src="{$skin_images_path}required.gif" alt="" /></span></td>
    <td><input name="txt_email1" type="text" class="text_Field" size="45" maxlength="45" value="{$smarty.session.feedback.email}" /></td>
  </tr>

  <!-- subject input text field -->
  <tr>
    <td height="25"><span class="label">{lang mkey='label' skey='subject'}</span></td>
    <td><input name="txt_subject" type="text" class="text_Field" size="30" maxlength="30" value="{$smarty.session.feedback.subject}" /></td>
  </tr>
  
  <tr>
    <td height="25"><span class="label">{lang mkey='label' skey='about_question'}
        <img src="{$skin_images_path}required.gif" alt="" /></span></td>
    <td>

        <select name="cbo_query1" class="text_Field" id="cbo_query" >
            <option value="">{lang mkey='select_one_text'}</option>
			{html_options options=$question_comment selected=$smarty.session.feedback.query}
        </select>

    </td>
  </tr>

  <!-- comment input text field -->
  <tr>
    <td height="108"><span class="label">
        {lang mkey='label' skey='question_comment'}<img src="{$skin_images_path}required.gif" alt="" />
        <br />{lang mkey='label' skey='feed_include'}</span></td>
    <td><textarea name="txt_comment1" class="text_Field" cols="40" rows="5" >{$smarty.session.feedback.comment}</textarea></td>
  </tr>

{if $ENABLE_SPAM_FEEDBACK && $ENABLE_SPAM_FEEDBACK == 'Y' && $logged_user_id == ''}
  <tr>
    <td colspan="2"><span class="label">{lang mkey='security_code_txt'}</span></td>
  </tr>

  <tr>
    <td valign="top"><span class="label">{lang mkey='label' skey='security_code' } <img src="{$skin_images_path}required.gif" alt="" /></span></td>
    <td>
    	<input type="text" name="spam_code" id="spam_code" value="" class="txt_field" size="10" />   
    </td>
  </tr>
  
  <tr>
    <td valign="top">&nbsp;</td>
    <td><img src="{$BASE_URL}captcha/SecurityImage.php"  alt="Security Code" id="spam_code_img" name="spam_code_img" alt="" />&nbsp;&nbsp;
	<a href="javascript:reloadCaptcha();" ><img src="{$BASE_URL}captcha/images/arrow_refresh.png" alt="Refresh Code" border="0" alt="" /></a> 
    </td>
  </tr> 
  
{/if}


  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <!-- command button -->
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="bt_send" value="{lang mkey='button' skey='send_feed'}" class="button" />
        {*<input type="button" name="bt_reset" value="Reset" class="button" 
        onclick="refreshPage('<?php echo $_SERVER['PHP_SELF']; ?>');" />*}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>     
</div>
