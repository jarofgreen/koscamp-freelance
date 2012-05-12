
<h1 class="page_header"> Plugin </h1>

{if $message != "" } {$message} {/if} 

{if $plugins && is_array($plugins) }
{*<form action="" method="post" >*}
<table width="100%" cellpadding="5" cellspacing="1">
  <tr>
    <td  class="tb_col_head">ID</td>
    <td class="tb_col_head">Plugin Name</td>
    <td class="tb_col_head">Enable</td>
    <td class="tb_col_head">Action</td>
  </tr>

{foreach from=$plugins key=k item=i}
  <tr>
    <td>{$i.id}</td>
    <td>{$i.plugin_name}</td>
    <td>{$i.enabled}</td>
    <td>
      {if $i.enabled == 'Y' }
      <a href="{$BASE_URL}admin/plugin_edit.php?id={$i.id}">{lang mkey='edit'}</a> | 
        <a href="?id={$i.id}&amp;action=uninstall">{lang mkey='uninstall'}</a>
      {else}
        <a href="?id={$i.id}&amp;action=install">{lang mkey='install'}</a>
      {/if}
    </td>
  </tr>
{/foreach}

</table>
{*</form>*}

{else}
	No plugin(s) found
{/if}