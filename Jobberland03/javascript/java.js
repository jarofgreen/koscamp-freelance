// JavaScript Document

//window.onload = initAll;
function createRequestObject() {
	if (window.XMLHttpRequest && !(window.ActiveXObject)) {
		return new XMLHttpRequest();
	} else if (window.ActiveXObject){
/*		return new ActiveXObject('Microsoft.XMLHTTP'); */
		try {
			return new ActiveXObject('MSXML2.XMLHTTP');  
		} catch (e) {
			return new ActiveXObject('Microsoft.XMLHTTP');
		}
	} 
}

var http = createRequestObject();
function handleResponse() {
    if(http.readyState == 4){
		var response = http.responseText;
		//alert(response);
		if (response != 'undefined' && response != '') {
			var update = new Array();
			var up2 = new Array();
			if(response.indexOf('|||' != -1)  ) {
				update = response.split('|||');
				for (var i = 1; i<update.length; i++) {
					up2 = update[i].split("|:|");
					if (up2[0] != 'undefined' && up2[0] != '' && document.getElementById(up2[0]) ) {
					document.getElementById(up2[0]).innerHTML = up2[1];
					//alert(up2[0]);
					} 
				}
			}
	}
    }
}


var xhr = false;
function ajax_page( element, page ) {
	
	//alert ( element);
	//alert ( page);

	
	if (window.XMLHttpRequest) {
		xhr = new XMLHttpRequest();
	}
	else {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) { }
		}
	}

	if (xhr) {
		xhr.open("GET", page, true);
		xhr.onreadystatechange = function () {
			if ( xhr.readyState == 4 && xhr.status == 200 ) {
				//alert(xhr.responseText);
				document.getElementById(element).innerHTML = xhr.responseText;
			}			
		}
		xhr.send(null);
	}
	else {
		alert("Sorry, but I couldn't create an XMLHttpRequest");
	}
}

function innerHTML( element, text) {
	alert( 'element' );
	//document.getElementById(element).innerHTML = text;
}

function redirect_to( url ){
	return window.location = url;
}


var RecaptchaOptions = {
   theme : 'white'
   
};
//Other option are: red, white, blackglass, clean, custom

function confirm_message(message){
	if( confirm(message) ){
		return true;
	}
	return false;
}


function go_to( url ){
	return window.location = url;
}



function check_all( name ){
	var a=new Array();
	a=document.getElementsByName( name );
	
	for( i=0; i<a.length; i++ ){
		a[i].checked  = true;
	}
}

function de_check_all( name ){
	var a=new Array();
	a=document.getElementsByName( name );
	
	for( i=0; i<a.length; i++ ){
		a[i].checked  = false;
	}
}


/*
function check_job_( name ){
	var a=new Array();
	a=document.getElementsByName(name);

	var p=0;
	
	for( i=0; i<a.length; i++ ){
		if(a[i].checked) { p++; }
		
	}
	
	for( i=0; i<a.length; i++ ){
		if( p >= 1 ){
			if ( a[i].checked ) a[i].disabled  = false;
			else a[i].disabled  = true;
		}
		else{
			a[i].disabled  = false;
		}
	}
}


function validate_from_one_click(name){
	var str = '';
	var elem = document.getElementById(name).elements;
	for(var i = 0; i < elem.length; i++)
	{
		var my_car=elem[i].name;
		var the_length=my_car.length;
		var last_char=my_car.charAt(the_length-1);
		//alert('The last character is '+last_char+'.');
		
		if(last_char == '1' ){
			if(elem[i].value == "" )
			{
				alert("Please enter all the information");
				return false;
			}
		}
	}
	
	return true;
}

*/


/***************** new javascript *******************/
function submit_new_cv_name(){

}

function rename_cv( url, id, name ){
	form = '<form id="frm_cv_name" action="" >';
    form =+ '<input type="hidden" name="id" id="id" value="'+id+'" />';
   	form =+ ' <input type="text" name="txt_name" id="txt_name" value="'+name+'" />';
   	form =+ '<input type="submit" name="btn_rename" value="Rename" id="btn_rename" />';
	form =+'</form>';
	
	return document.getElementById(id).innerHTML = form;
}

/*
print job details
*/
function print_job (id) {
	var divID = id;
	var a = window. open('','','scrollbars=yes');
	
	a.document.open("text/html");
	a.document.write('<html>');
	a.document.write('<head>');
	a.document.write('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >');
	a.document.write('<link rel="stylesheet" type="text/css"  href="../../templates/defult/main.css" />');
	a.document.write('</head>');
	a.document.write('<body>');
	a.document.write(document.getElementById(divID).innerHTML);
	a.document.write('</body>');
	a.document.write('</html>');
	a.document.close();
	a.print();
	a.close();
}

///used on job page adding new job
function check_max_checkbox( name, max_num ){
	var a=new Array();
	a=document.getElementsByName( name );
	var p=0;
	
	for( i=0; i<a.length; i++ ){
		if(a[i].checked) { p++; }
	}
	for( i=0; i<a.length; i++ ){
		if( p >= max_num ){
			if ( a[i].checked ) a[i].disabled  = false;
			else a[i].disabled  = true;
		}
		else{
			a[i].disabled  = false;
		}
	}
}
	
function check_box( name, field, max_num ){
	var a=new Array();
		a=document.getElementsByName( field );
	for( i=0; i<a.length; i++ ){
		if( !a[i].disabled ) {
			if(a[i].value == name ) { 
				if ( a[i].checked )
					a[i].checked = false;
				else
					a[i].checked = true;
			}
			else if( a[i].checked ) { a[i].checked = true; }
			else { a[i].checked = false; }
		}
		else{
			if(a[i].value == name ) { a[i].checked = false; }
		}
	}
	
	return check_max_checkbox( field, max_num );
}

function checkUncheckAll(theElement) {
	var theForm = theElement.form, z = 0;
	for(z=0; z<theForm.length;z++){
		if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall'){
			theForm[z].checked = theElement.checked;
		}
	}
}

// captcha reload
function reloadCaptcha() {
	now = new Date();
	var capObj = document.getElementById('spam_code_img');
	if (capObj) {
		capObj.src = capObj.src + (capObj.src.indexOf('?') > -1 ? '&' : '?') + Math.ceil(Math.random()*(now.getTime()));
	}
}


/********* j query code ********/

