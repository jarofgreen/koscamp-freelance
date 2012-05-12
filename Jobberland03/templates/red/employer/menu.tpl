<div class="menu bubplastic horizontal gray" id="menu_bar">

<ul id="navigation">
  <li><span class="menu_r"><a href="{$BASE_URL}employer/" target="_self"><span class="menu_ar">Home</span></a></span></li>
 
{if $employer_logged_in != '' && isset($employer_logged_in) }
    <li><span class="menu_r"><a href="{$BASE_URL}logout/" target="_self"><span class="menu_ar">Logout</span></a></span></li>
    <li><span class="menu_r"><a href="#" target="_self"><span class="menu_ar">Post or Manage job(s)<img src="{$skin_images_path}tab_divider1.gif" alt="" /></span></a></span>
        <ul class="horizontal_sub">
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/addjob/" target="_self"><span class="menu_ar2">Post new job</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/addjob/spotlight/" target="_self"><span class="menu_ar2">Post new Spotlight job</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/myjobs/" target="_self"><span class="menu_ar2">Manage existing job</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/search/" target="_self"><span class="menu_ar2">Search CV</span></a></span></li>
        </ul>
    </li>
    
    <li><span class="menu_r"><a href="#" target="_self"><span class="menu_ar">My Account<img src="{$skin_images_path}tab_divider1.gif" alt="" /></span></a></span>
        <ul class="horizontal_sub">
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/account/" target="_self"><span class="menu_ar2">My Details</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/account/change_password/" target="_self"><span class="menu_ar2">Change passeword</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/payment_history/" target="_self"><span class="menu_ar2">Payment History</span></a></span></li>
        </ul>
    </li>
    <li><span class="menu_r"><a href="{$BASE_URL}employer/credits/" target="_self"><span class="menu_ar">Buy Credits</li>
{else}

    <li><span class="menu_r"><a href="{$BASE_URL}employer/login/" target="_self"><span class="menu_ar">Login</span></a></span></li>
    <li><span class="menu_r"><a href="{$BASE_URL}employer/register/" target="_self"><span class="menu_ar">Register</span></a></span></li>
{/if}
        
    <li><span class="menu_r"><a href="{$BASE_URL}employer/services/" target="_self"><span class="menu_ar">Products</span></a></span></li>
    
    <li><span class="menu_r"><a href="#" target="_self"><span class="menu_ar">Help<img src="{$skin_images_path}tab_divider1.gif" alt="" /></span></a></span>
        <ul class="horizontal_sub">	
            <li><span class="menu_r2"><a href="{$BASE_URL}employer/page/faq/" target="_self"><span class="menu_ar2">Faq</span></a></span></li>
            <!-- <li><span class="menu_r2"><a href="#" target="_self"><span class="menu_ar2">Feedback</span></a></span></li> -->
            <!-- <li><span class="menu_r2"><a href="#" target="_self"><span class="menu_ar2">Search Help</span></a></span></li> -->
        </ul>
    </li>
</ul>
<br class="clearit" />
</div>