{if $message != "" } <br />{$message}<br /> {/if}

<form action="https://{$PAYPAL_SERVER}/cgi-bin/webscr" name="form1" method="post" target="_parent">
<center>PayPal accepts: Visa, Mastercard</center>
  <input type="hidden" value="_xclick" name="cmd">
  <input type="hidden" value="{$PAYPAL_EMAIL}" name="business">
  
  <input type="hidden" value="{$PAYPAL_IPN_URL}" name="notify_url">
  <input type="hidden" value="{$PAYPAL_RETURN_URL}" name="return">
  <input type="hidden" value="{$PAYPAL_CANCEL_RETURN}" name="cancel_return"/>
  
  <input type="hidden" value="{$package_invoice->item_name}" name="item_name">
  <input type="hidden" value="{$package_invoice->amount}" name="amount">
  <input type="hidden" value="{$package_invoice->id}" name="item_number">
  <input type="hidden" value="2" name="custom">
  <input type="hidden" value="default" name="page_style">
 
  <input type="hidden" value="1" name="no_shipping"/>
  <input type="hidden" value="1" name="no_note"/>
  <input type="hidden" value="{$PAYPAL_CURRENCY_CODE}" name="currency_code">
  <p align="center">

  <input target="_parent" type="image" alt="Make payments with PayPal - it's fast, free and secure!" 
  src="https://www.paypal.com/en_US/i/btn/x-click-but6.gif" border="0" name="submit" >
  </p>
</form>

    
{literal}     
<!-- automatically submit the payment button -->
<script language="javascript">
  function js_submit_payment() {
      document.forms[0].submit();
  }
  window.onload = js_submit_payment;
</script>
{/literal} 