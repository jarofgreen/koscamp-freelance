{strip}
<div class="menu bubplastic horizontal red" id="menu_bar">
	<ul id="navigation">    
		<li><span class="menu_r"><a href="{$BASE_URL}" target="_self">
          <span class="menu_ar">{lang mkey='link' skey='home'}</span></a></span></li>

     {if isset($smarty.session.access_level) && $smarty.session.access_level == 'User' && $smarty.session.user_id != '' && isset($smarty.session.user_id) }
        <li><span class="menu_r"><a href="{$BASE_URL}logout/" target="_self">
          <span class="menu_ar">{lang mkey='link' skey='logout'}</span></a></span></li>
        <li><span class="menu_r"><a href="#" target="_self">
          <span class="menu_ar">{lang mkey='link' skey='profile_cv'}<img src="{$skin_images_path}menu/tab_divider1.gif" alt="" /></span></a></span>
          <ul class="horizontal_sub">
          	<li><span class="menu_r2"><a href="{$BASE_URL}account/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='my_details'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}account/change_password/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='login_details'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}curriculum_vitae/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='my_cv'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}covering_letter/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='my_cover_lt'}</span></a></span></li>
          </ul>
        </li>
		
        <li ><span class="menu_r"><a href="#" target="_self">
          <span class="menu_ar">{lang mkey='link' skey='job'}<img src="{$skin_images_path}menu/tab_divider1.gif" alt="" /></span></a></span>
          <ul class="horizontal_sub">
            <li><span class="menu_r2"><a href="{$BASE_URL}applications/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='my_app'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}save_job/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='my_save_job'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}save_search/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='my_save_search'}</span></a></span></li>
          </ul>
        </li>
		{/if}
        
       {if !isset($smarty.session.access_level) && $smarty.session.access_level == '' && $smarty.session.user_id == '' && !isset($smarty.session.user_id) }
        <li><span class="menu_r"><a href="{$BASE_URL}login/" target="_self">
          <span class="menu_ar">{lang mkey='link' skey='login'}</span></a></span></li>
        <li><span class="menu_r"><a href="{$BASE_URL}register/" target="_self">
          <span class="menu_ar">{lang mkey='link' skey='register'}</span></a></span></li>        
	{/if}
    
        <li><span class="menu_r"><a href="#" target="_self">
         <span class="menu_ar">{lang mkey='link' skey='browse_job'}<img src="{$skin_images_path}menu/tab_divider1.gif" alt="" />
         </span></a></span>
          
          <ul class="horizontal_sub">	
            <li><span class="menu_r2"><a href="{$BASE_URL}location/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='browse_by_loc'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}company/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='browse_by_company'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}category/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='browse_by_cat'}</span></a></span></li>
          </ul>
        </li>
        
        <li><span class="menu_r"><a href="#" target="_self">
        <span class="menu_ar">{lang mkey='link' skey='help'}<img src="{$skin_images_path}menu/tab_divider1.gif" alt="" /></span></a></span>
          <ul class="horizontal_sub">
            <li><span class="menu_r2"><a href="{$BASE_URL}page/faq/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='faq'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}feedback/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='feedback'}</span></a></span></li>
            <li><span class="menu_r2"><a href="{$BASE_URL}page/searchhelp/" target="_self">
              <span class="menu_ar2">{lang mkey='link' skey='search_help'}</span></a></span></li>
          </ul>
        </li>
        
	</ul>
	<br class="clearit" />
</div>

{/strip}