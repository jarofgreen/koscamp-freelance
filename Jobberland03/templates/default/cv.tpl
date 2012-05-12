{strip}
<div class="header">{lang mkey='header' skey='manage_my_cvs'}</div>

{if $message != "" } <br />{$message}<br /> {/if}

{lang mkey='account' skey='info3' } {$total_max_cv} {lang mkey='of' } {$MAX_CV} 
{lang mkey='account' skey='info4' }


<table width="100%" cellpadding="0" cellspacing="0" >
    <colgroup>
     <col />
     <col />
     <col />
     <col />
     <col />
     <col />
     <col width="100" />
    </colgroup>
    
    <tr class="highlight_tr">
        <td>&nbsp;{lang mkey='label' skey='name'}</td>
        <td>{lang mkey='label' skey='ac_status'}</td>
        <td>{lang mkey='label' skey='created'}</td>
        <td>{lang mkey='label' skey='last_modified'}</td>
        <td>{lang mkey='label' skey='total_views'}</td>
        <td>{lang mkey='label' skey='default_cv'}</td>
        <td>{lang mkey='label' skey='actions'}</td>
    </tr>
    
{foreach from=$my_cvs key=k item=i}
    <tr>
        <td><a href="{$BASE_URL}curriculum_vitae/rename/{$i.id}/">{$i.cv_title}</a></td>
        <td>{$i.cv_status|upper}{*capitalize*}</td>
        <td>{$i.created_at}</td>
        <td>{$i.modified_at}</td>
        <td>{$i.no_views}</td>
        <td>{if $i.default_cv == "Y"}<img src="{$skin_images_path}tick.gif" alt="" />{/if}</td>
        <td>
          <div id="menu_nav">
            <ul>
              <li><a href="#">{lang mkey='label' skey='actions'}</a>
                <ul>
                  <li><a href="{$BASE_URL}curriculum_vitae/rename/{$i.id}/" target="_self">{lang mkey='account' skey='link_rename'}</a></li>
                  <li><a href="{$BASE_URL}curriculum_vitae/download/{$i.id}/" target="_self">{lang mkey='account' skey='link_download'}</a></li>
                  <li><a href="{$BASE_URL}curriculum_vitae/copy/{$i.id}/" target="_self" 
                     onclick="return confirm_message('{lang mkey="copy_cv"}');">{lang mkey='account' skey='link_copy'}</a></li>
                  <li><a href="{$BASE_URL}curriculum_vitae/delete/{$i.id}/" 
                    onclick="return confirm_message('{lang mkey="deletecv"}');">{lang mkey='account' skey='link_delete'}</a></li>
                  <li><a href="{$BASE_URL}curriculum_vitae/resume/{$i.id}/change/">{lang mkey='account' skey='link_change_status'}</a></li>
                  <li><a href="{$BASE_URL}curriculum_vitae/default/{$i.id}/" >{lang mkey='account' skey='link_default'}</a></li>
                  <li><a href="{$BASE_URL}curriculum_vitae/resume/{$i.id}/review/">{lang mkey='account' skey='link_rv'}</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </td>
    </tr>
{/foreach}

</table>
<p>
<a href="{$BASE_URL}curriculum_vitae/add/">{lang mkey='account' skey='link_new_cv' }</a></p>
{/strip}
