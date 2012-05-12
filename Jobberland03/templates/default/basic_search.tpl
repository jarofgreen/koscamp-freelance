<fieldset class="fieldset round">
<form action="{$BASE_URL}search/" method="get" name="search_form" id="search_form">

<table border="0" cellspacing="0" cellpadding="0">
  <tr valign="top">
   <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr valign="top">
    <td><span class="label"> {lang mkey='label' skey='enter_keyword'}&nbsp;:&nbsp;</span></td>
    <td>
      <input type="text" size="40" name="q" id="q" value="{$q}" />
      <input type="hidden" name="search_in" value="1" />
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="label">{lang mkey='label' skey='search_loc'}&nbsp;: </span> </td>
    <td>
    	<input type="text" name="location" size="40" value="{$city_id}" /></td>
    <td>
       &nbsp; &nbsp; &nbsp;
       <select name="txt_country" id="txt_country">
            {html_options options=$country selected=$smarty.session.loc.country}
        </select>
        
      &nbsp;
    </td>
  </tr>
  <tr valign="top">
   <td>&nbsp;</td>
    <td>
    
    <input type="submit" name="search_bt" value=" {lang mkey='button' skey='search' } " class="button" />
    <a href="{$BASE_URL}advance_search/">Advanced Search</a>   
    </td>
    <td>&nbsp;</td>
  </tr>
  
</table>
</form>

</fieldset>

{if $did_you_mean_name != '' }
 {lang mkey='do_you_mean'} <a href="?{if $query != '' }{$query}&amp;location={$did_you_mean_name}{else}location={$did_you_mean_name}{/if}">{$did_you_mean_name}</a>
{/if}