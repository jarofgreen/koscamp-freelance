{if $mySingleCV }

<div class="header">{lang mkey='header' skey='my_cv'}</div>

<table width="100%" style="border:1px solid #CCC;" cellpadding="5" cellspacing="2">

<tr>
  <td colspan="2"><a href="{$BASE_URL}curriculum_vitae/resume/{$cvid}/change/">{$cv_title}</a></td>
</tr>

<tr>
  <td><strong>{lang mkey='label' skey='ac_status'}: </strong></td>
  <td>{$cv_status|upper}{*capitalize*}</td>
</tr>

<tr>
  <td><strong>{lang mkey='label' skey='employerViews'}: </strong></td>
  <td>{$cvno_views}</td>
</tr>

<tr>
  <td><strong>{lang mkey='label' skey='last_modified'}: </strong></td>
  <td>{$cvmodified_at}</td>
</tr>

</table>

<div style="float:right; padding-right:10px;">
  <a href="{$BASE_URL}curriculum_vitae/">{lang mkey="label" skey='manageCV'}</a>
</div>

{else}
	
  {if $my_cvs && is_array($my_cvs) }
	<div class="header">{lang mkey='header' skey='my_cv'}</div>
  
    <div style="background:#999; padding-top:5px;">
    {foreach from=$my_cvs key=k item=i}
	   
       <div style="border:5px solid #CCC; background:#FFF; padding:5px; width:90%; margin:0 auto; margin-bottom:5px;">
        
        <a href="{$BASE_URL}curriculum_vitae/resume/{$i.id}/change/">{$i.cv_title}</a>
        <br />{$i.cv_status|upper}
        
       </div>
    {/foreach}
    
     <div style=" padding:10px; clear:both;">
  	  <a href="{$BASE_URL}curriculum_vitae/">{lang mkey="label" skey='manageCV'}</a>
	 </div>
     
    </div>
    
   {else}
   
   	 <p>
        {lang mkey='cv' skey='cv_info_3'} <a href="{$BASE_URL}curriculum_vitae/add/">{lang mkey='account' skey='link_new_cv' }</a>
     </p>
   {/if}
    
{/if}