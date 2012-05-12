<div class="header">{lang mkey='header' skey='rename_cv'}</div>

{if $message != "" } <br />{$message}<br /> {/if}


<form action="" method="post" enctype="multipart/form-data" >
  <div class="cv_upload_container">
   <p> 
    <label class="label">{lang mkey='label' skey='name_cv' } <img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />{lang mkey='info' skey='cv_name'} 
    <br /><input type="text" name="txt_title" value="{$name}" />
   </p>
   
   <p> 
    <label class="label">{lang mkey='label' skey='desc_cv'}</label>
    <br />{lang mkey='info' skey='cv_desc'}
    <br /><textarea name="txt_desc" rows="5" cols="60">{$notes}</textarea>
   </p>
   
   <p>
        <input type="submit" name="bt_save" class="button" value=" {lang mkey='button' skey='save'} "  />
   </p> 
  </div>
</form>