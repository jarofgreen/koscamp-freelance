<form action="" method="post">
     <div class="header">{lang mkey='header' skey='change_password'}</div>

	{if $message != "" } {$message} {/if}

<p>{lang mkey='change_pass' skey='info'}</p>

<table width="100%">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" />
    <span class="label">{lang mkey='label' skey='v_old_pass'}:</span></td>
    <td><input name="txt_old_pass" type="password" class="text_field" /></td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" />
    <span class="label">{lang mkey='label' skey='new_password'}: </span></td>
    <td><input name="txt_new_pass" type="password" class="text_field" /></td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" />
    <span class="label">{lang mkey='label' skey='re_new_pass'}: </span></td>
    <td><input name="txt_new_pass_retry" type="password" class="text_field" /></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="bt_submit" value="{lang mkey='button' skey='submit'}" class="button"></td>
  </tr>
  
</table>
<p>&nbsp;</p>
</form>