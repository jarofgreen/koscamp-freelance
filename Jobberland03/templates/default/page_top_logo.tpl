<table border="0" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td>
      <div class="logo">
      	<a href="{$BASE_URL}">
        	<img src="{$BASE_URL}{$SITE_LOGO}" width="150" alt="Site Logo" />
        </a>
        	<br /><strong>{$SITE_SLOGAN}</strong>
      </div>
    </td>

    <td valign="top">
    
    
    	<div class="top_menu">
        {$loggin_user}
            <a href="{$BASE_URL}">{lang mkey='link' skey='home'}</a> | 
            {if isset($smarty.session.user_id) }
            <a href="{$BASE_URL}logout/">{lang mkey='link' skey='logout'}</a> | 
            {else}
            <a href="{$BASE_URL}login/">{lang mkey='link' skey='login'}</a> |  
            <a href="{$BASE_URL}register/">{lang mkey='link' skey='register'}</a> | 
            {/if}
            <a href="{$BASE_URL}page/security/">{lang mkey='link' skey='security'}</a> | 
            <a href="{$BASE_URL}page/help/">{lang mkey='link' skey='help'}</a>
    	</div>
            
          <table width="100%">
           <tr>
            <td>
            <div class="banner_460_60">
                    <!-- Banner (468 x 60) -->
{*
<script type="text/javascript"><!--
	google_ad_client = "pub-0275569008136140";
	/* 468x60, jobberland */
	google_ad_slot = "3631710105";
	google_ad_width = 468;
	google_ad_height = 60;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
*}
            </div>
            </td>
            <td>
            <div id="emp_link">
                <span>{lang mkey='label' skey='employer_site'}</span>
                <!-- Looking to hire?<br /> -->
                <br /><br /><a href="{$BASE_URL}employer/">{lang mkey='link' skey='employer'} &raquo;</a>
            </div>
            </td>
          </tr>
        </table>        
    </td>
  </tr>

</table>
