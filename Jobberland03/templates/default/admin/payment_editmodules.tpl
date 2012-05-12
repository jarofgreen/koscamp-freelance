<div class="header">{$page_title}</div>

{if $message != "" } {$message} {/if} 

<form action="" method="post" >

{foreach from=$payment_editmodules key=k item=i}
 <div>
   <strong>{$i.title}</strong><br />
   {$i.input}
   <br />
   {$i.configuration_description}<br /><br />
 </div>
{/foreach}

<div> <input type="submit" name="bt_update" value=" Update " /></div>

</form>

        