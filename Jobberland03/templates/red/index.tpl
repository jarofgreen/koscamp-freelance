<?xml version="1.0" encoding="{lang mkey='ENCODING'}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={lang mkey='ENCODING'}" />
{strip}

<title>{$html_title}</title>
<meta name="description" content="{$meta_description}" />
<meta name="keywords" content="{$meta_keywords}" />

<link href="{$css_path}/main.css" type="text/css" media="screen" rel="stylesheet"/>
<link href="{$css_path}/menu_style.css" type="text/css" media="screen" rel="stylesheet"/>

<script language="javascript" type="text/javascript" src="{$DOC_ROOT}javascript/java.js"></script>
<script language="javascript" type="text/javascript" src="{$DOC_ROOT}javascript/jquery.js"></script>
<script language="javascript" type="text/javascript" src="{$DOC_ROOT}javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$DOC_ROOT}javascript/cascade.js"></script>

<script type="text/javascript">
var loadingTag = "{lang mkey='loading'}";
var url = "{$BASE_URL}";
var jquery_cat = "{$category_selected|@count}";

{literal}
$(document).ready(function(){
	if( jquery_cat <= 0 ){
		$('div#jquery_search_cat').hide();
	}else{
		$('div#jquery_search_cat').show();
		$('a#jquery_select_category').hide();
		check_cat();
	}
	
  $('a#jquery_select_category').click(function() {
    $('#jquery_search_cat').show('slow');
	$('a#jquery_select_category').hide();
    return false;
  });
  


$("input[name='category[]']").click(function () {  
	return check_cat();
	//alert(length);  
 });

function check_cat(){
	var max_categories = 10
	var length = $('input:checkbox:checked').length;  
	if ( length  <= max_categories ) {
		var extra = " Max 10 categories";
		$("#jquery_selecting_cat").html( length + ( length == 1 ? " Category is" : " Categories are") + " selected. <br />"+extra );
	}else{
		var extra = " Max categories are selected";
		$("#jquery_selecting_cat").html( max_categories + " Categories are selected. <br />" + extra );
		return false;
	}	
}

  
  
  	
   // Your code here
 });
 
 
 
{/literal}


</script>


</head>

<body dir="{lang mkey='DIRECTION'}">

<table border="0" cellspacing="0" cellpadding="0" class="table" id="main_table">

  <tr>
    <td>
      <table width="100%" >
      	
        <tr>
          <td  valign="top"> 
          	{include file='page_top_logo.tpl'}
          </td>
        </tr>
        
        <tr>
          <td valign="top">{include file='menu.tpl'}
          
          {if $spotlight_jobs != '' }
          	{$spotlight_jobs}
          {else}
          	{$latest_jobs}
          {/if}
          </td>
        </tr>
        
      </table>
    
    </td>
  </tr>
  
  <tr>
    <td>
    
      <table class="table">
        <colgroup>
            <col class="left_col2" />
            <col class="right_col2" />
        </colgroup>
		<tr>
          <td valign="top">
          	<div class="main_left_col">
          	  {$job_by_categorys}
              <br />
              {$recruiting_now}
            </div>
           </td>
          <td valign="top">
           <div class="main_right_col">
            {$rendered_page}
           </div>  
          </td>
        </tr>
        
      </table>
      
    </td>
  </tr>
  
  <tr>
    <td>
    {include file ='page_footer.tpl' }
    </td>
  </tr>
  
</table>

</body>
</html>
{/strip}