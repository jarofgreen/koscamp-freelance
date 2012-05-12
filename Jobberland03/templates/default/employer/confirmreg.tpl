<h1 class="header">{lang mkey='header' skey='confirm_reg'}</h1>

{if $message != "" } <br />{$message} {/if}
<p>{lang mkey='confirm_reg' skey='1'}</p>
<center>
{lang mkey='or'}
</center>

<p>{lang mkey='confirm_reg' skey='2'}</p>

<form action="" method="post" name="confirm_reg">
    <input type="text" name="txtconfcode" size="35" class="" />
<input type="submit" name="bt_confirm" value="{lang mkey='button' skey='confirm_reg'}" class="button" />
</form>

