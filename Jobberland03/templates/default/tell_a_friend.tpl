{if $job == ''  }
<h1 class="header">&nbsp;</h1>
<br />

   <div class="error">{lang mkey='error' skey='swf_1'}</div>
   
{else}
<h1 class="header">{lang mkey='header' skey='swf'}</h1>

 <div class="border_around">  
    <div id="job_title">{$job_title}</div>
    <div class="clear">&nbsp;</div>
    <div>{$job_description}</div>
    <br />
    <strong>{lang mkey='label' skey='location'}</strong> {$location}
    <strong> {lang mkey='label' skey='created_at'} </strong>{$created_at}
  </div>
  

<form action="" method="post" id="send_to_friend_form" name="send_to_friend_form" >
 <input name="id" type="hidden" value="{$id}" />
 
  <table width="100%">
   <tr>
    <td>
      
      {if $message != "" } {$message} {/if}
      
    </td>
   </tr>
   <tr>
     <td><br /><img src="{$skin_images_path}required.gif" alt="" /> <b>Required information</b></td>
   </tr>
   <tr>
     <td><span class="label">{lang mkey='label' skey='send_this_job_to'} <img src="{$skin_images_path}required.gif" alt="" /></span></td>
   </tr>
   <tr>
     <td>
       <input name="txt_send_to1" type="text" class="text_field" size="50" value="{$smarty.session.share.send_to}" /><br />
          {lang mkey='swf' skey='info_1'}
     </td>
   </tr>
   
   <tr>
     <td><span class="label">{lang mkey='label' skey='subject_of_email'}</span></td>
   </tr>
   <tr>
     <td>
       <input name="txt_subject" type="text" class="text_field" size="30" maxlength="50" 
          value="{$smarty.session.share.subject}" /><br />
       {lang mkey='swf' skey='info_2'}
     </td>
   </tr>
   
   <tr>
     <td><span class="label">{lang mkey='label' skey='additional_comments'}</span></td>
   </tr>
   <tr>
     <td>
       <textarea name="txt_comments" cols="50" rows="10" >{$smarty.session.share.notes}</textarea></td>
   </tr>
   <tr>
     <td><span class="label">{lang mkey='label' skey='your_email_add'}<img src="{$skin_images_path}required.gif" alt="" /></span></td>
   </tr>
   <tr>
     <td>
       <input name="txt_email1" type="text" class="text_field" size="35" maxlength="50" value="{$smarty.session.share.from_send}" /><br />
       {lang mkey='swf' skey='info_3'}
     </td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   
   
{if $ENABLE_SPAM_SHARE && $ENABLE_SPAM_SHARE == 'Y' }
  <tr>
    <td><span class="label">{lang mkey='security_code_txt'}</span></td>
  </tr>

  <tr>
    <td valign="top"><span class="label">{lang mkey='label' skey='security_code' }</span><img src="{$skin_images_path}required.gif" alt="" /></td>
  </tr>
  <tr>  
    <td>
    	<input type="text" name="spam_code" id="spam_code" value="" class="txt_field" size="10" />   
    </td>
  </tr>
  
  <tr>
    <td><img src="{$BASE_URL}captcha/SecurityImage.php"  alt="Security Code" id="spam_code_img" name="spam_code_img" alt="" />&nbsp;&nbsp;
	<a href="javascript:reloadCaptcha();" ><img src="{$BASE_URL}captcha/images/arrow_refresh.png" alt="Refresh Code" border="0" alt="" /></a 
    ></td>
  </tr> 
  
{/if}   
   
   
   <tr>
     <td>&nbsp;</td>
   </tr>
   
   <tr>
     <td>
       <input name="bt_send" type="submit" class="button" value="{lang mkey='button' skey='stf'}" />
     </td>
   </tr>
  </table>

</form>
{/if}