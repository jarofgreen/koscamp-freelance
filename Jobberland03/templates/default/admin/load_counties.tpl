<div class="header">Process States File</div>
<div>
    <p>Please load county/district codes file to the directory /counties before processing.</p>
    <p>The file should contain COUNTYCODE, COUNTYNAME and STATECODE separated by commas. (in same order, no header)</p>
    <p>To delete county/district codes for a country, select the country and press "Delete county codes".</p>
</div>

{if $message != "" } {$message} {/if}

<div>
<form action="" method="post" >
<table border="0" width="100%">
  <colgroup>
    <col width="150" />
  </colgroup>
  <tr>
    <td><span class="label">Country: </span></td>
	<td>
	  <select name="txt_country" >
		{html_options options=$country selected=$smarty.session.loc.country}
	  </select>
	</td>
  </tr>
  <tr>
   	<td><span class="label">County codes file: </span></td>
 	<td>
	  <select name="filename">
		{html_options values=$files output=$files selected=$filename}
	  </select>
	</td>
  </tr>
  
  <tr>
   	<td>&nbsp;</td>
 	<td>&nbsp;</td>
  </tr>
  
  <tr>
  	<td>&nbsp;</td>
	<td>
        <input type="submit"  class="button" name="loadcounty" value=" Process counties file" />&nbsp;&nbsp;
        <input type="submit"  class="button" name="deletecounty" value="Delete counties codes" onclick="if ( !confirm('All county/district codes for this country will be deleted') ) return false;" />&nbsp;&nbsp;
	</td>
   </tr>
</table>
</form>
</div>