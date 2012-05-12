<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{strip}

<title>{$html_title}</title>
<meta name="description" content="{$meta_description}" />
<meta name="keywords" content="{$meta_keywords}" />

<link href="{$css_path}/employer/main.css" type="text/css" media="screen" rel="stylesheet"/>
<link href="{$css_path}/menu_style.css" type="text/css" media="screen" rel="stylesheet"/>

<script language="javascript" type="text/javascript" src="{$DOC_ROOT}javascript/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="{$DOC_ROOT}javascript/java.js"></script>
<script language="javascript" type="text/javascript" src="{$DOC_ROOT}javascript/cascade.js"></script>

<script type="text/javascript" >
	var loadingTag = "{lang mkey='loading'}";
	var url = "{$BASE_URL}";
</script>

</head>

<body>

<table border="0" cellspacing="0" cellpadding="0" class="table" id="main_table">
  <tr>
    <td valign="top"> 
          	{include file='employer/page_top_logo.tpl'}</td>
  </tr>
  <tr>
    <td>
    	<table width="100%">
          <tr>
            <td>{include file='employer/menu.tpl'}</td>
          </tr>
          <tr>
            <td></td>
          </tr>
        </table>
    </td>
  </tr>
  
  <tr>
    <td>
      <table class="table">
      {if $dont_include_left == '' && !$dont_include_left }
        <colgroup>
            <col class="left_col" />
            <col class="right_col" />
        </colgroup>
		<tr>
          <td valign="top">{$left_side}</td>
       {else}
         <tr>
       {/if}
          <td valign="top">{$rendered_page}</td>
        </tr>
      </table>
    </td>
  </tr>
  
  <tr>
    <td>{include file='employer/page_footer.tpl'}</td>
  </tr>
  
</table>


</body>
</html>
{/strip}