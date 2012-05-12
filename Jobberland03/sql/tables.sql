CREATE TABLE IF NOT EXISTS jobberland_admin (
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(16) NOT NULL,
	passwd VARCHAR(32) NOT NULL,
	PRIMARY KEY  (id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  jobberland_employee(
	id 					INT NOT NULL AUTO_INCREMENT,
	extra_id			VARCHAR(30) NOT NULL DEFAULT '',
	email_address 		VARCHAR(100) NOT NULL,
	username 			VARCHAR(30) NOT NULL,
	passwd 				VARCHAR(32) NOT NULL,
	title 				VARCHAR(3) NOT NULL,
	fname 				VARCHAR(50) NOT NULL,
	sname 				VARCHAR(50) NOT NULL,
	address 			VARCHAR(50) NOT NULL,
	address2 			VARCHAR(50) NOT NULL,
	city 				varchar(100) default '',
	county 				varchar(50) default '',
	state_province 		varchar(50) default '',
	country 			varchar(11) default '',
	post_code 			VARCHAR(8) NOT NULL,
	phone_number 		VARCHAR(11) NOT NULL,
	fk_career_degree_id INT NOT NULL,
	date_register 		VARCHAR(30) NOT NULL DEFAULT '',
	last_login 			VARCHAR(30) NOT NULL DEFAULT '',
	actkey 				VARCHAR(32) NOT NULL,
	admin_comments		VARCHAR(255) NOT NULL DEFAULT '',
	employee_status  	VARCHAR(10)  NOT NULL DEFAULT 'pending',
	is_active 			CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY (id),
	UNIQUE KEY(username),
	UNIQUE KEY(email_address),
	KEY city (city),
	KEY county (county),
	KEY state_province (state_province),
	KEY country (country),
	KEY post_code (post_code),
	INDEX fullname (fname, sname)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_employer (
	id 				INT NOT NULL AUTO_INCREMENT,
	extra_id		VARCHAR(30) NOT NULL DEFAULT '',
	company_name 	VARCHAR(50) NOT NULL,
	var_name		VARCHAR(50) NOT NULL,
	contact_name 	VARCHAR(50) NOT NULL,
	site_link 		VARCHAR (100) NOT NULL,
	company_logo 	VARCHAR (100) NOT NULL,
	company_desc 	LONGTEXT NOT NULL,	
	email_address 	VARCHAR(100) NOT NULL,
	username 		VARCHAR(30) NOT NULL,
	passwd 			VARCHAR(32) NOT NULL,
	title 			VARCHAR(3) NOT NULL,
	fname 			VARCHAR(50) NOT NULL,
	sname 			VARCHAR(50) NOT NULL,
	address 		VARCHAR(50) NOT NULL,
	address2 		VARCHAR(50) NOT NULL,
	city 			varchar(100) default '',
	county 			varchar(50) default '',
	state_province 	varchar(50) default '',
	country 		varchar(11) default '',
	post_code 		VARCHAR(8) NOT NULL,
	phone_number 	VARCHAR(11) NOT NULL,
	job_qty 		INT NOT NULL DEFAULT '0',
	cv_qty 			INT NOT NULL DEFAULT '0',
	spotlight_qty 	INT NOT NULL DEFAULT '0',
	date_register 	VARCHAR(30) NOT NULL DEFAULT '',
	last_login		VARCHAR(30) NOT NULL DEFAULT '',
	actkey 			VARCHAR(32) NOT NULL,
	admin_comments	VARCHAR(255) NOT NULL DEFAULT '',
	employer_status VARCHAR(10)  NOT NULL DEFAULT 'pending',
	is_active 		CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY (id),
	UNIQUE KEY(username),
	UNIQUE KEY(email_address),
	KEY city (city),
	KEY county (county),
	KEY state_province (state_province),
	KEY country (country),
	KEY post_code (post_code),  
	INDEX fullname (fname, sname)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_package (
	id 					INT NOT NULL AUTO_INCREMENT,
	package_name		VARCHAR(100) NOT NULL,
	package_desc		LONGTEXT NOT NULL,
	package_price		DOUBLE(8,2) default '00.00',
	package_job_qty		INT NOT NULL,
	standard			SET('Y', 'N') DEFAULT 'Y',
	spotlight			SET('Y', 'N') DEFAULT 'N',
	cv_views			SET('Y', 'N') DEFAULT 'N',
	is_active 			CHAR(1) NOT NULL,
	date_inactive		VARCHAR(30) NOT NULL DEFAULT '',
	PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_package_invoice (
	id 				BIGINT NOT NULL auto_increment,
	invoice_date 	VARCHAR(30) NOT NULL DEFAULT '',
	processed_date 	VARCHAR(30) NOT NULL DEFAULT '',
	package_status 	VARCHAR(255) NOT NULL default '',
	fk_employer_id 	INT NOT NULL default '0',
	fk_package_id 	INT NOT NULL default '0',
	posts_quantity 	INT NOT NULL default '0',
	standard			SET('Y', 'N') DEFAULT 'Y',
	spotlight 		SET('Y', 'N') DEFAULT 'N',
	cv_views 		SET('Y', 'N') DEFAULT 'N',
	amount 			DOUBLE(8,2) NOT NULL default '0',
	item_name 		VARCHAR(255) NOT NULL default '',
	subscr_date 	VARCHAR(30) NOT NULL DEFAULT '',
	payment_method 	VARCHAR(64) NOT NULL default 'paypal',
	currency_code 	CHAR(3) NOT NULL default 'GBP',
	currency_rate 	decimal(10,4) NOT NULL default '0.0000',
	reason 			VARCHAR(128) NOT NULL,
	PRIMARY KEY  (id),
	KEY (fk_employer_id),
	KEY (fk_package_id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_payments_invoice (
	id 	 				INT (200) NOT NULL AUTO_INCREMENT,
	fk_invoice_id 		INT NOT NULL,
	payment_status 	VARCHAR(255) NOT NULL default '',
	payment_type 		VARCHAR (32) NOT NULL,
	amount 				DOUBLE (7,2) NOT NULL DEFAULT '0.00',
	currency			char(3) NOT NULL,
	receiver_id 		VARCHAR(30) NOT NULL,
	payment_email varchar(100) NULL,
	txn_id 				VARCHAR(128) NOT NULL,
	txn_type 			VARCHAR(30) NOT NULL,
	payer_status		VARCHAR(30) NOT NULL,
	residence_country 	VARCHAR(30) NOT NULL,
	payment_date		VARCHAR(100) NOT NULL,
	reason				VARCHAR(64) NOT NULL,
	origin				VARCHAR(32) NOT NULL,
	payment_vars 		text NULL,
	PRIMARY KEY (id),
	KEY (fk_invoice_id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_category (
	id INT NOT NULL AUTO_INCREMENT,
	var_name VARCHAR(100) NOT NULL,
	cat_name VARCHAR (100) NOT NULL,
	PRIMARY KEY(id),
	UNIQUE KEY (cat_name, var_name)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_job2category (
	category_id 	INT NOT NULL,
	job_id 			INT NOT NULL,
	PRIMARY KEY  (category_id, job_id),
	KEY category_id (category_id),
	KEY job_id (job_id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_job ( 
	id 					BIGINT NOT NULL AUTO_INCREMENT,
	fk_employer_id 		VARCHAR( 30 ) NOT NULL,
	job_ref 			VARCHAR( 30 ) NOT NULL,
	var_name			VARCHAR(100) NOT NULL,
	job_title 			VARCHAR(100) NOT NULL,
	job_description 	LONGTEXT NOT NULL,
	job_postion 		VARCHAR( 50 ) NOT NULL,
	city 				varchar(100) default '',
	county 				varchar(50) default '',
	state_province 		varchar(50) default '',
	country 			varchar(11) default '',
	fk_education_id 	INT NOT NULL,
	fk_career_id 		INT NOT NULL,
	fk_experience_id 	INT NOT NULL,
	spotlight 			CHAR(1) NOT NULL DEFAULT 'Y',
	job_salary 			VARCHAR( 15 ) NOT NULL,
	salaryfreq 			VARCHAR( 10 ) NOT NULL,
	company_name		VARCHAR(100) NOT NULL,
	company_logo		TEXT NOT NULL,
	contact_name 		VARCHAR(100) NOT NULL,
	contact_telephone 	VARCHAR(13) NOT NULL,
	site_link 			TEXT NOT NULL,
	poster_email 		VARCHAR(200)  NOT NULL,
	views_count 		INT NOT NULL DEFAULT '0',
	apply_count 		INT NOT NULL DEFAULT '0',
	start_date 			VARCHAR(50)  NOT NULL,
	created_at 			VARCHAR(30) NOT NULL DEFAULT '',
	job_startdate 		VARCHAR(30) NOT NULL DEFAULT '',
	job_enddate 		VARCHAR(30) NOT NULL DEFAULT '',
	modified 			VARCHAR(30) NOT NULL DEFAULT '',
	is_active 			CHAR(1) NOT NULL DEFAULT 'Y', 
	job_status  		VARCHAR(10)  NOT NULL DEFAULT 'pending',
	has_been_active 	CHAR(1) NOT NULL DEFAULT 'Y',
	admin_first_view	VARCHAR(30) NOT NULL DEFAULT '',
	admin_status_date	VARCHAR(30) NOT NULL DEFAULT '',
	admin_comments  	VARCHAR(255)  NULL DEFAULT '',
	PRIMARY KEY(id), 
	UNIQUE (var_name), 
	FULLTEXT (job_title, job_description),
	FULLTEXT(city, county, state_province),
	INDEX (fk_education_id),
	KEY (city,county,state_province,country),
	INDEX (fk_career_id),
	INDEX (fk_experience_id)
) ENGINE=MyISAM;

CREATE TABLE  IF NOT EXISTS jobberland_job_type (
	id 			INT NOT NULL AUTO_INCREMENT,
	var_name 	VARCHAR(100) NOT NULL,
	type_name 	VARCHAR(100) NOT NULL,
	is_active 	CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY (id),
	UNIQUE KEY (type_name)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  jobberland_job2type (
	fk_job_id INT NOT NULL,
	fk_job_type_id INT NOT NULL,
	PRIMARY KEY (fk_job_id, fk_job_type_id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  jobberland_job_status (
	id 			INT NOT NULL AUTO_INCREMENT,
	var_name 	VARCHAR(100) NOT NULL,
	status_name VARCHAR(100) NOT NULL,
	is_active 	CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY(id),
	UNIQUE KEY (status_name)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  jobberland_job2status (
	fk_job_id INT NOT NULL,
	fk_job_status_id INT NOT NULL,
	PRIMARY KEY (fk_job_id, fk_job_status_id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_education (
	id 				INT NOT NULL AUTO_INCREMENT,
	var_name 		VARCHAR(100) NOT NULL,
	education_name 	VARCHAR(100) NOT NULL,
	is_active 		CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY(id),
	UNIQUE KEY (education_name)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  jobberland_career_degree (
	id 			INT NOT NULL AUTO_INCREMENT,
	var_name 	VARCHAR(100) NOT NULL,
	career_name VARCHAR(100) NOT NULL,
	is_active 	CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY(id),
	UNIQUE KEY (career_name)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  jobberland_experience (
	id 				INT NOT NULL AUTO_INCREMENT,
	var_name 		VARCHAR(100) NOT NULL,
	experience_name VARCHAR(100) NOT NULL,
	is_active 		CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY(id),
	UNIQUE KEY (experience_name)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  jobberland_job_history (
	id 				INT NOT NULL AUTO_INCREMENT,
	fk_employee_id 	INT NOT NULL,
	fk_job_id 		BIGINT NOT NULL,
	cv_name 		VARCHAR(100) NOT NULL,
	cover_letter	LONGTEXT NOT NULL,
	date_apply 		VARCHAR(30) NOT NULL DEFAULT '',
	is_deleted 		CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY  (id),
	KEY (fk_employee_id),
	KEY (fk_job_id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  jobberland_save_job (
	id 				INT NOT NULL AUTO_INCREMENT,
	fk_employee_id 	INT NOT NULL,
	fk_job_id 		BIGINT NOT NULL,
	date_saved 		VARCHAR(30) NOT NULL DEFAULT '',
	is_deleted 		CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY  (id),
	KEY (fk_employee_id),
	KEY (fk_job_id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  jobberland_save_search (
	id 				INT NOT NULL AUTO_INCREMENT,
	fk_employee_id 	INT NOT NULL,
	reference_name 	VARCHAR(150) NOT NULL,
	reference 		TEXT NOT NULL,
	date_save 		VARCHAR(30) NOT NULL DEFAULT '',
	is_deleted 		CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY  (id),
	KEY (fk_employee_id),
	KEY(reference_name),
	FULLTEXT (reference)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS  jobberland_cv_detail (
	id 					INT NOT NULL AUTO_INCREMENT,
	fk_employee_id		VARCHAR(30) NOT NULL,
	cv_title  			VARCHAR(30) NOT NULL,
	cv_description		VARCHAR(255) NOT NULL,
	cv_file_name 		VARCHAR(100) NOT NULL,
	cv_file_type 		VARCHAR(30) NOT NULL,
	cv_file_exe			VARCHAR(30) NOT NULL,
	cv_file_size		INT NOT NULL,
	cv_file_path		VARCHAR(255) NOT NULL,
	original_name		VARCHAR(100) NOT NULL,
	cv_status			VARCHAR(10) NOT NULL DEFAULT 'Private',
	default_cv			CHAR(1) NOT NULL DEFAULT 'N',
	year_experience		VARCHAR(30),
	highest_education	VARCHAR(100),
	salary_range		VARCHAR(30),
	availability 		CHAR(1) NOT NULL DEFAULT 'Y',
	start_date			VARCHAR(30) NOT NULL DEFAULT '',
	positions			VARCHAR(100) NOT NULL,
	recent_job_title	VARCHAR(100) NOT NULL,
	recent_employer 	VARCHAR(100) NOT NULL,
	recent_industry_work VARCHAR(100) NOT NULL,
	recent_career_level	VARCHAR(100) NOT NULL, 
	look_job_title		VARCHAR(100) NOT NULL, 
	look_job_title2		VARCHAR(100) NOT NULL,
	look_job_type		VARCHAR(70) NOT NULL, 
	look_job_status		VARCHAR(70) NOT NULL,
	
	city				VARCHAR(100) NOT NULL,
	county 				varchar(50) default '',
	state_province 		varchar(50) default '',
	country 			varchar(11) default '',
	
	are_you_auth		VARCHAR(100) NOT NULL,
	willing_to_relocate	CHAR(1) NOT NULL DEFAULT 'Y',
	willing_to_travel	VARCHAR(30) NOT NULL,
	additional_notes	TEXT,
	no_views			INT(6) NOT NULL DEFAULT '0',
	created_at			VARCHAR(30) NOT NULL DEFAULT '',
	modified_at			VARCHAR(30) NOT NULL DEFAULT '',
	PRIMARY KEY(id),
	KEY(cv_title, recent_job_title, look_job_title, look_job_title2),
	key (fk_employee_id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_cv_category (
	cv_id  		INT NOT NULL,
	category_id INT NOT NULL,
	PRIMARY KEY(cv_id, category_id )
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_cv_look_occupation (
	cv_id  		INT NOT NULL,
	category_id INT NOT NULL,
	PRIMARY KEY(cv_id, category_id )
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_covering_letter (
	id 				INT NOT NULL AUTO_INCREMENT,
	fk_employer_id 	INT NOT NULL,
	cl_title  		VARCHAR(100) NOT NULL,
	cl_text			TEXT NOT NULL,
	created_at 		VARCHAR(30) NOT NULL DEFAULT '',
	modified_at		VARCHAR(30) NOT NULL DEFAULT '',
	is_defult		CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY (id),
	KEY (fk_employer_id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_cv_view (
	id 	   			INT NOT NULL AUTO_INCREMENT,
	fk_cv_id	   	INT NOT NULL,
	fk_employer_id  VARCHAR( 30 ) NOT NULL,
	view_for   		INT(3) NOT NULL,
	created_at 		VARCHAR(30) NOT NULL DEFAULT '',
	PRIMARY KEY (id),
	UNIQUE KEY( fk_cv_id, fk_employer_id )
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_email_template (
	id 				INT NOT NULL AUTO_INCREMENT,
	template_name	VARCHAR(70) NOT NULL,
	template_key	VARCHAR(70) NOT NULL,
	from_email		VARCHAR(150) NOT NULL,
	from_name		VARCHAR(70) NOT NULL,
	email_subject	VARCHAR(200) NOT NULL,
	email_text		LONGTEXT NOT NULL,
	PRIMARY KEY  (id),
	UNIQUE KEY (template_key)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_page (
	id 			INT NOT NULL AUTO_INCREMENT,
	lang 		VARCHAR(50) DEFAULT NULL,
	pagekey 	VARCHAR(100) NOT NULL DEFAULT '',
	title 		VARCHAR(255) NOT NULL DEFAULT '',
	pagetext 	LONGTEXT NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY (pagekey),
	KEY title (title)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_setting_category (
	id 				INT NOT NULL AUTO_INCREMENT,
	category_name	VARCHAR(255),
	var_name		VARCHAR(255),
	category_desc 	TEXT,
	UNIQUE (var_name),
	PRIMARY KEY (id)
) ENGINE=MyISAM;
	
CREATE TABLE IF NOT EXISTS jobberland_setting (
	id 				INT NOT NULL AUTO_INCREMENT,
	fk_category_id 	INT DEFAULT NULL,
	setting_name 	VARCHAR(64) NOT NULL,
	title 			VARCHAR(255) NOT NULL,
	description 	TEXT,
	data_type 		VARCHAR(255) DEFAULT NULL,
	input_type 		VARCHAR(255) DEFAULT NULL,
	input_options 	TEXT,
	validation		TEXT,
	value 			VARCHAR(255),
	PRIMARY KEY (id),
	UNIQUE(setting_name),
	KEY (fk_category_id)
) ENGINE=MyISAM;
	
CREATE TABLE IF NOT EXISTS jobberland_banner (
	id 			BIGINT NOT NULL AUTO_INCREMENT,
	name 		VARCHAR(255) NOT NULL DEFAULT '',
	bannerurl 	TEXT,
	language 	VARCHAR(255) DEFAULT NULL,
	linkurl 	VARCHAR(255) DEFAULT NULL,
	tooltip 	VARCHAR(255) DEFAULT NULL,
	size 		VARCHAR(20) DEFAULT NULL,
	startdate 	INT NOT NULL DEFAULT '0',
	expdate 	INT NOT NULL DEFAULT '0',
	link_target	VARCHAR(10) DEFAULT '_blank',
	clicks 		INT NOT NULL DEFAULT '0',
	enabled 	CHAR(1) NOT NULL DEFAULT 'Y',
	PRIMARY KEY (id),
	KEY startdate (startdate),
	KEY expdate (expdate),
	KEY linkurl (linkurl)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_search (
	id 			BIGINT NOT NULL AUTO_INCREMENT,
	keywords 	VARCHAR(100) NOT NULL,
	results 	INT(5) NOT NULL, 
	created_on 	VARCHAR(30) NOT NULL DEFAULT '',
	PRIMARY KEY  (id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_countries (
	id INT NOT NULL auto_increment,
	loc char(2) default NULL,
	code char(2) default NULL,
	var_name  VARCHAR(100) NOT NULL,
	name varchar(100) default NULL,
	enabled char(1) default 'Y',
	PRIMARY KEY  (id),
	KEY name (name),
	KEY code (code)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_states (
  id INT NOT NULL auto_increment,
  code varchar(10) default NULL,
  var_name  VARCHAR(100) NOT NULL,
  name varchar(100) default NULL,
  enabled char(1) default 'Y',
  countrycode varchar(5) NOT NULL default 'US',
  PRIMARY KEY  (id),
  KEY code (code),
  KEY enabled (enabled),
  KEY countrycode (countrycode)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_counties (
  id int(8) NOT NULL auto_increment,
  code varchar(10) default NULL,
  var_name  VARCHAR(100) NOT NULL,
  name varchar(100) default NULL,
  enabled char(1) default 'Y',
  countrycode varchar(5) NOT NULL default 'US',
  statecode varchar(10) NULL,
  PRIMARY KEY  (id),
  KEY code (code),
  KEY countrystate (countrycode,statecode)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_cities (
  id INT NOT NULL auto_increment,
  code varchar(10) default NULL,
  var_name  VARCHAR(100) NOT NULL,
  name varchar(100) default NULL,
  enabled char(1) default 'Y',
  countrycode varchar(5) NOT NULL default 'US',
  statecode varchar(10) NULL,
  countycode varchar(10) NULL,
  PRIMARY KEY  (id),
  KEY code (code),
  KEY countrystate (countrycode,statecode),
  KEY countrystatecounty (countrycode,statecode,countycode)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_payment_config (
  id INT NOT NULL auto_increment,
  payment_module_id INT NOT NULL,
  module_key varchar(255) NOT NULL default '',
  config_title varchar(64) NOT NULL default '',
  config_key varchar(64) NOT NULL default '',
  config_value varchar(255) NOT NULL default '',
  config_description varchar(255) NOT NULL default '',
  config_group_id int(11) NOT NULL default '0',
  sort_order int(5) default NULL,
  use_function varchar(255) default NULL,
  set_function varchar(255) default NULL,
  data_type 		VARCHAR(255) DEFAULT NULL,
  input_type 		VARCHAR(255) DEFAULT 'text',
  input_options 	TEXT DEFAULT '',
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_payment_modules (
  id int(11) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  module_key varchar(255) NOT NULL default '',
  class_file varchar(255) NOT NULL default '',
  formfile varchar(255) NOT NULL default '',
  enabled char(1) NOT NULL default 'N',
  PRIMARY KEY  (id),
  KEY name (name)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_plugin (
	id 			int NOT NULL auto_increment,
	plugin_name varchar(255) NOT NULL default '',
	plugin_key 	varchar(255) NOT NULL default '',
	class_file 	varchar(255) NOT NULL default '',
	formfile 	varchar(255) NOT NULL default '',
    enabled 	char(1) NOT NULL default 'N',
	PRIMARY KEY  (id),
	UNIQUE (plugin_key)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS jobberland_plugin_config (
	id 				int	NOT NULL auto_increment,
	plugin_id 		INT NOT NULL default '0',
	plugin_key 		varchar(255) NOT NULL default '',
	plugin_title 	varchar(255) NOT NULL default '',
	plugin_desc 	varchar(255) NOT NULL default '',
    plugin_value 	varchar(255) NOT NULL default '',
	data_type 		VARCHAR(255) DEFAULT NULL,
	input_type 		VARCHAR(255) DEFAULT 'text',
	input_options 	TEXT DEFAULT '',
	last_modified 	datetime default NULL,
    date_added 		datetime NOT NULL default '0000-00-00 00:00:00',
	PRIMARY KEY  (id),
	UNIQUE (plugin_key),
	key(plugin_id)
) ENGINE=MyISAM;

