
<div class="header"></div>
<br />
	{if $message != "" } {$message} {/if} 
    
<form action="" method="post" >
<input type="hidden" name="id" value="{$id}" />
<table width="100%">

{foreach from=$pluginconfig key=k item=i}
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
