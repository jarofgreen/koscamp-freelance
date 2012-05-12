<div class="header">Process States File</div>
<div>
    <p>Please load state codes file to the directory /states before processing.</p>
    <p>The file should contain STATECODE and STATENAME separated by commas (no header).</p>
    <p>To delete state codes for a country, select the country and press the "Delete state codes" .</p>
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
   	<td><span class="label">State codes file: </span></td>
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
        <input type="submit"  class="button" name="loadstates" value=" Process states file" />&nbsp;&nbsp;
        <input type="submit"  class="button" name="deletestates" value="Delete state codes" onclick="if ( !confirm('All state codes for this country will be deleted') ) return false;" />&nbsp;&nbsp;
	</td>
   </tr>
</table>
</form>
</div>