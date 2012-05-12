{include file="admin/page_header.tpl"}
{strip}

<body dir="{lang mkey='DIRECTION'}">
<table id="main_tb">

    <colgroup>
        <col width="20%;" />
        <col />
    </colgroup>

  <tr>
    <td colspan="2">{include file="admin/index_top.tpl"}</td>
  </tr>
  
  <tr>
  	<td valign="top"> 
    {if isset($smarty.session.access_level) && $smarty.session.access_level == 'Admin' && $smarty.session.user_id != '' && isset($smarty.session.user_id) }

    {include file="admin/left_menu.tpl"}
    
    {/if}
    
    </td>
    <td valign="top">
        {$rendered_page}
    </td>
  </tr>

  <tr>
    <td colspan="2">

<div>&nbsp;</div>
<div id="Poweredby" align="center"><a href="http://jobberland.com/" target="_blank" >Powered by Jobberland &copy; 
{$smarty.now|date_format:'%Y'}
</a></div>
<div>&nbsp;</div>

    </td>
  </tr>

  
</table>
</body>
</html>
{/strip}