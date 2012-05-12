<?php
require_once( LIB_PATH.DS."class.database.php");

class City extends DatabaseObject{
	protected static $table_name = TBL_CITY;
	protected static $db_fields = array('id', 'code', 'var_name', 'name', 'enabled', 'countrycode', 'statecode', 'countycode');
	
	public $id;
	public $code;
	public $var_name;
	public $name;
	public $enabled="Y";
	public $countrycode;
	public $statecode;
	public $countycode;
	
	public $errors=array();
	
	public static function find_by_var_name( $var_name = null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE var_name= '".$db->escape_value($var_name)."'";
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}

	public function mod_write_check( $url ){
		$mod_name = mod_url_rewriter($url);
		$does_not_existed = false;
		$i=1;
		if( self::find_by_var_name( $mod_name ) ){
				while( !$does_not_existed )
				{ 
					if( !self::find_by_var_name( $mod_name.$i ) )
					{
						$does_not_existed = true;
						$mod_name = $mod_name.$i;
					}else{
						$i++;
					}
			   }
		}
		
		return $mod_name;
	}

###################### delete ##################
	public function delete_by_country( $country_code ){
	  global $database, $db;
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE countrycode='".$country_code."' ";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	
	public static function find_by_code( $countrycode='GB', $state=null, $county=null, $code=null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE code='".$db->escape_value($code)."' "; 
		
		if (!empty ($countrycode) ) $sql .= " AND countrycode='".$countrycode."' "; 
		if (!empty ($state) ) 		$sql .= " AND statecode ='".$db->escape_value($state)."' ";
		if (!empty ($county) ) 		$sql .= " AND countycode='".$county."' ";
		
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;		
	}

	public static function find_by_loc_var( $countrycode='GB', $state=null, $county=null, $code=null ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE var_name='".$db->escape_value($code)."' "; 
		
		if (!empty ($countrycode) ) $sql .= " AND countrycode='".$db->escape_value($countrycode)."' "; 
		if (!empty ($state) ) 		$sql .= " AND statecode ='".$db->escape_value($state)."' ";
		if (!empty ($county) ) 		$sql .= " AND countycode='".$db->escape_value($county)."' ";
		
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;		
	}

	public static function find_closest_city( $country_code="GB", $city = null ){
		global $database, $db;
		$sql = " SELECT *, match( name ) AGAINST ( '{$city}' IN BOOLEAN MODE ) AS relevance ";
		$sql .=" FROM ". self::$table_name . " as city, ".TBL_JOB." as job ";
		$sql .= " WHERE match( city.name ) AGAINST ( '{$city}' IN BOOLEAN MODE ) ";
		$sql .= " AND countrycode='".$country_code."' AND city.code = job.city";
		$sql .= " ORDER BY relevance DESC LIMIT 1 ";

		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}


	public function get_cityOptions($countrycode='GB', $statecode = 'AA', $countycode = 'AA', $all='Y', $order='name') {
		global $database, $db;

		$cities = array();
		
		if ($countycode == 'AA') {
			$sql = " SELECT * FROM ". self::$table_name;
			$sql .= " WHERE countrycode='".$countrycode."' AND statecode <> '".$statecode."' AND countycode <> '".$countycode."' ";
			$sql .= " order by ".$order;
		} else {
			$sql = " SELECT * FROM ". self::$table_name;
			$sql .= " WHERE countrycode='".$countrycode."' AND statecode='".$statecode."' AND countycode='".$countycode."' ";
			$sql .= " order by ".$order;
		}
	
		$recs = self::find_by_sql( $sql );
		
		if (count($recs) <= 0) return $cities;
	
		foreach ($recs as $rec) {
			$cities[$rec->code] = $rec->name;
		}
		
		unset($recs);
		
		$recs = $cities;
		
		unset($cities);
		
		$cities=array();
		if ($all == 'Y') {
			$cities['AA'] = ($recs['AA']!='')?$recs['AA']:'All Cities/Towns';
		}
		foreach ($recs as $key => $val) {
			$cities[$key] = $val;
		}
		unset($recs);
		return $cities;
	}







	// Common Database Methods
	public static function find_all_city( $country_code='GB', $order_by=null, $order=null ){
		global $database, $db;
		$sql=" SELECT * FROM " .self::$table_name;
		$sql .=" WHERE countrycode='".$db->escape_value($country_code)."' ";
		$order_city = " ORDER BY name ASC ";
		if( isset($order_by) && $order_by != "" ){
			 $order_city = " ORDER BY {$order_by} {$order}";
		}
		
		$sql .= $order_city;
		
		return self::find_by_sql( $sql );
	}
	
	public static function find_by_id_active( $id=0 ){
		global $database, $db;
		$sql = " SELECT * FROM ". self::$table_name;
		$sql .= " WHERE id=".$db->escape_value($id);
		$sql .= " LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
	
	public static function get_city_name( $id=0){
		global $database, $db;
		$sql = " SELECT name FROM ". self::$table_name;
		$sql .= " WHERE id= ".$db->escape_value($id);
		$sql .= " LIMIT 1 ";
		$result = $database->query( $sql );
		$row = $db->fetch_array($result);
		return !empty($row) ? $row['name'] : false;
	}
	
	public static function find_by_city_name( $name=null){
		global $database, $db;
		$sql = " SELECT name FROM ". self::$table_name;
		$sql .= " WHERE name='".$db->escape_value($name)."'";
		$sql .= " LIMIT 1 ";
		$result = $database->query( $sql );
		$row = $db->fetch_array($result);
		return !empty($row) ? $row['name'] : false;
	}
	
	public function save() {
		if( empty($this->code) ){
			$this->errors[]= get_lang('errormsg', 17);
		}
		
		if( empty($this->name) ){
			$this->errors[]=get_lang('errormsg', 18);
		}
			  
		if( sizeof($this->errors) == 0 ){
			// A new record won't have an id yet.
			if( isset($this->id) ) {
			   return $this->update();
			} else{
			   return $this->create();
			}
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
	    $clean_attributes[$key] = $database->escape_value($value);
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
		  $attribute_pairs[] = "{$key}='{$value}'";
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

$city 	= new City();
?>