<h1 class="header">{lang mkey='header' skey='SearchCV'}</h1>

{if $message != "" } <br />{$message}<br /> {/if}

<form action="" method="get" >
 <table border="0" cellpadding="5" cellspacing="0" width="100%" >
    <tr>
      <td>&nbsp;</td>
      <td><label class="label">{lang mkey='label' skey='keywords'}: </label></td>
      <td><input type="text" name="txt_keywords" id="" value="" size="35"  /></td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><label class="label">{lang mkey='label' skey='category'}: </label></td>
      <td>
      <div class="scroll_single">
            {foreach from=$category key=k item=v}    
            <div class="scroll_single_item" >
                 <input type="checkbox" value="{$k}"  
                    {foreach from=$category_selected key=kk item=vv}
                      {if $k eq $vv } checked="checked" {/if}
                    {/foreach}
                onclick="return check_max_checkbox('txt_category[]', 10 );  " name="txt_category[]" />
                <a onclick="return check_box('{$k}', 'txt_category[]', 10 );">{$v|strip_tags}</a>
            </div>
        {/foreach}
        <div class="clear"></div>
        </div>
        <strong>{lang mkey='Max10'}.</strong>
      </td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><label class="label">{lang mkey="label" skey='cv_1'}: </label></td>
      <td>      
        <select name="txt_experience">
            <option value="">{lang mkey='select_text'}</option>
        	{html_options options=$experience selected=$experience_selected}
        </select>

      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label class="label">{lang mkey='label' skey='HighEd'}: </label></td>
      <td>
        <select name="txt_education">
            <option value="">{lang mkey='select_text'}</option>
            {html_options options=$education selected=$education_selected}
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label class="label">{lang mkey='label' skey='search_type'}: </label></td>
      <td>
        <div class="scroll_single">
            {foreach from=$job_type key=k item=v}
                <div class="scroll_single_item" >
                <input type="checkbox" value="{$k}" 
                    {foreach from=$type_selected key=kk item=vv}
                      {if $k eq $vv } checked="checked" {/if}
                    {/foreach}
                name="txt_job_type[]" /> {$v}
                </div>
            {/foreach}
        </div>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label class="label">{lang mkey='label' skey='AvStart'}: </label></td>
      <td>
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
      </td>
      <td>&nbsp;</td>
    </tr>
       
    <tr>
      <td>&nbsp;</td>
      <td><label class="label">{lang mkey='label' skey='location'}: </label></td>
      <td>
<table width="100%">
<tr>
  <td>{lang mkey='label' skey='country'}:</td>
  <td>
    <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
      {html_options options=$country selected=$smarty.session.loc.country}
    </select>
  </td>
</tr>

<tr>
  <td><label>{lang mkey='label' skey='state'}: </label></td>
  <td><div id="stateprovince_auto">
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
  <td><label>{lang mkey='label' skey='county'} : </label></td>
  <td>
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
</tr>

<tr>
  <td><label>{lang mkey='label' skey='city'}: </label></td>
  <td>
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

<tr>
  <td></td>
  <td></td>
</tr>

</table>
        <div class="clear">&nbsp;</div>
      </td>
      <td>&nbsp;</td>
    </tr>
    
    
    
    <tr>
      <td>&nbsp;</td>
      <td><label class="label">{lang mkey='label' skey='DesiredSalary'}: </label></td>
      <td>
        <select name='txt_salary' class="select">
            <option value="">{lang mkey='select_text'}</option>
            {html_options options=$salary selected=$smarty.session.resume.salary}
        </select>      
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="bt_search" value=" {lang mkey='button' skey='search'} " class="button" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
 </table>   
</form>