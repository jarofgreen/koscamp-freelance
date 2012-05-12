<div style="border:solid 1px #000; padding:5px;" class="round">

<br />
<div class="success">
  <span style="color:#F90; font-weight:bold; font-size:14px;">{lang mkey="success" skey='apply_for' }</span><br /> 
  <span style="color:#003;">{$apply_for}</span>
</div>

<br /><br />

{* if $message != "" } {$message} {/if *}

{if $job_suggestion && is_array($job_suggestion) }

<h3>{lang mkey="apply_suggestion" skey='info'}::</h3>

<table width="100%" cellpadding="2" cellspacing="2">

{foreach from=$job_suggestion key=k item=i}

  <tr>
    <td></td>
    <td>
      <a href="{$BASE_URL}job/{$i.var_name}/">{$i.job_title}</a>
      <br />{$i.company_name}
    </td>
    <td>{lang mkey="label"  skey='posted'}: {$i.created_at}</td>
    <td>{$i.location}</td>
  </tr>
  
{/foreach}

</table>

<br />

{/if}

</div>