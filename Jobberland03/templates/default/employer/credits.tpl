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
            <div class="header">{lang mkey='header' skey='OrderStdAds'}</div>
            <div class='border_div'>
                <p>{lang mkey='order' skey='select_op'}</p>
               
                    <table class="order_table" border="0" cellpadding="5" cellspacing="1">
                      <tr>
                        <td class="order_col_head">{lang mkey='label' skey='Option'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='Quantity'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='Price'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='packageInclude'}</td>

                      </tr>
                {foreach from=$standard_credits key=k item=i}
                      <tr>
                        <td class="order_col_data">
                          <input type="radio" name="package_id" value="{$i.id}" />{$i.package_name}
                        </td>
                        <td class="order_col_data">{$i.package_job_qty}</td>
                        <td class="order_col_data">{lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME } {$i.package_price} {$CURRENCY_NAME}</td>
                        <td class="order_col_data">
                {if $i.standard == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                		{lang mkey='label' skey='Standardpost'} <br />{/if}
                {if $i.spotlight == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                		{lang mkey='label' skey='Spotlightpost'}<br /> {/if}
                {if $i.cv_views == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                  {lang mkey='label' skey='CVView'} <br />{/if} 

                        </td>
                      </tr>
                {/foreach}
                </table>
                   <br />
                   &nbsp; &nbsp; &nbsp; &nbsp;<input class="form_submit_button button" value="{lang mkey='button' skey='PlaceOrder'} &gt;&gt;" type="submit" >    
                <br />
         </div>
           <br /><hr /><br />
           
         {/if} 
         
         {if $spotlight_credits }

         <h1 class="header">{lang mkey='header' skey='OrderSpotAds'}</h1>
            <div class='border_div'>
            	{lang mkey='order' skey='ad_stand_out'}
                <p>{lang mkey='order' skey='select_op'}</p>
                    <table class="order_table" border="0" cellpadding="5" cellspacing="1">
                      <tr>
                        <td class="order_col_head">{lang mkey='label' skey='Option'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='Quantity'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='Price'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='packageInclude'}</td>
                      </tr>
                {foreach from=$spotlight_credits key=k item=i}
                      <tr>
                        <td class="order_col_data">
                        <input type="radio" name="package_id" value="{$i.id}" />{$i.package_name}
                        </td>
                        <td class="order_col_data">{$i.package_job_qty}</td>
                        <td class="order_col_data">{lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME } {$i.package_price} {$CURRENCY_NAME}</td>
                        <td class="order_col_data">
                {if $i.standard == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                		{lang mkey='label' skey='Standardpost'} <br />{/if}
                {if $i.spotlight == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                		{lang mkey='label' skey='Spotlightpost'}<br /> {/if}
                {if $i.cv_views == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                  {lang mkey='label' skey='CVView'} <br />{/if} 

                        </td>
                      </tr>
                {/foreach}
                </table>
                   &nbsp; &nbsp; &nbsp; &nbsp;<input class="form_submit_button button" value="{lang mkey='button' skey='PlaceOrder'} &gt;&gt;" type="submit" >    
                <br />
         </div>
 
          <br /><hr /><br />

         {/if}
         
         {if $cv_credits }

         <h1 class="header">{lang mkey='header' skey='OrderCVViCr'} </h1>
            <div class='border_div'>
                <p>{lang mkey='order' skey='select_op'}</p>
                    <table class="order_table" border="0" cellpadding="5" cellspacing="1">
                      <tr>
                        <td class="order_col_head">{lang mkey='label' skey='Option'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='Quantity'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='Price'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='packageInclude'}</td>
                      </tr>
                {foreach from=$cv_credits key=k item=i}
                      <tr>
                        <td class="order_col_data">
                        <input type="radio" name="package_id" value="{$i.id}" />{$i.package_name}
                        </td>
                        <td class="order_col_data">{$i.package_job_qty}</td>
                        <td class="order_col_data">{lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME } {$i.package_price} {$CURRENCY_NAME}</td>
                        <td class="order_col_data">
                {if $i.standard == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                		{lang mkey='label' skey='Standardpost'} <br />{/if}
                {if $i.spotlight == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                		{lang mkey='label' skey='Spotlightpost'}<br /> {/if}
                {if $i.cv_views == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                  {lang mkey='label' skey='CVView'} <br />{/if} 

                        </td>
                      </tr>
                {/foreach}
                </table>
                   &nbsp; &nbsp; &nbsp; &nbsp;<input class="form_submit_button button" value="{lang mkey='button' skey='PlaceOrder'} &gt;&gt;" type="submit" >    
                
                <br />
         </div>
         <br /><hr /><br />

         {/if}

         {if $combination_credits }

         <h1 class="header">{lang mkey='header' skey='OrderComCr'} </h1>
            <div class='border_div'>
                <p>{lang mkey='order' skey='select_op'}</p>
                    <table class="order_table" border="0" cellpadding="5" cellspacing="1">
                      <tr>
                        <td class="order_col_head">{lang mkey='label' skey='Option'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='Quantity'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='Price'}</td>
                        <td class="order_col_head">{lang mkey='label' skey='packageInclude'}</td>
                      </tr>
                {foreach from=$combination_credits key=k item=i}
                      <tr>
                        <td class="order_col_data">
                        <input type="radio" name="package_id" value="{$i.id}" />{$i.package_name}
                        </td>
                        <td class="order_col_data">{$i.package_job_qty}</td>
                        <td class="order_col_data">{lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME } {$i.package_price} {$CURRENCY_NAME}</td>
                        <td class="order_col_data">

                {if $i.standard == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                		{lang mkey='label' skey='Standardpost'} <br />{/if}
                {if $i.spotlight == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                		{lang mkey='label' skey='Spotlightpost'}<br /> {/if}
                {if $i.cv_views == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                  {lang mkey='label' skey='CVView'} <br />{/if} 


                        </td>
                        
                      </tr>
                {/foreach}
                </table>
                   &nbsp; &nbsp; &nbsp; &nbsp;<input class="form_submit_button button" value="{lang mkey='button' skey='PlaceOrder'} &gt;&gt;" type="submit" >    
                
                <br />
         </div>
         {/if}
        
         </form>
         
        </td>
        <td  valign="top">
        <div class="header">{lang mkey='header' skey='PostCrBal'}</div>
        <div class='border_div'>
        	<strong>{lang mkey='label' skey='postRemain'}: </strong>{$total_post}
			<br /><strong>{lang mkey='label' skey='SpotPostRemain'}:</strong> {$total_spotlight_post}
            <br /><strong>{lang mkey='label' skey='CVRemain'}:</strong> {$total_cv}
            <br /><br />
        </div>
        
        <div class="clear">&nbsp;</div>
		{if $recent_orders }
        <div class="page_header">{lang mkey='header' skey='RecentOrders'}</div>
        <div class="noborder_div">
        
        <table class="order_table" border="0" cellpadding="5" cellspacing="1">
         <tr>
           <td class="order_col_head">{lang mkey='label' skey='Date'}</td>
           <td class="order_col_head">{lang mkey='label' skey='id'}</td>
           <td class="order_col_head">{lang mkey='label' skey='Item'}</td>
           <td class="order_col_head">{lang mkey='label' skey='Status'}</td>
           <td class="order_col_head">{lang mkey='label' skey='Amount'}</td>
         </tr>
         {foreach from=$recent_orders key=k item=i}
         <tr>
           <td class="order_col_data">{$i.invoice_date}</td>
           <td class="order_col_data">#{$i.id}</td>
           <td class="order_col_data">{$i.item_name}</td>
           <td class="order_col_data">
             { if $i.package_status == "Confirmed" || $i.package_status == "Selected" }
				{$i.package_status}
				<br /><a href='{$BASE_URL}employer/order/?action=post&amp;package_id={$i.package_id}'>
                	{lang mkey='button' skey='confirm'} </a>
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
        	<div class="error">{lang mey='errormsg' skey=65}</div>
        {/if}
        <a href="{$BASE_URL}employer/payment_history/">{lang mkey='e_link' skey='PaymentHistory'}</a>
        </td>
    </tr>
</table>
