{literal} 
<script type="text/javascript">
function setSelectsToB(field) {
	var box = document.getElementById('add_package');
	var control= document.getElementById('add_package').elements;
	//alert(control);
	for (var i=0;i<control.length;i++) {
		if ( control[i].type.match(/select/i) && control[i].name != "txt_active" && control[i].value == "Y" ) {
			var name = control[i].name;
			if( name != field ) control[i].selectedIndex=0;
		}
	}
}
</script>
{/literal} 
<div class="page_header">Add Package Plan</div>

{if $message != "" } {$message} {/if}

<form action="" method="post" name="add_package" id="add_package" >
<table>
    <tr>
        <td><label class="label">Package Name: </label></td>
        <td><input type="text" name="txt_name" value="{$smarty.session.package.name}" class="text_field" size="30" /></td>
    </tr>
    
    <tr>
        <td><label class="label">Package Description: </label></td>
        <td>
            <textarea name="txt_desc" cols="35" rows="5" class="text_field" >{$smarty.session.package.desc}</textarea>
        </td>
    </tr>
    
    <tr>
        <td><label class="label">Package Price: </label></td>
        <td><input type="text" name="txt_price" value="{$smarty.session.package.price}" class="text_field" size="15" /></td>
    </tr>
    
    <tr>
        <td><label class="label">Listings Quantity:</label></td>
        <td><input type="text" name="txt_qty" value="{$smarty.session.package.qty}" class="text_field" size="10" /></td>
    </tr>

    <tr>
        <td><label class="label">Standard: </label></td>
        <td>
            <select name="txt_standard" class="text_field" >
              {html_options options=$NoYes selected=$smarty.session.package.standard}
            </select>
        </td>
    </tr>
    
    <tr>
        <td><label class="label">Spotlight: </label></td>
        <td>
            <select name="txt_spotlight" class="text_field" >
              {html_options options=$NoYes selected=$smarty.session.package.spotlight}
            </select>
        </td>
    </tr>
    
    <tr>
        <td><label class="label">CV Views: </label></td>
        <td>
            <select name="txt_cv_views" class="text_field" >
              	{html_options options=$NoYes selected=$smarty.session.package.cv_views}
            </select>
        </td>
    </tr>
    
    <tr>
        <td><label class="label">Active: </label></td>
        <td>
            <select name="txt_active" class="text_field">
              {html_options options=$NoYes selected=$smarty.session.package.active}
            </select>
        </td>
    </tr>
    
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="bt_add" value="Add" class="button" /></td>
    </tr>
    
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    
</table>
</form>
