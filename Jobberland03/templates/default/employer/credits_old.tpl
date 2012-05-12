{if $message != "" } <br />{$message}<br /> {/if}

<table width="100%">
<colgroup>
  <col width="49%"/>
  <col width="49%" />
</colgroup>
    <tr>
        <td valign="top">
         <form method="post" action="{$BASE_URL}employer/order/?action=post">
           
           {if $standard_credits }
            <div class="header">Order Standard Ads</div>
            <div class='border_div'>
                <p>Select an option to place an order.</p>
               
                    <table class="order_table" border="0" cellpadding="5" cellspacing="1">
                      <tr>
                        <td class="order_col_head">Option</td>
                        <td class="order_col_head">Quantity</td>
                        <td class="order_col_head">Price</td>
                      </tr>
                {foreach from=$standard_credits key=k item=i}
                      <tr>
                        <td class="order_col_data">
                          <input type="radio" name="package_id" value="{$i.id}" />{$i.package_name}
                        </td>
                        <td class="order_col_data">{$i.package_job_qty}</td>
                        <td class="order_col_data">{lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME } {$i.package_price} {$CURRENCY_NAME}</td>
                      </tr>
                {/foreach}
                </table>
                   <br />
                   &nbsp; &nbsp; &nbsp; &nbsp;<input class="form_submit_button button" value="Place Order &gt;&gt;" type="submit" >    
                <br />
         </div>
         {/if} 
         
         {if $spotlight_credits }
         <br /><hr /><br />

         <h1 class="header">Order Spotlight Ads</h1>
            <div class='border_div'>
            	Make your ad stand out above the rest.
                <p>Select an option to place an order.</p>
                    <table class="order_table" border="0" cellpadding="5" cellspacing="1">
                      <tr>
                        <td class="order_col_head">Option</td>
                        <td class="order_col_head">Quantity</td>
                        <td class="order_col_head">Price</td>
                      </tr>
                {foreach from=$spotlight_credits key=k item=i}
                      <tr>
                        <td class="order_col_data">
                        <input type="radio" name="package_id" value="{$i.id}" />{$i.package_name}
                        </td>
                        <td class="order_col_data">{$i.package_job_qty}</td>
                        <td class="order_col_data">{lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME } {$i.package_price} {$CURRENCY_NAME}</td>
                      </tr>
                {/foreach}
                </table>
                   &nbsp; &nbsp; &nbsp; &nbsp;<input class="form_submit_button button" value="Place Order &gt;&gt;" type="submit" >    
                <br />
         </div>
         {/if}
         
         {if $cv_credits }
         <br /><hr /><br />

         <h1 class="header">Order CV Views Credits </h1>
            <div class='border_div'>
            	Make your ad stand out above the rest.
                <p>Select an option to place an order.</p>
                    <table class="order_table" border="0" cellpadding="5" cellspacing="1">
                      <tr>
                        <td class="order_col_head">Option</td>
                        <td class="order_col_head">Quantity</td>
                        <td class="order_col_head">Price</td>
                      </tr>
                {foreach from=$cv_credits key=k item=i}
                      <tr>
                        <td class="order_col_data">
                        <input type="radio" name="package_id" value="{$i.id}" />{$i.package_name}
                        </td>
                        <td class="order_col_data">{$i.package_job_qty}</td>
                        <td class="order_col_data">{lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME } {$i.package_price} {$CURRENCY_NAME}</td>
                      </tr>
                {/foreach}
                </table>
                   &nbsp; &nbsp; &nbsp; &nbsp;<input class="form_submit_button button" value="Place Order &gt;&gt;" type="submit" >    
                
                <br />
         </div>
         {/if}
         </form>
         
        </td>
        <td  valign="top">
        <div class="header">Posting Credit Balance</div>
        <div class='border_div'>
        	<strong>Posts Remaining: </strong>{$total_post}
			<br /><strong>Spotlight Posts Remaining:</strong> {$total_spotlight_post}
            <br /><strong>CV Remaining:</strong> {$total_cv}
            <br /><br />
        </div>
        
        <div class="clear">&nbsp;</div>
		{if $recent_orders }
        <div class="page_header">Recent Orders</div>
        <div class="noborder_div">
        
        <table class="order_table" border="0" cellpadding="5" cellspacing="1">
         <tr>
           <td class="order_col_head">Date</td>
           <td class="order_col_head">ID</td>
           <td class="order_col_head">Item</td>
           <td class="order_col_head">Status</td>
           <td class="order_col_head">Amount</td>
         </tr>
         {foreach from=$recent_orders key=k item=i}
         <tr>
           <td class="order_col_data">{$i.invoice_date}</td>
           <td class="order_col_data">#{$i.id}</td>
           <td class="order_col_data">{$i.item_name}</td>
           <td class="order_col_data">
             { if $i.package_status == "Confirmed" || $i.package_status == "Selected" }
				{$i.package_status}
				<br /><a href='{$BASE_URL}employer/order/?action=post&amp;package_id={$i.package_id}'> Confirm </a>
				{else}
                {$i.package_status}
			{/if}
           </td>
           <td class="order_col_data">{lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME } {$i.amount} {$CURRENCY_NAME}</td>
         </tr>
         {/foreach}
        </table>
        </div>
        {else}
        	<div class="error">No history found</div>
        {/if}
        <a href="{$BASE_URL}employer/payment_history/">Payment History</a>
        </td>
    </tr>
</table>
