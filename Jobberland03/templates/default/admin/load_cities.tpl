<div class="header">Process States File</div>
<div>
    <p>Please load city/town codes file to the directory /cities before processing.</p>
    <p>The file should contain CITYCODE, CITYNAME, COUNTYCODE and STATECODE separated by commas. (in same order, no header)</p>
    <p>To delete city/town codes for a country, select the country and press "Delete city codes".</p>
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
   	<td><span class="label">City codes file: </span></td>
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
        <input type="submit"  class="button" name="loadstates" value=" Process city  file" />&nbsp;&nbsp;
        <input type="submit"  class="button" name="deletestates" value="Delete city codes" onclick="if ( !confirm('All city/town codes for this country will be deleted') ) return false;" />&nbsp;&nbsp;
	</td>
   </tr>
</table>
</form>
</div>