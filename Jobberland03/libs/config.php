<?php

define( 'DB_SERVER', 'localhost' );
define( 'DB_USER', '' );
define( 'DB_PASS', '' );
define( 'DB_NAME', '' );
define( 'DB_PREFIX', 'jobberland_' );
define( 'JOB_INSTALLED', '0' );

// ----------------
// DB TABLE Names
// ---------------
define ('TBL_ADMIN', DB_PREFIX .'admin');
define ('TBL_EMPLOYEE', DB_PREFIX . 'employee');
define ('TBL_EMPLOYER', DB_PREFIX . 'employer');

define ('TBL_PACKAGE', DB_PREFIX . 'package');
define ('TBL_PACKAGE_INVOICE', DB_PREFIX . 'package_invoice');

define ('TBL_CATEGORY',  DB_PREFIX .'category');
define ('TBL_JOB_2_CAT', DB_PREFIX . 'job2category');
define ('TBL_JOB', DB_PREFIX . 'job');
define ('TBL_JOB_TYPE', DB_PREFIX . 'job_type');
define ('TBL_JOB_2_TYPE', DB_PREFIX . 'job2type');
define ('TBL_JOB_STATUS', DB_PREFIX . 'job_status');
define ('TBL_JOB_2_STATUS', DB_PREFIX . 'job2status');
define ('TBL_EDUCATION', DB_PREFIX . 'education');
define ('TBL_CAREER_DEGREE', DB_PREFIX . 'career_degree');
define ('TBL_YEAR_EXPERIENCE', DB_PREFIX . 'experience');
define ('TBL_HISTORY', DB_PREFIX . 'job_history');
define ('TBL_SAVE_JOB', DB_PREFIX . 'save_job');
define ('TBL_SAVE_SEARCH', DB_PREFIX . 'save_search');

define ('TBL_CV', DB_PREFIX . 'cv_detail');
define ('TBL_CL', DB_PREFIX . 'covering_letter');
define ('TBL_CLINT_CVVIEW', DB_PREFIX . 'cv_view');
define ('TBL_CV_CAT', DB_PREFIX . 'cv_category');

define ('TBL_EMAIL_TEMPLATE', DB_PREFIX . 'email_template');
define ('TBL_PAGE', DB_PREFIX . 'page');

define ('TBL_INVOICE', DB_PREFIX . 'payments_invoice');

define ('TBL_SETTING_CAT', DB_PREFIX . 'setting_category');
define ('TBL_SETTING', DB_PREFIX . 'setting');
define ('TBL_SEARCH', DB_PREFIX . 'search');

define ('TBL_COUNTRY', DB_PREFIX . 'countries');
define ('TBL_STATES', DB_PREFIX . 'states');
define ('TBL_COUNTIES', DB_PREFIX . 'counties');
define ('TBL_CITY', DB_PREFIX . 'cities');

define ('TBL_PLUGIN', DB_PREFIX . 'plugin');
define ('TBL_PLUGIN_CONFIG', DB_PREFIX . 'plugin_config');

define ('TBL_PAYMENT_CONFIG', DB_PREFIX . 'payment_config');
define ('TBL_PAYMENT_MODULES', DB_PREFIX . 'payment_modules');

//define ('TBL_ZIPCODES', DB_PREFIX . 'zipCode');


/*
define ('TBL_CITY', DB_PREFIX . 'city');

define ('TBL_SEND_EMAIL', DB_PREFIX . 'send_email');


define ('TBL_QUESTION', DB_PREFIX . 'job_question');
define ('TBL_QUESTION_ANS', DB_PREFIX . 'job_qus_answer');
*/





// Number of links shown to next pages
global $links_to_next;
$links_to_next		 = 1;





?>
