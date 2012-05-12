
<div class="header">
    {$cat_name}
</div>

<form method="get" action="" name="frm1">
<table border=0>
 <tr>
  <td>Settings Group: </td>
  <td>
   <select name="id" onchange="javascript: document.frm1.submit();">
        {foreach from=$cat_settings key=k item=i}
           <option value="{$i.id}" {if $id == $i.id} selected="selected" {/if} > {$i.category_name}</option>
        {/foreach}
   </select>
        </td>
    </tr>
</table>
</form>

<p>
	<strong>Description: </strong>
	{$cat_description}
</p>
<br />
      
	{if $message != "" } {$message} {/if} 
    
		<form action="" method="post" >
        <input type="hidden" name="id" value="{$id}" />
        <table width="100%" id="setting">
        {foreach from=$site_setting key=k item=i}
			<tr>
              <td class="bold">{$i.title}: </td>
              <td>{$i.input}
              <br />{$i.description}</td>
            </tr>
		{/foreach}
        
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
        	<tr>
            	<td>&nbsp;</td>
            	<td><input type="submit" name="add" value="Update" /></td>
            </tr>
        </table>
        
        </form>    
