
<center>        

  <form action="" method="post" >
    <table cellpadding="5" cellspacing="5" style="border:1px solid; width:300px;">
      <tr>
        <td colspan="2">
        

        <div class="header">Admin Login</div>

{if $message != "" } {$message} {/if}

        </td>
      </tr>
      
      <tr>
        <td>Username: </td>
        <td><input type="text" name="txt_user" value="" /> </td>
      </tr>
      
      <tr>
        <td>Password: </td>
        <td><input type="password" name="txt_pass" value="" /> </td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="bt_login" value="Login" /></td>
      </tr>
      
    </table>
   </form>
</center>