<?php
require_once( LIB_PATH.DS."class.database.php");

class Setting extends DatabaseObject{
	protected static $table_name = TBL_SETTING;
	protected static $db_fields = array('id', 'fk_category_id', 'setting_name','title','description','data_type','input_type','input_options','validation','value');
	
	public $id;
	public $fk_category_id;
	public $setting_name;
	public $title;
	public $description;
	public $data_type;
	public $input_type;
	public $input_options;
	public $validation;
	public $value;
	
	public $settings=array();
	
	
	function __construct(){
		global $database, $db, $smarty;
		$setting = array();
		$sql = "SELECT * FROM ".self::$table_name;
		$result = $db->query($sql);
		if( $result ) {
			while ( $row = $db->fetch_array( $result ) ){
				defined( $row['setting_name'] ) ? null : define( $row['setting_name'], $row['value'] );
				$smarty->assign( $row['setting_name'], $row['value']);
			}
			return true;
		}
		else{
			die("Please import setting into your database");
		}
		return false;
	}
	
	
	public function update_setting(){
		global $database, $db;
		$replace_value= '</?[a-z][a-z0-9]*[^<>]*>';
		$value = eregi_replace($replace_value , '', $this->value );
		$value = $db->escape_value($value);
		
		$sql = " UPDATE ". self::$table_name;
		$sql.= " SET value='".$value."' ";
		$sql.= " WHERE setting_name = '".$this->setting_name."' ";
		$database->query($sql);
	  	return ($database->affected_rows() == 1) ? true : false;
	}
	
	public function get_setting_by_cat_id(){
		global $database, $db;
		$sql = "SELECT * FROM ".self::$table_name;
		$sql .=" WHERE fk_category_id=".$this->fk_category_id;
		$sql .=" ORDER BY id ASC ";
		return self::find_by_sql( $sql );
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
	
################################ THIS IS for SETTING CAT ###############################
	public function get_setting_cat_name(){
		global $database, $db;
		$sql = "SELECT * FROM ".TBL_SETTING_CAT;
		$result_set = $database->query($sql);
	  	$row = $database->db_result_to_array($result_set);
		return $row;
	}
	/***** get name of setting *****/
	public function get_setting_name( $id ){
		global $database, $db;
		$sql="SELECT * FROM ".TBL_SETTING_CAT;
		$sql.=" WHERE id=".(int)$id;
		$sql.=" LIMIT 1 ";
		$result_set = $database->query($sql);
	  	$row = $database->fetch_array($result_set);
		return $row;
	}
	
	/***** get setting by setting_name *****/
	public function get_setting_by_setting_name( $id ){
		global $database, $db;
		$sql="SELECT * FROM ".self::$table_name;
		$sql.=" WHERE setting_name='".$id."' ";
		$sql.=" LIMIT 1 ";
		
		$result = self::find_by_sql( $sql );
		return !empty($result) ? array_shift($result) : false;
	}
		
	
	public static function setting_value( $setting ){
		
		$return_value="";
		$name 			= $setting->setting_name;
		$input_type 	= $setting->input_type;
		$input_options 	= $setting->input_options;
		$value 			= $setting->value;
		$input_options	= explode( "|", $input_options );
		
		$size = ( strlen($value) > 35 ) ? strlen($value) : strlen($value)+10;
		
		/// option button 
		if( $input_type == "select" ){
			$return_value = " <select name='setting[".$name."]' >";
				foreach ( $input_options as $input_option ):
					$return_value .= "<option";
					$return_value .= ($input_option == $value) ? " selected='selected'":"";
					$return_value .= ">".$input_option."</option>";
				endforeach;
			$return_value .= "</select>";
		}
		
		elseif( $input_type == "paypal_currency" ){
			$return_value = " <select name='setting[".$name."]' >";
				$input_options = get_lang('select','currency');
				foreach ( $input_options as $i => $v  ):
					$return_value .= "<option value='".$i."'";
					$return_value .= ($i == $value) ? " selected='selected'":"";
					$return_value .= " >".$v."</option>";
				endforeach;
			$return_value .= "</select>";
		}
		
		elseif( $input_type == "currency_symbol" ){
			$return_value = " <select name='setting[".$name."]' >";
				$input_options = get_lang('select','currency_symbol');
				foreach ( $input_options as $i => $v  ):
					$return_value .= "<option value='".$i."'";
					$return_value .= ($i == $value) ? " selected='selected'":"";
					$return_value .= " >".$v."</option>";
				endforeach;
			$return_value .= "</select>";
		}
		
		elseif( $input_type == "country" ){
			$return_value = " <select name='setting[".$name."]' >";
			$country 	= Country::find_all_order_by_name();
			foreach( $country as $co ):
				if ($val['code'] != 'AA') {
					$return_value .= "<option value='".$co->code."'";
					$return_value .= ($co->code == $value) ? " selected='selected'":"";
					$return_value .= " >".$co->name."</option>";
				}
			endforeach; 
			$return_value .= "</select>";
		}
		
		elseif( $setting->input_type == "textarea" ){
			$return_value = "<textarea name='setting[".$name."]' cols='40' rows='5' >".$value."</textarea>";
		}
		///text filed
		elseif( $setting->input_type == "text" ){
			$return_value = "<input type='text' name='setting[".$name."]' value='".$value."' size='{$size}'>";
		}
		
		/// radio button
		elseif( $input_type == "radio" ){
			foreach ( $input_options as $input_option ):
				if( $input_option != "" ) {
					if( trim($input_option) == "" ) {
						$input_option = "leave it empty";
					}
					$return_value .= "<input type='radio' name='setting[".$name."]' ";
					$return_value .= ($input_option == $value) ? " checked='checked'":"";
					$return_value .= "value='".$input_option."' />" . $input_option ;
				}
			endforeach;
		}
		
		/** template **/
		elseif( $input_type == "template" ){
			$dir = PUBLIC_PATH."/templates";
			if( is_dir($dir) ) {
				$return_value = "<select name='setting[".$setting->setting_name."]' >\n";
				if($dir_handle=opendir($dir)){
					while ( $floder = readdir($dir_handle) ) {
						if( is_dir("$dir/$floder") ){
							if( $floder != "." && $floder != ".." ){
								$return_value .= "<option>$floder</option>\n";
							}//
						}//
					} //end while
					
					closedir($dir_handle);
				}//end if
				$return_value .= "</select>\n";
			}
		}
		
		else{}
		
		return $return_value;
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

$setting 	= new Setting();
?>