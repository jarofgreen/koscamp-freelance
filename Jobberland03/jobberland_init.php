<?php
$callscript=$_SERVER['SCRIPT_NAME'];

$calldir=str_replace('admin/','',substr($callscript,0,strrpos($callscript,'/')+1));

$calldir = str_replace('employer/','',$calldir);

/* Add last '/' for DOC_ROOT and replace // with single / */

$calldir = $calldir.'/';

$calldir = str_replace('//','/',$calldir);

$_SESSION['DOC_ROOT'] = $calldir;

define('DOC_ROOT', $_SESSION['DOC_ROOT']);

define( 'VERSION', '1.0' );
?>