<fieldset class="fieldset round">
<form action="{$BASE_URL}search/" method="get" name="search_form" id="search_form">
<table border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td> <span class="label"> {lang mkey='label' skey='enter_keyword'} </span> </td>
    <td>
      <input type="text" size="40" name="q" id="q" class="search_text_bx" value="{$q}" />
      <br />
      <input type="radio" name="search_in" value="1" {if $search_in == 1} checked="checked" {/if} />  {lang mkey='label' skey='title_desc'} 
      <input type="radio" name="search_in" value="2" {if $search_in == 2} checked="checked" {/if} /> {lang mkey='label' skey='titleonly'} 
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> <span class="label">{lang mkey='label' skey='search_loc'}</span> </td>
    <td colspan="4">
      <input type="text" name="location" size="40" value="{$city_id}" />
       &nbsp; &nbsp; &nbsp;
       <select name="txt_country" id="txt_country">
            {html_options options=$country selected=$smarty.session.loc.country}
        </select>
        
    </td>
    </tr>
  
  <tr valign="top">
    <td> <span class="label"> {lang mkey='label' skey='search_cat'} </span> </td>
    <td>
        <a href="#" id="jquery_select_category">{lang mkey='link' skey='select_cat'}</a>
        
        <div id="jquery_search_cat">
            <div id="jquery_selecting_cat">&nbsp;<br />&nbsp;</div>
            <div style='overflow:auto; height:100px; width:100%; border:1px solid #404040; display:block;'>
                {html_checkboxes id='category' name='category' options=$category selected=$category_selected separator='<br />'}
            </div>
        </div>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> <span class="label"> {lang mkey='label' skey='search_type'} </span> </td>
    <td colspan="3">
    	<select name="job_type" class="search_text_bx">
        	{html_options options=$job_type selected=$job_type_selected}
        </select>
        
    	{lang mkey='label' skey='home_within'} 
        <select name="within" class="search_text_bx" >
        	<option></option>
            <option>7</option>
            <option>6</option>
            <option>5</option>
            <option>4</option>
            <option>3</option>
            <option>2</option>
            <option>1</option>
            <option>0</option>
        </select>
	{lang mkey='label' skey='home_days'}
    	<select name="order_by" class="search_text_bx" >
        	<option value="1">Best Match</option>
            <option value="0">Date</option>
        </select>
    </td>
    <td><input type="submit" name="search_bt" value=" {lang mkey='button' skey='search' } " class="button" /></td>
  </tr>
  
  <tr>
    <td><span class="label"></span> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

</fieldset>

{if $did_you_mean_name != '' }
 {lang mkey='do_you_mean'} <a href="?{if $query != '' }{$query}&amp;location={$did_you_mean_name}{else}location={$did_you_mean_name}{/if}">{$did_you_mean_name}</a>
{/if}