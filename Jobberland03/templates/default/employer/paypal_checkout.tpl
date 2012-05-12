{strip}
<h3>{lang mkey='header' skey='confirm_order'}</h3>

{*paypal_checkout.tpl*}
{if $run_mode == 'test'}
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
{else}
<form action="https://secure.paypal.com/cgi-bin/webscr" method="post">
{/if}
	<input type="hidden" name="cmd" value="_xclick" />
	<input type="hidden" name="add" value="1" />
	<input type="hidden" name="rm" value="2" />
	<input type="hidden" name="business" value="{$email}" />
	<input type="hidden" name="pay_mod" value="paypal" />
  	<input type="hidden" name="return" value="{$BASE_URL}employer/checkout_process/?payment_from=paypal&amp;invoice_id={$invoice_id}" />
	{* used by checkout_process.php to validate order *}
    
    <input type="hidden" value="{$p_invoice->item_name}" name="item_name">
    <input type="hidden" value="{$p_invoice->amount}" name="amount">
    <input type="hidden" value="{$p_invoice->id}" name="item_number">
    
  	<input type="hidden" name="user_id" value="{$user_id}" />
    <input type="hidden" name="user_id2" value="{$user_id}" />
    <input type="hidden" name="user_id3" value="{$user_id}" />
    
	{*<input type="hidden" name="user_level" value="{$item_no}" />*}
    
	<input type="hidden" name="no_shipping" value="1" />
  	<input type="hidden" name="cancel_return" value="{$BASE_URL}employer/checkout_process/?payment_c=1&amp;invoice_id={$invoice_id}" />
  	<input type="hidden" name="notify_url" value="{$BASE_URL}modules/payment/paypal_api.php" />
	<input type="hidden" name="no_note" value="1" />
	<input type="hidden" name="currency_code" value="{$CURRENCY_NAME}" />
    
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
