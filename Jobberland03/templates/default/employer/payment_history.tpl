{if $recent_orders}

<div class="header">{lang mkey='header' skey='PaymentHistory'}</div>
<div class="noborder_div">

<table class="order_table" border="0" cellpadding="5" cellspacing="1">
 <tr>
   <td class="order_col_head">{lang mkey='label' skey='InvoiceDate'}</td>
   <td class="order_col_head">{lang mkey='label' skey='PaymentDate'}</td>
   <td class="order_col_head">{lang mkey='label' skey='id'}</td>
   <td class="order_col_head">{lang mkey='label' skey='Item'}</td>
   <td class="order_col_head">{lang mkey='label' skey='Description'}</td>
   <td class="order_col_head">{lang mkey='label' skey='Qty'}</td>
   <td class="order_col_head">{lang mkey='label' skey='PackageInclude'}</td>
   <td class="order_col_head">{lang mkey='label' skey='Status'}</td>
   <td class="order_col_head">{lang mkey='label' skey='Amount'}</td>
 </tr>
 {foreach from=$recent_orders key=k item=i}
 <tr>
   <td class="order_col_data">{$i.invoice_date}</td>
   <td class="order_col_data">{$i.processed_date}</td>
   <td class="order_col_data">#{$i.id}</td>
   <td class="order_col_data"><a href="{$BASE_URL}employer/invoice/{$i.id}/">{$i.item_name}</a></td>
   <td class="order_col_data">{$i.package_desc}</td>
   <td class="order_col_data">#{$i.posts_quantity}</td>
   <td class="order_col_data">

        {if $i.standard == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                {lang mkey='label' skey='Standardpost'} <br />{/if}
        {if $i.spotlight == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                {lang mkey='label' skey='Spotlightpost'}<br /> {/if}
        {if $i.cv_views == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
          {lang mkey='label' skey='CVView'} <br />{/if} 
      
   </td>
   
   
   
   <td class="order_col_data">
	{ if $i.package_status == "Confirmed" || $i.package_status == "Selected" }
        {$i.package_status}
        <br /><a href='{$BASE_URL}employer/order/?action=post&amp;package_id={$i.package_id}'> {lang mkey='button' skey='confirm'} </a>
        {else}
        {$i.package_status}
    {/if}
   </td>
   <td class="order_col_data">{lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME } {$i.amount} {$CURRENCY_NAME} </td>
 </tr>
 {/foreach}
</table>

</div>
{else}
   no orders
{/if}