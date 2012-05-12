<div class="header">{lang mkey='header' skey='edit'} {$cl_title}</div>

{if $message != "" } <br />{$message} <br /> {/if}

<form action="" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="id" value="{$id}" />
    <label class="label">{lang mkey='label' skey='cl_title'}<img src="{$skin_images_path}required.gif" alt="" /> </label>
    <br /><input type="text" name="txt_name" size="35" value="{$cl_title}" /> 
    <br /><br /><textarea name="txt_letter" cols="70" rows="20">{$cl_text}</textarea>
    <p><input type="submit" name="bt_cl_edit" class="button" value="{lang mkey='button' skey='save'}"  /></p>
</form>