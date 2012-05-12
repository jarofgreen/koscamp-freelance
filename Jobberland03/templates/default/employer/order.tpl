<div class='border_div tb_border'>
<h3>{lang mkey='header' skey='confPaymentMethod'}</h3>

{if $message != "" } <br />{$message}<br /> {/if}

<form action="{$BASE_URL}employer/confirmation/" method="post">
    <input type="hidden" name="package_id" value="{$package_id}" />
    <input type="hidden" name="invoice_id" value="{$invoice_id}" />
    <input type="hidden" name="action" value="{$action}" />
    
    <table width="100%">
        <colgroup>
          <col width="5%" />
          <col width="20%" />
          <col width="75%" />
        </colgroup>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
{*
        <tr>
          <td><label class='label'>Order #: </label></td>
          <td>{$found_invoice->id}</td>
          <td rowspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td><label class='label'>Order Description: </label></td>
          <td>{$found_invoice->item_name}</td>
        </tr>
        <tr>
          <td><label class='label'>Number of Posts: </label></td>
          <td>{$found_invoice->posts_quantity}</td>
        </tr>
        <tr>
          <td><label class='label'>Price:  </label></td>
          <td>{lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME }{$found_invoice->amount} {$CURRENCY_NAME} </td>
        </tr>
        <tr>
          <td><label class='label'>Product Type: </label></td>
          <td>
          	{if $found_invoice->standard == 'Y'} <img src='{$DOC_ROOT}images/tick.gif' alt='' /> Standard post <br /> {/if}
            {if $found_invoice->spotlight == 'Y'}<img src='{$DOC_ROOT}images/tick.gif' alt='' /> Spotlight post<br /> {/if}
            {if $found_invoice->cv_views == 'Y'}<img src='{$DOC_ROOT}images/tick.gif' alt='' /> CV View <br /><br />{/if}

          </td>
          <td rowspan="4">
            <input type="submit" name="bt_confirm" value="Confirm" class="button" />
          </td>
        </tr>
        <tr>
          <td><label class='label'>Status: </label></td>
          <td>Selected</td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;<br /></td>
        </tr>
  *}      
        <tr>
          <td>&nbsp;</td>
          <td><label class='label'>{lang mkey='label' skey='AvPaymentMethod'}: </label></td>
          <td>{include file='employer/payment_method.tpl'}<br /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>
            <input type="submit" name="bt_confirm" value="{lang mkey='button' skey='confirm'}" class="button" />
          </td>
		</tr>
    
    </table>
    </form>
    </div>
