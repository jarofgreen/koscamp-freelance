<div>
 <input type="radio" value="free" name="payment_method" />{lang mkey='label' skey='freePaymentmethod'}
</div>
{foreach from=$payment_modules key=k item=i}
  <div>
  <input type="radio" value="{$i.module_key}" name="payment_method" /> {$i.name}
  </div>
  
{/foreach}