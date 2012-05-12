<?php
require_once( LIB_PATH.DS."class.database.php");

class PackageInvoice extends DatabaseObject{
	protected static $table_name = TBL_PACKAGE_INVOICE;
	protected static $db_fields = array('id', 'invoice_date',  'processed_date', 'package_status','fk_employer_id','fk_package_id','posts_quantity','standard','spotlight','cv_views','amount','item_name','subscr_date','payment_method','currency_code','currency_rate','reason');
	
	public $id;
	public $invoice_date;
	public $processed_date;
	public $package_status ;
	public $fk_employer_id ;
	public $fk_package_id ;
	public $posts_quantity ;
	public $standard;
	public $spotlight;
	public $cv_views;
	public $amount;
	public $item_name;
	public $subscr_date ;
	public $payment_method;
	public $currency_code;
	public $currency_rate;
	public $reason;
	
/*
$this->invoice_date 	= 
$this->processed_date 	= 
$this->package_status 	= 
$this->fk_employer_id 		= 
$this->fk_package_id 		= 
$this->posts_quantity 	= 
$this->spotlight 		= 
$this->amount 			= 
$this->item_name 		= 
$this->subscr_date 		= 
$this->payment_method 	= 
$this->currency_code 	= 
$this->currency_rate 	= 
$this->reason			= 
*/
	
	
	public $errors=array();
	


	public function check_invoice(){
		global $database, $db;
		
		$sql = "SELECT  * FROM ".self::$table_name;
		$sql .= " WHERE fk_employer_id='".$this->fk_employer_id."' 
					AND fk_package_id='".(int)$this->fk_package_id."' 
					AND (package_status='Selected'  OR package_status='Confirmed') ";
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public function delete_inactive_invoice(){
		global $database, $db;
		$sql = "DELETE FROM ".self::$table_name;
		$sql .=	" WHERE  (package_status='Selected' OR package_status='Confirmed') 
				AND id <> '".$this->id."' 
				AND fk_employer_id='".$this->fk_employer_id."' ";
		$sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	
	public function update_package_status(){
		global $database, $db;
		$sql = "UPDATE ".self::$table_name;
		$sql .= " SET package_status='".$this->package_status."'";
		if(isset($this->processed_date)){
			$sql.=", processed_date='".$this->processed_date."' ";
		}
		$sql .= " WHERE id=".$this->id;
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
	}
	
	
	public function recent_order_by_clint(){
		global $database, $db;
		$sql = "SELECT  * FROM ".self::$table_name;
		$sql .= " WHERE fk_employer_id='".$this->fk_employer_id."' ";
		$sql .= " AND DATE_ADD( invoice_date, INTERVAL 30 DAY ) > NOW() ";
		return self::find_by_sql( $sql );
	}
	
	public function orders_by_user(){
		global $database, $db;
		$sql = "SELECT  * FROM ".self::$table_name;
		$sql .= " WHERE fk_employer_id='".$this->fk_employer_id."' ";
		$sql .= " ORDER BY invoice_date DESC ";
		return self::find_by_sql( $sql );
	}
	
	
	public static function find_invoice( $fk_employer_id=null, $invoice_id=0 ){
		global $database, $db;
		$sql = "SELECT  * FROM ".self::$table_name;
		$sql .= " WHERE fk_employer_id=".$fk_employer_id;
		$sql .= " AND id=".(int)$invoice_id;
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	
############################# Saving and Updating ##########################	
	public function save() {
		
		// A new record won't have an id yet.
		if(isset($this->id)) {
			return $this->update();
		}else{
			return $this->create();
		}
	}
	
	
	
	
	
/***********************************************************************/

	// Common Database Methods
	public static function find_all(){
		$sql=" SELECT * FROM " .self::$table_name;
		return self::find_by_sql( $sql );
	}
	
	
	public static function find_by_id( $id=0 ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE id= ".$db->escape_value($id);
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public static function find_by_sql ( $sql="" ){
		global $database, $db;
		$result = $database->query( $sql );
		$object_array = array();
		while ($row = $database->fetch_array($result)) {
		  $object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	public static function count_all() {
	  	global $database, $db;
	  	$sql = "SELECT COUNT(*) FROM ".self::$table_name;
    	$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
   	 	return array_shift($row);
	}

	private static function instantiate($record) {
		// Could check that $record exists and is an array
   	 $object = new self;

		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 

	  $attributes = array();
	  foreach(self::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitised_attributes() {
	  global $database, $db;
	  $clean_attributes = array();
	  foreach($this->attributes() as $key => $value){
		  if ( isset($value) && $value != "" ) {
	   	 	$clean_attributes[$key] = $database->escape_value($value);
		  }
	  }
	  return $clean_attributes;
	}
	
	public function create() {
		global $database, $db;
		$attributes = $this->sanitised_attributes();
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}

	public function update() {
	  global $database, $db;
		$attributes = $this->sanitised_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			if ( isset($value) && $value != "" ) {
		  		$attribute_pairs[] = "{$key}='{$value}'";
			}
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	public function delete() {
		global $database, $db;
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	
}

$packageinvoice	= new PackageInvoice();
$packageinvoice &= package_invoice;
?>