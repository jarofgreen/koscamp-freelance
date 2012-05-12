<div class="header">{lang mkey='header' skey='cv_visibility'}</div>

<div><p>{lang mkey='cv' skey='cv_r_info'}</p></div>

{if $message != "" } {$message} {/if}

<form action="" method="post" >
<input type="hidden" name="id" value="{$id}" />

<p>{lang mkey='required_info_indication'}</p>

<div class="cv_header">{lang mkey='header' skey='cv_1'}</div>
<div class="cv_contain">
<br />

{if  $smarty.session.resume.status == "private"}
	{lang mkey='cv' skey='cv_info_1'}
{else}
	{lang mkey='cv' skey='cv_info_2'}
{/if}
<p>
	<label class="label">{lang mkey='label' skey='cv_0'}</label>
</p>

<input type="radio" name="txt_status" {if $smarty.session.resume.status == "public" } checked="checked" {/if} value="public" class="radio" /> {lang mkey='label' skey='public' }
<br />{lang mkey='label' skey='cv_can_view' }

<br /> <br />

<input type="radio" name="txt_status" {if $smarty.session.resume.status == "private"} checked="checked"{/if} value="private" class="radio" /> {lang mkey='label' skey='private' }
<br />{lang mkey='label' skey='cv_cant_view' }<br />

<br /><br />

</div>

<br /><br />

<div class="cv_header">{lang mkey='header' skey='cv_2'}</div>
<div class="cv_contain">
    
    <label class="label">{lang mkey='label' skey='cv_1'}</label>
    <br />
    <select name='txt_experience' class="select" >
      {html_options options=$experience selected=$smarty.session.resume.exper}
    </select>
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_2'}</label>
    <br />
    <select name='txt_education' class="select" >
      {html_options options=$education selected=$smarty.session.resume.educ}
    </select>
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_3'}</label>
    <br />
    <select name='txt_salary' class="select">
        {html_options options=$salary selected=$smarty.session.resume.salary}
    </select>
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_4'}</label>
    <br />
    <select name='txt_availabe' class="select" >
    	{html_options options=$NoYes selected=$smarty.session.resume.availabe}
    </select>
        
    <hr />
    <label class="label">{lang mkey='label' skey='cv_5'}</label>
    <br />
{html_select_date 
prefix='txt_start_date_' 
start_year='-0' 
end_year="+5" 
field_order="DMY" 
month_format="%B" 
day_value_format="%02d" 
year_empty=$select_text 
month_empty=$select_text
day_empty=$select_text
time=$defult_date|default:'0000-00-00'}
        
   <hr />
   <label class="label">{lang mkey='label' skey='cv_6'}</label>
   <br />
   	<input type="text" name="txt_position" value="{$smarty.session.resume.position}" class="text_field" />
    <br /><br />
</div>

<br /><br />

<div class="cv_header">{lang mkey='header' skey='cv_3'}</div>
<div class="cv_contain">
    
    <label class="label">{lang mkey='label' skey='cv_7'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    	<input type="text" name="txt_recent_job_title" value="{$smarty.session.resume.rjt}" class="text_field" />
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_8'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <input type="text" name="txt_recent_employer" value="{$smarty.session.resume.re}" class="text_field" />
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_9'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <select name='txt_recent_industry' class="select">
        {html_options options=$category selected=$smarty.session.resume.riw}
    </select>
    
    <hr />
    <label class="label">{lang mkey='label' skey='cv_10'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <select name='txt_recent_career' class="select">
      {html_options options=$career selected=$smarty.session.resume.rcl}
    </select>
 <br /><br />
</div>

<br /><br />

<div class="cv_header">{lang mkey='header' skey='cv_4'}</div>

<div class="cv_contain">
 <label class="label">{lang mkey='label' skey='cv_11'}<img src="{$skin_images_path}required.gif" alt="" /></label>
 
 <br /><input type="text" name="txt_look_job_title" value="{$smarty.session.resume.ljt}" class="text_field" /><br />
 <br /><input type="text" name="txt_look_job_title2" value="{$smarty.session.resume.ljt2}" class="text_field" />

 <hr />
    <!-- 
    <label class="label">What occupation are you looking for?  (max. 5) <img src="{$skin_images_path}required.gif" alt="" /></label>
    
    <hr />
    -->
    <label class="label">{lang mkey='label' skey='cv_12'} <img src="{$skin_images_path}required.gif" alt="" /></label>
<div class="large_box box">	
    {foreach from=$category key=k item=v}
        <div class='new_job' >
        <input type="checkbox" value="{$k}"  
            {foreach from=$category_selected key=kk item=vv}
              {if $k eq $vv } checked="checked" {/if}
            {/foreach}
        onclick="return check_max_checkbox('category[]', 10 ); " name="category[]" class="checkbox" />
        <a onclick="return check_box('{$k}', 'category[]', 10 );">{$v|strip_tags}</a>
        </div>
    {/foreach}
    
    <div class="clear"></div>
</div>
    
    
    <hr />
    
   <label class="label">{lang mkey='label' skey='cv_13'} <img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <select name='txt_job_statu' class="select">
      {html_options options=$job_status selected=$smarty.session.resume.ljs}
    </select>
	
    <hr />
    
   <label class="label">{lang mkey='label' skey='cv_18'} {*<img src="{$skin_images_path}required.gif" alt="" />*}</label>
    <br />
    <select name='txt_job_type' class="select">
      {html_options options=$job_type selected=$smarty.session.resume.job_type}
    </select>
    
    
    <br /><br />
</div>

<br /><br />

<div class="cv_header">{lang mkey='header' skey='cv_5'}</div>

<div class="cv_contain">

     <label class="label">{lang mkey='label' skey='cv_14'}<img src="{$skin_images_path}required.gif" alt="" /></label>
     <br />

<table width="100%">
  <tr>
    <td width="49%">    
    <label class="label">{lang mkey='label' skey='country'}</label><br />
    <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
        {html_options options=$country selected=$smarty.session.loc.country}
    </select>
</td>
    <td width="49%">
    <label class="label">{lang mkey='label' skey='state'}</label><br />
    <div id="stateprovince_auto">
        {if $lang.states|@count > 0}
            <select class="select" name="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
            {html_options options=$lang.states selected=$smarty.session.loc.stateprovince}
            </select>
        { else }
            <input class="text_field required" name="txtstateprovince" type="text" size="30" maxlength="100" value="{$smarty.session.loc.stateprovince}" />
        { /if}                
    </div>
</td>
</tr>
<tr>
    <td>    
    <label class="label">{lang mkey='label' skey='county'} </label><br />
    <div id="county_auto">

      { if $lang.counties|@count > 0}
        <select class="select" name="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
        {html_options options=$lang.counties selected=$smarty.session.loc.countycode}
        </select>
      { else }
        <input name="txtcounty" type="text" size="30" maxlength="100" value="{$smarty.session.loc.countycode}" />
      { /if}
    
    </div>
</td>
    <td>
    <label class="label">{lang mkey='label' skey='city'}</label><br />
    <div id="city_auto">
      { if $lang.cities|@count > 0}
        <select class="select" name="txtcity" >
          {html_options options=$lang.cities selected=$smarty.session.loc.citycode}
        </select>
      { else }
        <input name="txtcity" type="text" size="30" maxlength="100" value="{$smarty.session.loc.citycode}" />
      { /if}

    </div>
</td>
  </tr>
</table>

    <hr />
    
    <label class="label">{lang mkey='label' skey='cv_15'}<img src="{$skin_images_path}required.gif" alt="" /></label>
     <br />
     <select name="txt_authorised_to_work" class="select" >
         <option value="">-SELECT-</option>
         {html_options options=$authorised_to_work selected=$smarty.session.resume.aya}
      </select>
    <hr />
    
    <label class="label">{lang mkey='label' skey='cv_16'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <select name='txt_relocate' class="select">
      {html_options options=$NoYes selected=$smarty.session.resume.wtr}
	</select>
    
    <hr />    
    <label class="label">{lang mkey='label' skey='cv_17'}<img src="{$skin_images_path}required.gif" alt="" /></label>
    <br />
    <select name="txt_travel" class="select" > 
      <option value="">-SELECT-</option>
      {html_options options=$willing_to_travel selected=$smarty.session.resume.wtt}      
    </select>
  <br /><br />
</div>

<br /><br />

<div class="cv_header">{lang mkey='header' skey='cv_6'}</div>
<div class="cv_contain">
  <textarea name="txt_notes" rows="10" cols="60" class="textarea" >{$smarty.session.resume.notes}</textarea>
  <br /><br />
</div>

<p>
 <input type="button" name="bt_cancel" value=" {lang mkey='button' skey='cancel'} " class="button" onclick="redirect_to('{$BASE_URL}curriculum_vitae/');" />
 <input type="submit" name="bt_save" value=" {lang mkey='button' skey='save_continue' }" class="button" /> 
</p>

    <SCRIPT LANGUAGE="javascript">
    	check_max_checkbox('category[]', 10 );
    </SCRIPT>

</form>