{if $message != "" } {$message} {/if}

<h1>{lang mkey='header' skey='newcv'}</h1>

<form action="" method="post" enctype="multipart/form-data" >
  <div class="cv_upload_container">
    <label class="label">{lang mkey='label' skey='select_cv'} <img src="{$skin_images_path}required.gif" alt="" /></label>
    <br /><input type="file" name="txt_file_cv" id="" />
    <br /><i>{lang mkey='max_file_size'} {lang mkey='max'} 
        {$ALLOWED_FILETYPES_DOC} {lang mkey='files_only'}</i>
    
   <p> 
    <label class="label">{lang mkey='label' skey='name_cv' } <img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />{lang mkey='info' skey='cv_name'} 
    <br /><input type="text" name="txt_title" value="{$smarty.session.addcv.name}" />
   </p>
   <p> 
    <label class="label">{lang mkey='label' skey='desc_cv'}</label>
    <br />{lang mkey='info' skey='cv_desc'}
    <br /><textarea name="txt_desc" rows="5" cols="60">{$smarty.session.addcv.desc}</textarea>
   </p>
   <p>
        <input type="submit" name="bt_cv_add" class="button" value="{lang mkey='button' skey='saveandcontinue'}"  />
   </p> 
  </div>
</form>
