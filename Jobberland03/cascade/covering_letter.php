<?php  require_once( "../initialise_file_location.php" );  

$id = (int)$_GET['id'];

if( isset( $id ) && !empty($id) && $id != "" && is_numeric($id) ){
	$letter = CovingLetter::find_by_id ( $id );
	echo $letter->cl_text;
}else{
	echo "";
}
//die;
?>