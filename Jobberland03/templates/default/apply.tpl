{if $jobs} 
<div class="header">&nbsp;</div>

<div  class="border_around" >
    <div id="job_title">{$job_title}</div>
    
    <div class="clear">&nbsp;</div>
    
    <div>{$job_description}</div>
    
    <br />
    <strong>{lang mkey='label' skey='location'}</strong> {$location}
    {*<?php echo  $job->job_ref  ? "<strong> Reference: </strong>".safe_output($job->job_ref)  : "" ?>*}
    <strong>{lang mkey='label' skey='company_name'} </strong>{$company_name}
    <strong>{lang mkey='label' skey='company_contact_name'}</strong>{$contact_name}
    {if $start_date !=''}<strong>{lang mkey='label' skey='start_date'} </strong>{$start_date} {/if}
    <strong>{lang mkey='label' skey='created_at'} </strong>{$created_at}
</div>
<br /><br />

  	{if $message != "" } {$message} {/if}
    
    <h3>{lang mkey='header' skey='apply_question'}</h3>
    
    {lang mkey='required_info_indication'}
  
<form action="" method="post" enctype="multipart/form-data" id="apply_form" >
 {*onsubmit="return validate_from_one_click('apply_form');" >*}
  <table width="100%" >
    <colgroup>
      <col />
      <col width="30%" />
      <col />
    </colgroup>
    <tr>
      <td><img src="{$skin_images_path}required.gif" alt="" /></td>
      <td><label class="label">{lang mkey="label" skey='email_address' }</label></td>
      <td><input type="text" name="txt_email1" class="text_fields" id="txt_email" 
            value="{$smarty.session.apply.email}" size="35" /></td>
    </tr>
    <tr>
      <td><img src="{$skin_images_path}required.gif" alt="" /></td>
      <td><label class="label">{lang mkey='label' skey='working_status'} </label></td>
      <td>
      
        <select name="txt_working_status" id="txt_working_status" class="text_fields" >
        	<option value=""></option>
      		{html_options options=$working_status selected=$smarty.session.apply.work_status}
      	</select>

      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>{lang mkey='label' skey='cover_letter'}</td>
      <td>
        {if is_array ($my_letters) && $my_letters != "" }
          {lang mkey='info' skey='apply_cv'}<br />
          <select name="txt_which_letter" onchange="ajax_page( 'txt_letter', '{$BASE_URL}cascade/covering_letter.php?id='+this.value );">
            <option value="">{lang mkey='new_cover_letter'}</option>
              {foreach from=$my_letters key=k item=i}
                 <option {if $i.is_defult == 'Y'}selected='selected'{/if} value="{$i.id}" >{$i.cl_title}</option> 
              {/foreach}
              
          </select>
        <br />
        {/if}    
        <textarea name="txt_letter" class="text_fields" id="txt_letter" cols="40" rows="5">{$smarty.session.apply.cover_letter}</textarea>
      </td>
    </tr>
    <tr>
      <td><img src="{$skin_images_path}required.gif" alt="" /></td>
      <td><label class="label">{lang mkey='label' skey='upload_cv'} </label></td>
      <td>
        {if is_array ($my_cv) && $my_cv != "" }
        	<select name="txt_existed_cv">
                <option value=""></option>
                {foreach from=$my_cv key=k item=i}
                 <option {if $i.default_cv == 'Y'}selected='selected'{/if} value="{$i.id}" >{$i.cv_title}</option> 
              {/foreach}
            </select>
            <br />
        {/if}
        
        {*
        <textarea name="txt_cv_field" cols="60" rows="5">{$smarty.session.apply.txt_cv_field}</textarea>
        *}
        <input type="file" name="txt_cv" class="text_fields" id="txt_cv" />
       
        <input type="hidden" name="MAX_CV_FILESIZE" value="{$MAX_CV_SIZE}" />
        <br /><i>{lang mkey='cv_max_size'} {lang mkey='max'} 
        {$ALLOWED_FILETYPES_DOC} {lang mkey='files_only'}</i>
      </td>
    </tr>

{if $ENABLE_SPAM_APPLY_JOB && $ENABLE_SPAM_APPLY_JOB == 'Y' && $logged_user_id == ''}
  <tr>
    <td colspan="3"><span class="label">{lang mkey='security_code_txt'}</span></td>
  </tr>

  <tr valign="top">
    <td><img src="{$skin_images_path}required.gif" alt="" /></td>
    <td valign="top"><span class="label">{lang mkey='label' skey='security_code' } </span></td>
    <td>
    	<input type="text" name="spam_code" id="spam_code" value="" class="txt_field" size="10" />   
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td>
     <img src="{$BASE_URL}captcha/SecurityImage.php"  alt="Security Code" id="spam_code_img" name="spam_code_img" alt="" />&nbsp;&nbsp;
	<a href="javascript:reloadCaptcha();" >
      <img src="{$BASE_URL}captcha/images/arrow_refresh.png" alt="Refresh Code" border="0" alt="" /></a> 
    </td>
  </tr> 
  
{/if}

    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="{lang mkey='button' skey='submite_application'}" class="button" /></td>
    </tr>
    
    <tr>
      <td colspan="3" class="optional_hd">{lang mkey='header' skey='apply_further_app'}</td>
    </tr>
    
    
    <tr>
      <td>&nbsp;</td>
      <td>{lang mkey='label' skey='firstname'} </td>
      <td><input type="text" name="txt_fname" class="text_fields" id="txt_fname" value="{$smarty.session.apply.fname}" size="25" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>{lang mkey='label' skey='surname'}</td>
      <td><input type="text" name="txt_sname" class="text_fields" id="txt_sname" value="{$smarty.session.apply.sname}" size="25" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>{lang mkey='label' skey='address'}</td>
      <td>
          <textarea name="txt_address" id="txt_address" class="text_fields" cols="40" rows="5">{$smarty.session.apply.address}</textarea>
      </td>
    </tr>
   
    <tr>
      <td>&nbsp;</td>
      <td>{lang mkey='label' skey='home_tel'}</td>
      <td><input type="text" name="txt_tel" class="text_fields" id="txt_tel" value="{$smarty.session.apply.home_tel}" size="15" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>{lang mkey='label' skey='mobile_no'}</td>
      <td><input type="text" name="txt_mob" class="text_fields" id="txt_mob" value="{$smarty.session.apply.mob_tel}" size="15" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>{lang mkey='label' skey='availability_notice'} </td>
      <td>
           
        <select name="txt_notice" id="txt_notice" class="text_fields" >
        	<option value=""></option>
      		{html_options options=$notice selected=$smarty.session.apply.notice}
      	</select>
     </td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>{lang mkey='label' skey='hourly_rate'}</td>
      <td>
        <select name="txt_salary" id="txt_salary" class="text_fields" >
            <option value=""></option>
				{html_options options=$salary selected=$smarty.session.apply.salary}
        </select>
      </td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>{lang mkey='label' skey='approximately_far_travel'}</td>
      <td>
        <select name="txt_willing_to_travel" id="txt_willing_to_travel" class="text_fields" >
            <option value=""></option>
            {html_options options=$willing_to_travel selected=$smarty.session.apply.willing_to_travel}
        </select>
      </td>
    </tr>
    
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
   
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="{lang mkey='button' skey='submite_application'}" class="button" /></td>
    </tr>
    
  </table>
</form>
</div>
{else}
	<div class='error'>{lang mkey='error' skey='apply_not_found' }</div>
{/if}
