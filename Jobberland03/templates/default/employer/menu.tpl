<div class="menu bubplastic horizontal gray" id="menu_bar">

<ul id="navigation">
  <li><span class="menu_r"><a href="{$BASE_URL}employer/" target="_self">
    <span class="menu_ar">{lang mkey='link' skey='home'}</span></a></span></li>
 
{if $employer_logged_in != '' && isset($employer_logged_in) }
    <li><span class="menu_r"><a href="{$BASE_URL}logout/" target="_self">
       <span class="menu_ar">{lang mkey='link' skey='logout'}</span></a></span></li>
    <li><span class="menu_r"><a href="#" target="_self">
       <span class="menu_ar">{lang mkey='link' skey='PostManagejob'}<img src="{$skin_images_path}tab_divider1.gif" alt="" /></span></a></span>
        <ul class="horizontal_sub">
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/addjob/" target="_self">
               <span class="menu_ar2">{lang mkey='link' skey='Postnewjob'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/addjob/spotlight/" target="_self">
               <span class="menu_ar2">{lang mkey='link' skey='PostnewSpotlightjob'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/myjobs/" target="_self">
               <span class="menu_ar2">{lang mkey='link' skey='Managejob'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/search/" target="_self">
               <span class="menu_ar2">{lang mkey='link' skey='SearchCV'}</span></a></span></li>
        </ul>
    </li>
    
    <li><span class="menu_r"><a href="#" target="_self">
      <span class="menu_ar">{lang mkey='link' skey='my_account'}<img src="{$skin_images_path}tab_divider1.gif" alt="" /></span></a></span>
        <ul class="horizontal_sub">
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/account/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='my_details'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/account/change_password/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='change_passeword'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/payment_history/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='payment_history'}</span></a></span></li>
        </ul>
    </li>
    <li><span class="menu_r"><a href="{$BASE_URL}employer/credits/" target="_self"><span class="menu_ar">Buy Credits</li>
{else}

    <li><span class="menu_r"><a href="{$BASE_URL}employer/login/" target="_self">
       <span class="menu_ar">{lang mkey='link' skey='login'}</span></a></span></li>
    <li><span class="menu_r"><a href="{$BASE_URL}employer/register/" target="_self">
       <span class="menu_ar">{lang mkey='link' skey='register'}</span></a></span></li>
{/if}
        
    <li><span class="menu_r"><a href="{$BASE_URL}employer/services/" target="_self">
       <span class="menu_ar">{lang mkey='link' skey='products'}</span></a></span></li>
    <li><span class="menu_r"><a href="#" target="_self">
       <span class="menu_ar">{lang mkey='link' skey='help'}<img src="{$skin_images_path}tab_divider1.gif" alt="" /></span></a></span>
        <ul class="horizontal_sub">	
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/page/faq/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='faq'}</span></a></span></li>
            <!-- <li><span class="menu_r2"><a href="#" target="_self">
               <span class="menu_ar2">{lang mkey='link' skey='feedback'}</span></a></span></li> -->
            <!-- <li><span class="menu_r2"><a href="#" target="_self">
               <span class="menu_ar2">{lang mkey='link' skey='contact_us'}</span></a></span></li> -->
        </ul>
    </li>
</ul>
<br class="clearit" />
</div>