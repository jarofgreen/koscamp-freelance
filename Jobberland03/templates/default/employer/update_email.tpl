<form action="" method="post">
<div class="header">{lang mkey='header' skey='change_email_add'}</div>

<p>{lang mkey='label' skey='ce_1'}</p>


<p>
	{$current_email}
    <br />
    { if $is_validated == 'Y' }
    	{lang mkey='label' skey='email_vaild'}   
    {else}
    	{lang mey='label' skey='pending_valid'} <br />
        <a href="">{lang mkey='link' skey='employee_resendemail'}</a>
    {/if}
</p>

<p>
	{if $message != "" } {$message} {/if}
</p>

<table width="100%">
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /> <span class="label">{lang mkey='label' skey='new_email_add'}</span></td>
    <td><input name="txt_email_address" type="text" class="text_field" size="35" value="" /></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><img src="{$skin_images_path}required.gif" alt="" /> <span class="label">{lang mkey='label' skey='new_email_add2'}</span></td>
    <td><input name="txt_confirm_email_address" type="text" class="text_field" size="35" value="" /></td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="bt_email" id="bt_email" class="button" value="{lang mkey='button' skey='update_email'}" /></td>
  </tr>

</table>

</form>
