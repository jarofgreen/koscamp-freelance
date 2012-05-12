<div class="header">{lang mkey='header' skey='confirmation'}</div>
<div id="job_details">
	{if $message != "" } {$message} {/if}
    <p>
    <strong>{lang mkey='label' skey='delete_confirm'}</strong>
    </p>
    <form action="" method="post" onsubmit="{*if ( !confirm('Are you sure you wont to delete your account?') ) return false;*}">
       <input name="bt_delete_yes" type="submit" id="bt_cmd" value="{lang mkey='button' skey='yes'}" class="button" />
       <input name="bt_delete_no" type="submit" id="bt_cmd" value="{lang mkey='button' skey='no'}" class="button" />
    </form>
    <br /><br /><br />
</div>