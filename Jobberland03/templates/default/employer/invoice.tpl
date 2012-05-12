<?xml version="1.0" encoding="{lang mkey='ENCODING'}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={lang mkey='ENCODING'}" />
{strip}

<title>{$html_title}</title>
<meta name="description" content="{$meta_description}" />
<meta name="keywords" content="{$meta_keywords}" />
<script language="javascript" type="text/javascript" src="{$DOC_ROOT}javascript/java.js"></script>

<link href="{$css_path}/employer/invoice.css" type="text/css" media="screen" rel="stylesheet"/>

</head>

<body dir="{lang mkey='DIRECTION'}">

<div id="print_invoice">
<table id="invoice_tb" border="0" align="center">

  <tr>
    <td>&nbsp;</td>
    <td>
      	
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <colgroup>
            <col width="50%" />
            <col width="50%" />
          </colgroup>
          <tr>
            <td><img src="{$BASE_URL}{$SITE_LOGO}" width="150" alt="Site Logo" /></td>
            <td>
              <span class="{if $success} payment_status_success {else} payment_status_error{/if}">{$payment_status}</span>
              <br />{$payment_method}
              <br />{$payment_date}
            </td>
          </tr>
        </table>
        
        
        <!-- invoice details -->
        <br />
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<colgroup>
                <col width="33%" />
                <col width="33%" />
                <col width="33%" />
            </colgroup>
          <tr class="shade">
            <td style="padding: 5px;">
            	<span class="bold_underline">{lang mkey='label' skey='Invoice'} #</span><span class="bold"> {$invoice_no}</span></td>
            <td><span class="bold_underline">{lang mkey='label' skey='InvoiceDate'}:</span><span class="bold"> {$invoice_date}</span></td>
            <td><span class="bold_underline">{lang mkey='label' skey='PaymentDate'}:</span><span class="bold"> {$payment_date}</span></td>
          </tr>
          <tr>
            <td colspan="3">
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                    <col width="50%" />
                    <col width="50%" />
                </colgroup>
              <tr>
                <td class="items" valign="top">
                    <div class="address">
                        <span class="bold_underline">{lang mkey='label' skey='InvoiceTo'}</span>
                        <br />{$invoice_to}
                    </div>
                </td>
                <td class="items" valign="top">
                	<div class="address">
                        <span class="bold_underline">{lang mkey='label' skey='PaymentTo'}</span>
                        <br />{$payment_to}
                    </div>
                </td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
		
		<!-- item -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="80%" />
                <col width="20%" />
            </colgroup>
          <tr class="shade">
            <td colspan="2"><span class="bold">{lang mkey='label' skey='Item'}:</span></td>
          </tr>
          <tr class="light_shade">
            <td class="items">{lang mkey='label' skey='Description'}</td>
            <td class="items pay_right">{lang mkey='label' skey='Amount'}</td>
          </tr>
          <tr>
            <td class="items">
            	<span class="bold">{$qty} {$package_name}</span>
            	<br />{$description}</td>
            <td class="items pay_right">{$currency_symbol} {$amount} {$currency_name}</td>
          </tr>
          <tr class="light_shade">
            <td class="items"><div class="right">{lang mkey='label' skey='SubTotal'}:</div></td>
            <td class="items pay_right">{$currency_symbol} {$sub_total}</td>
          </tr>
          <tr class="light_shade">
            <td class="items"><div class="right">{lang mkey='label' skey='vat'}: </div></td>
            <td class="items pay_right">{$currency_symbol} {$vat_amount}</td>
          </tr>
          <tr class="light_shade">
            <td class="items"><div class="right">{lang mkey='label' skey='Total'}: </div></td>
            <td class="items pay_right"> {$currency_symbol} {$total_amount}</td>
          </tr>
        </table>
    	
        <br />
            
    </td>
    <td>&nbsp;
    </td>
  </tr>
</table>


</div>

<a href="{$BASE_URL}employer/payment_history/"> &laquo; {lang mkey='button' skey='Back'} </a>

</body>
</html>
{/strip}