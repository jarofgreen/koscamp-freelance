<?php
require_once( LIB_PATH.DS."config.php");

class MySQLDatabase{
	
	private $connection;
	private $magic_quotes_active;
	private $mysql_real_escape_string;
	
	public $last_query;
	
	function __construct(){
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->mysql_real_escape_string = function_exists("mysql_real_escape_string");
	}
	
	public function open_connection(){
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
		
		if( !$this->connection ){
			die("Database connection failed." . mysql_error() );
		}else{
			$db_select = mysql_select_db(DB_NAME, $this->connection);
			if(!$db_select){
				die("Database selection failed". mysql_error() );
			}
		}
	}
	
	public function close_connection(){
		if( isset($this->connection) ){
			mysql_close( $this->connection);
			unset( $this->connection);
		}
	}
	
	public function query( $sql="" ){
		$this->last_query = $sql;
		$result = mysql_query($sql, $this->connection);
		$this->confirm_query ( $result );
		return $result;
	}
	
	public function escape_value ( $string ){
		if( $this->mysql_real_escape_string ){
			if($this->magic_quotes_actives){ $string=stripslashes($string); }
			$string = mysql_real_escape_string($string);
		}else{
			if(!$this->magic_quotes_active){ $string= addslashes($string); }
		}
		return $string;
	}
	
	
	public function db_result_to_array($result){
	  $res_array = array();
		
		for ($count=0;  $row = $this->fetch_array($result) ; $count++)
		{
		  $res_array[$count] = $row;
		}
		
		return $res_array;
	}
	
	public function db_result_to_object($result){
	  $res_array = array();
		
		for ($count=0;  $row = $this->fetch_object($result) ; $count++)
		{
		  $res_array[$count] = $row;
		}
		
		return $res_array;
	}
		
	public function fetch_array( $result ){
		return mysql_fetch_array( $result );
	}
	
	public function fetch_object( $result ){
		// while ($row = mysql_fetch_object($result)) {
		//    echo $row->user_id;
		//    echo $row->fullname;
		// }
		//$row->user_id;
		return mysql_fetch_object( $result );
	}
	
	public function fetch_assoc( $result ){
		/*while ($row = mysql_fetch_assoc($result)) {
		    echo $row["userid"];
		    echo $row["fullname"];
		    echo $row["userstatus"];
		}*/
		return mysql_fetch_assoc( $result );
	}
	
	public function num_rows( $result ){
		return mysql_num_rows( $result);
	}
	
	public function insert_id(){
		//get me the last insert id
		return mysql_insert_id( $this->connection );
	}
	
	public function affected_rows(){
		return mysql_affected_rows( $this->connection );
	}
	
	private function confirm_query ( $result ){
		if(!$result){
		   
		   if(SITE_IN_DEVELOPER_MODE){
			   $output = "Database query failed ". mysql_error() . "<br />";
			   $output .= "Last Query run : " . $this->last_query;
			   die( $output );
			}else{
			   $error = "Database query failed Admin has been notifyed <br />";
			   $output = "Database query failed ". mysql_error() . "<br /> Site Name: ".SITE_NAME;
			   $output .= "Last Query run : " . $this->last_query;
			   
			   $subject = "WebSite Problem - ".SITE_NAME;
			   $to 	= array("email" => ADMIN_EMAIL, "name" => ADMIN_EMAIL );
			   $from 	= array("email" => ADMIN_EMAIL, "name" => ADMIN_EMAIL);
			   send_mail( $output, $subject, $to, $from, "", "" );
			   die( $error );
			}		
		}
	}
	
	public function mysql_db_error(){
		return mysql_errno() ." - ". mysql_error();
	}
	
	public function optimize_table($table){
		$sql = "optimize table ".$table;
		$this->query( $sql );
	}
	
}

$database = new MySQLDatabase();
$db =& $database;


?>
