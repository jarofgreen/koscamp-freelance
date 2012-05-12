<div class="page_header">Packages Plan</div>
<br />

{if $message != "" } {$message} {/if}

{if $packages != '' }
  <table width="100%" cellpadding="5" cellspacing="1" class="tb_table" >
    <colgroup>
      <col width="20%" />
      <col width="35%" />
      <col width="10%" />
      <col width="10%" />
      <col width="10%" />
      <col width="10%" />
      <col width="5%" />
    </colgroup>
   <tr>
        <td class="tb_col_head"><label class='label'>Name </label></td>
        <td class="tb_col_head"><label class='label'>Description </label></td>
        <td class="tb_col_head"><label class='label'>Qty </label></td>
        <td class="tb_col_head"><label class='label'>Price </label></td>
        <td class="tb_col_head"><label class='label'>Spotlight </label></td>
        <td class="tb_col_head"><label class='label'>CV Views </label></td>
        <td class="tb_col_head"><label class='label'>Is Active </label></td>
        <td colspan="2"  class="tb_col_head"><label class='label'>Action </label></td>
   </tr>
        {foreach from=$packages key=k item=i}
   <tr class="list_shade">
        <td>{$i->package_name}</td>
        <td>{$i->package_desc}</td>
        <td>{$i->package_job_qty}</td>
        <td>{lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME } {$i->package_price}</td>
        <td>{$i->spotlight}</td>
        <td>{$i->cv_views}</td>
        <td>{$i->is_active}</td>
        <td>
            <a href="edit_package.php?id={$i->id}"><img src="{$skin_images_path}edit.png" alt="Edit" /></a>
        </td>
        <td>
            <a href="?action=delete&amp;id={$i->id}"><img src="{$skin_images_path}delete.png" alt="Delete" /></a>
        </td>
   </tr>

{/foreach}
</table>
{/if}