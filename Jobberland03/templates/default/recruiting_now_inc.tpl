{if is_array ($recruiting_nows) && $recruiting_nows != "" }
<div class="left_item">
<h1 class="header">{lang mkey='header' skey='recruiting_now'}</h1>
<table width="100%" class="tb_border">
    {foreach from=$recruiting_nows key=k item=i}
    <tr>
        <td>
            <a href='{$BASE_URL}company/{$i.var_name}/'>
              <img src="{$BASE_URL}images/company_logo/{$i.logo}" alt="{$i.name}" class="companylogo" title="{$i.name} ({$i.total})" />
            </a>
        </td>
    </tr>
    {/foreach}
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
</div>
{/if}
