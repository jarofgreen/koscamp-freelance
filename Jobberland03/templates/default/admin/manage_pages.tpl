{literal} 
<script language="javascript" type="text/javascript">
  tinyMCE.init({
    theme : "advanced",
    mode: "exact",
    elements : "txt_page_text",
	skin : "o2k7",
    theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
    theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,"
							   +"justifyfull,fontselect,fontsizeselect,forecolor,backcolor",
	
	theme_advanced_buttons2 : "bullist, numlist, outdent, indent, |, cut,copy,paste,pastetext,"
							+ "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
	
	theme_advanced_buttons3 : "",
	
    height:"350px",
    width:"550px",
    file_browser_callback : 'myFileBrowser'
  });

</script>
{/literal} 

<div class="header">Page Management </div>

{if $message != "" } $message {/if}

<form method="post" action="" name="frm1">
    <table width="100%" border="0" cellpadding="" cellspacing="" >
       <colgroup>
         <col width="45" />
         <col/>
       </colgroup>
        <tr>
          <td>Pages: </td>
          <td>
            <select name="id" onchange="javascript: document.frm1.submit();" >
            	<option value="">Add new Page</option> 
            	{html_options options=$list_page selected=$smarty.post.id}
            </select>
          </td>
        </tr>
    </table>
</form>
    

<form method="post" action="" name="frmPage">
	<input type="hidden" name="id" value="{$id}" />
	<table  width="100%" border="0" cellpadding="" cellspacing="" >
       <colgroup>
         <col width="45" />
         <col/>
       </colgroup>
    	<tr>
          <td>Title: </td>
          <td><input type="text" name="txt_title" size="30" value="{$title}" /></td>
        </tr>
        
        <tr>
          <td>Key: </td>
          <td><input type="text" name="txt_key" size="20" value="{$key}" />
          www.yourdomain.com/page/YOUR_KEY</td>
        </tr>
        
        <tr>
          <td colspan="2">
          	<textarea name="txt_page_text">{$page_text}</textarea>
          </td>
        </tr>
        
        <tr>
          <td colspan="2">
          	{if $id == "" }
            	<input type="submit" name="bt_page" value="Add Page" class="button"  />
            {else}
            	<input type="submit" name="bt_update_page" value="Modify Page" class="button"  />
            {/if}
          </td>
        </tr>
        
    </table>
</form>
