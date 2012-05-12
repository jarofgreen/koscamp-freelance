{if $all_package }
 
<br />
	<h3>{lang mkey='header' skey='PackageOffer'}</h3>
<br />
 {foreach from=$all_package key=k item=i}
<div>
    <div class="solution-option">
        <div class="list-desc">
            <h3>{$i.package_name}</h3>
            <p>
                {$i.package_desc}
            </p>
            
           <div class="list-action-box" style="float:left;">
                <strong>{lang mkey='label' skey='packageInclude'}:</strong><br />
                
                {if $i.standard == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                		{lang mkey='label' skey='Standardpost'} <br />{/if}
                {if $i.spotlight == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                		{lang mkey='label' skey='Spotlightpost'}<br /> {/if}
                {if $i.cv_views == 'Y' } <img src='{$skin_images_path}tick.gif' alt='' />
                  {lang mkey='label' skey='CVView'} <br />{/if} 
                  	            
				<br />
                
                <div class="price">
                    {lang skey='currency_symbol' mkey='select' ckey=$CURRENCY_NAME } {$i.package_price} {$CURRENCY_NAME}
                </div>
                    <a href="{$BASE_URL}employer/order/?action=post&amp;package_id={$i.id}" 
                    title="Buy Now" ><br/></a>
            </div>
            
        </div>
        <div class="clear"></div>
    </div>

</div>    
{/foreach}
{/if}