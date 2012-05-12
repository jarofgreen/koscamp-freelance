<div class="header">{lang mkey='header' skey='manage_my_cl'}</div>

{if $message != "" } <br /> {$message} <br />{/if}

<p>
    {lang mkey='account' skey='info5'} {$total_max_cl} {lang mkey='of'} {$MAX_COVER_LETTER} 
    {lang mkey='account' skey='info6'}
</p>

<table width="100%" cellpadding="0" cellspacing="0" >
    <colgroup>
     <col />
     <col />
     <col />
     <col />
     <col width="100" />
    </colgroup>
    <tr class="highlight_tr">
        <td>&nbsp;{lang mkey='label' skey='name'}</td>
        <td>{lang mkey='label' skey='created'}</td>
        <td>{lang mkey='label' skey='last_modified'}</td>
        <td>{lang mkey='label' skey='default_cv'}</td>
        <td>{lang mkey='label' skey='actions'}</td>

    </tr>

{foreach from=$my_letters key=k item=i}

    <tr>
        <td><a href="{$BASE_URL}covering_letter/edit/{$i.id}/">{$i.cl_title}</a></td>
        <td>{$i.created_at}</td>
        <td>{$i.modified_at}</td>
        <td>{if $i.is_defult == "Y"} <img src="{$skin_images_path}tick.gif" alt="" />{/if}</td>
        <td>
            <div id="menu_nav">
              <ul>
                <li>
                 <a href="#" target="_self">{lang mkey='label' skey='actions'}<img src="{$skin_images_path}tab_divider1.gif" alt="" /></a>
                 <ul>
                   <li><a href="{$BASE_URL}covering_letter/edit/{$i.id}/" target="_self">{lang mkey='account' skey='link_edit'}</a></li>
              <!-- <li><a href="{$BASE_URL}covering_letter/download/{$i.id}/" target="_self">Download</a></li>
                   <li><a href="{$BASE_URL}covering_letter/copy/{$i.id}/" target="_self">Copy</a></li>
              -->
                   <li><a href="{$BASE_URL}covering_letter/delete/{$i.id}/" onclick="return delete_cv();">{lang mkey='account' skey='link_delete'}</a></li>
                   <li><a href="{$BASE_URL}covering_letter/default/{$i.id}/" >{lang mkey='account' skey='link_default'}</a></li>
                 </ul>
                </li>
              </ul>
            </div>
        </td>
    </tr>
    
  {/foreach}
</table>

<p><a href="{$BASE_URL}covering_letter/add/">{lang mkey='account' skey='link_new_cl' } </a></p>