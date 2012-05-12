<?php
require_once( LIB_PATH.DS."class.database.php");

/***************************************************************************************************#
***************************** CHANGE ISDELETE TO Y IF JOB OVER 30 DAYS *****************************#
*****************************************************************************************************/
$query = " SELECT 
                 job.post_date, job.id
		   FROM 
		       job_details AS job
		   WHERE 
		        DATE_ADD( job.post_date, INTERVAL 30 DAY ) < NOW() ";
//echo $query;			
@$result = $database->query( $sql );
@$num = mysql_num_rows( $result );
	if ( @$num > 0 ){
		while ( @$row = mysql_fetch_object( $result ) ):
			$query = "UPDATE job_details SET _delete = 'Y' WHERE id = '".$row->id."'";
			$result = $database->query( $query );
		endwhile;
	}


?>