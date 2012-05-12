{if $message != "" } {$message} {/if} 

<form action="" method="post" >
<input type="hidden" name="id" value="{$id}" />
<table width="100%" cellpadding="1" cellspacing="2">
  <colgroup>
    <col width="30%">
    
  </colgroup>
    <tr>
      <td>Module Name</td>
      <td>Action</td>
    </tr>

{foreach from=$payment_modules key=k item=i}
    <tr>
      <td class="bold">{$i.name}: </td>
      <td>
        {if $i.enabled == 'Y' }
         <a href="payment_edit.php?payment={$i.module_key}&amp;id={$i.id}">Edit</a> | 
         <a href="?remove={$i.module_key}">Uninstall</a>
        {else}
          <a href="?install={$i.module_key}">Install</a>
        {/if}
      </td>
    </tr>
{/foreach}

    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>

        