{if is_array ($job_by_cats) && $job_by_cats != "" }
    <div class="left_item">
     <div class="header">{lang mkey='header' skey='jobs_by_category'}</div> 
      <ul id="left_list_of_category">
      {foreach from=$job_by_cats key=k item=i}
        <li> <a href="{$BASE_URL}category/{$i.var_name}/" title="{$i.f_category_name}">
        	{$i.category_name|strip_tags} <span class='total_job'>({$i.total_num})</span> </a></li>
      {/foreach}
	 </ul>
    </div>
    <br />
{/if}