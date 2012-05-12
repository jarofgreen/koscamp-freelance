{strip}
<h3>{lang mkey='header' skey='confirm_order'}</h3>

<form action="https://www.moneybookers.com/app/payment.pl" method="post">

<input type="hidden" name="pay_to_email" value="{$email}">
<input type="hidden" name="transaction_id" value="{$transaction_id}">

<input type="hidden" name="return_url" 
value="{$BASE_URL}employer/checkout_process/?payment_from=moneybookers&amp;invoice_id={$invoice_id}">
<input type="hidden" name="return_url_text" value=" Return back to {$SITE_NAME}" >

<input type="hidden" name="cancel_url" value="{$BASE_URL}employer/checkout_process/?payment_c=1&amp;invoice_id={$invoice_id}" />

<input type="hidden" name="status_url" value="{$BASE_URL}modules/payment/moneybookers_api.php">
<input type="hidden" name="status_url2" value="mailto: mohammad.m4jid@gmail.com">

<input type="hidden" name="logo_url" value="{$BASE_URL}{$SITE_LOGO}">
<input type="hidden" name="currency" value="{$CURRENCY_NAME}" />

<input type="hidden" name="language" value="EN">

<input type="hidden" name="amount" value="{$p_invoice->amount}">
<input type="hidden" name="detail1_description" value="Description:">
<input type="hidden" name="detail1_text" value="{$p_invoice->item_name}">

{*<input type="hidden" value="{$p_invoice->id}" name="item_number">*}

<input type="hidden" name="confirmation_note" value="Samplemerchant wishes you pleasure reading your new book!">

<div style="padding:10px; border:2px solid #CCC; background:#F3F3F3;">
    <div><strong style="padding-right:79px;">{lang mkey='label' skey='order'} #:</strong> {$p_invoice->id} </div>	 
    <div><strong style="padding-right:20px;">{lang mkey='label' skey='order_description'}:</strong> {$p_invoice->item_name}</div>
    <div><strong style="padding-right:25px;">{lang mkey='label' skey='NumberofPosts'}:</strong> 	{$p_invoice->posts_quantity} </div>
    <div><strong style="padding-right:92px;">{lang mkey='label' skey='Price'}:</strong>
        {lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME }{$p_invoice->amount} {$CURRENCY_NAME}  </div>
    <div><strong>{lang mkey='label' skey='ProductType'}:</strong> 	
        <div style="padding-left:130px">
        {if $p_invoice->standard == 'Y'} <img src='{$DOC_ROOT}images/tick.gif' alt='' /> Standard post <br /> {/if}
        {if $p_invoice->spotlight == 'Y'}<img src='{$DOC_ROOT}images/tick.gif' alt='' /> Spotlight post<br /> {/if}
        {if $p_invoice->cv_views == 'Y'}<img src='{$DOC_ROOT}images/tick.gif' alt='' /> CV View <br /><br />{/if}
        </div>
    </div>
    <div><strong style="padding-right:85px;">{lang mkey='label' skey='Status'}:</strong> {$p_invoice->package_status}</div>
    <div><strong style="padding-right:30px;">{lang mkey='label' skey='PaymentMethod'}:</strong> {$p_invoice->payment_method}</div>
    
    <div style="padding:10px;">
	    <input type="submit" class="button" value="{lang mkey='button' skey='confirm'}" />
    </div>
</div>


</form>
{/strip}
