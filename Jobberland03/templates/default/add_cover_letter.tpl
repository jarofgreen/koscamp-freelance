<div class="header">{lang mkey='header' skey='new_cl'}</div>

{if $message != "" } <br /> {$message} <br /> {/if}

<form action="" method="post" enctype="multipart/form-data" >
    <div class="cl_upload_container">
     <label class="label">{lang mkey='label' skey='cl_title'} <img src="{$skin_images_path}required.gif" alt="" /> </label>
     <br /><input type="text" name="txt_name" size="35" value="{$smarty.session.cl.title}" />
     <br /><br /><textarea name="txt_letter" cols="70" rows="20">{$smarty.session.cl.text}</textarea>
      <p><input type="submit" name="bt_cl_add" class="button" value="{lang mkey='button' skey='save'}"  /></p>
    </div>
</form>