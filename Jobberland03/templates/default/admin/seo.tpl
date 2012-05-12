<div class="header">Search Engine Optimisation </div>
{if $message != "" } {$message} {/if}

<p>
	<strong>Description: </strong>
	{$cat_description}
</p>
<br />

<form action="" method="post" >
    <input type="hidden" name="id" value="{$id}" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> <strong>{$title}: </strong></td>
    <td><input type="text" value="{$title_value}" size="100" maxlength="255" name="setting[PAGE_TITLE]" />
    	<br />{$title_desc}
    </td>
    </tr>
  <tr>
    <td><strong>{$keyword_title}: </strong> </td>
    <td><textarea name="setting[META_KEYWORDS]" cols="80" rows="5">{$keyword_value}</textarea>
    <br />{$keyword_desc}
    </td>
    </tr>
  <tr>
    <td><strong>{$desc_title}: </strong> </td>
    <td><textarea name="setting[META_DESCRIPTION]" cols="80" rows="5">{$desc_value}</textarea>
    <br />{$desc_desc}
    </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="add" value=" Update " /></td>
    </tr>
</table>


</form>
