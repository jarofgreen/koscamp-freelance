<?php //error_reporting( E_ERROR );

session_start();

defined('DS') 			? null : define("DS", DIRECTORY_SEPARATOR);

$dir = dirname(__FILE__);
$dir = preg_split ('%[/\\\]%', $dir);
$blank = array_pop($dir);
$dir = implode('/', $dir);

defined('SITE_ROOT') 	? null : define('SITE_ROOT', $dir );

date_default_timezone_set('Europe/London');
require_once(SITE_ROOT.DS."jobberland_init.php");

if ($_SERVER['HTTPS'] == 'on') {
	$HTTP = 'https://';
} else {
	$HTTP = 'http://';
}
define ('HTTP_METHOD', $HTTP);

defined('BASE_URL') 	? null : define('BASE_URL', $HTTP. $_SERVER['HTTP_HOST'].DOC_ROOT  );

$_SESSION['BASE_URL'] = BASE_URL;

/* new seeting */
defined('PUBLIC_PATH') 	? null : define('PUBLIC_PATH', SITE_ROOT  );

defined('LIB_PATH')		? null : define('LIB_PATH', PUBLIC_PATH . DS . 'libs');

/*** PUBLIC */
defined('LAYOUT_PATH') 	? null : define('LAYOUT_PATH', PUBLIC_PATH . DS . 'layouts');
defined('IMAGES_PATH') 	? null : define('IMAGES_PATH', PUBLIC_PATH . DS . 'images');
defined('COM_IMAGES_PATH') 	? null : define('COM_IMAGES_PATH', IMAGES_PATH .DS.'company_logo');
defined('STYLE_PATH') 	? null : define('STYLE_PATH', PUBLIC_PATH . DS . 'stylesheet');
defined('JAVA_PATH') 	? null : define('JAVA_PATH', PUBLIC_PATH . DS . 'javascript');
defined('LANGUAGE') 	? null : define('LANGUAGE', PUBLIC_PATH . DS . 'languages');

defined('PLUGIN_PATH') 	? null : define('PLUGIN_PATH', PUBLIC_PATH . DS . 'plugins');

/** Employer **/
defined('CLINT_LAYOUT_PATH') 	? null : define('CLINT_LAYOUT_PATH', PUBLIC_PATH .DS. 'employer'.DS.'layouts');
defined('CLINT_DIR') 			? null : define( 'CLINT_DIR', PUBLIC_PATH .DS. 'employer' );

/** admin **/
defined('ADMIN_LAYOUT_PATH') 	? null : define('ADMIN_LAYOUT_PATH', PUBLIC_PATH .DS. 'admin'.DS.'layouts');
defined('ADMIN_DIR') 			? null : define( 'ADMIN_DIR', PUBLIC_PATH .DS. 'admin' );

/** template */
define( 'TEMPLATE_DIR', PUBLIC_PATH . DS.'templates' );
define( 'TEMPLATE_C_DIR', PUBLIC_PATH . DS . 'templates_c' );
define( 'SMARTY_DIR', LIB_PATH . DS . 'Smarty' . DS );
define( 'CACHE_DIR', PUBLIC_PATH . DS . 'cache' );
//define ("SMARTY_CORE_DIR", SMARTY_DIR . 'core/');


require_once(LIB_PATH.DS."PHPMailer".DS."class.phpmailer.php");
require_once(LIB_PATH.DS."config.php");
require_once (LIB_PATH.DS."class.session.php");
require_once SMARTY_DIR . 'Smarty.class.php';
/***/
require_once (LIB_PATH.DS."class.database.php");
require_once (LIB_PATH.DS."class.databaseobject.php");

global $smarty;
$_SESSION['smarty'] =  $smarty = new Smarty;
require_once (LIB_PATH.DS."class.setting.php");
define('skin_images_path', DOC_ROOT . "templates/" . TEMPLATE . "/images/" );
require_once (LIB_PATH.DS."functions.php");

define("GET_LANG", "english/");
require_once(LANGUAGE.DS.GET_LANG."lang_main.php");
require_once(LANGUAGE.DS.GET_LANG."lang_main_emp.php");

require_once (LIB_PATH.DS."class.pagination.php");

require_once (LIB_PATH.DS."class.admin.php");
require_once (LIB_PATH.DS."class.job.php");
require_once (LIB_PATH.DS."class.category.php");
require_once (LIB_PATH.DS."class.job2status.php");
require_once (LIB_PATH.DS."class.job2type.php");
require_once (LIB_PATH.DS."class.jobcategory.php");

require_once (LIB_PATH.DS."class.jobhistory.php");
require_once (LIB_PATH.DS."class.jobstatus.php");
require_once (LIB_PATH.DS."class.jobtype.php");

require_once (LIB_PATH.DS."class.careerdegree.php");
require_once (LIB_PATH.DS."class.covingletter.php");
require_once (LIB_PATH.DS."class.cvsetting.php");
require_once (LIB_PATH.DS."class.education.php");
//require_once (LIB_PATH.DS."class.emailtemplate.php");
require_once (LIB_PATH.DS."class.experience.php");
require_once (LIB_PATH.DS."class.invoice.php");
require_once (LIB_PATH.DS."class.package.php");
require_once (LIB_PATH.DS."class.packageinvoice.php");
require_once (LIB_PATH.DS."class.savejob.php");
require_once (LIB_PATH.DS."class.savesearch.php");
require_once (LIB_PATH.DS."class.search.php");
require_once (LIB_PATH.DS."class.sendemail.php");

require_once (LIB_PATH.DS."class.stateprovince.php");
require_once (LIB_PATH.DS."class.city.php");
require_once (LIB_PATH.DS."class.country.php");
require_once (LIB_PATH.DS."class.county.php");

require_once (LIB_PATH.DS."class.employee.php");
require_once (LIB_PATH.DS."class.employer.php");

//plugins///
require_once (LIB_PATH.DS."class.plugin.php");
require_once (LIB_PATH.DS."class.pluginconfig.php");
//end of pulgins


define( 'TEMPLATE', TEMPLATE );

/**
$path = TEMPLATE_C_DIR . DS . TEMPLATE . DS. '_cache';
if( !file_exists ( $path ))
{
	mkdir( $path, 0777, true);
}
**/

$cv_dir = SITE_ROOT . DS . FILE_UPLOAD_DIR;
if( !file_exists ( $cv_dir )){mkdir( $cv_dir, 0777, true);}

$smarty->template_dir = TEMPLATE_DIR . DS . TEMPLATE ;
$smarty->compile_dir = TEMPLATE_C_DIR ;//. DS . TEMPLATE ;
$smarty->cache_dir = CACHE_DIR;

// set the default handler and other values for caching and faster loading
$smarty->default_template_handler_func = 'make_templateTPL';

$smarty->caching = false;
$smarty->force_compile = false;
//$smarty->register_prefilter("prefilter_getlang");
$smarty->compile_id= GET_LANG;//$_SESSION['opt_lang'];

$smarty->assign('lang',$lang);

$smarty->assign('DOC_ROOT', DOC_ROOT);
$smarty->assign('BASE_URL', BASE_URL);

$smarty->assign('css_path', DOC_ROOT . "templates/" .  TEMPLATE );
$smarty->assign('skin_images_path', DOC_ROOT . "templates/" . TEMPLATE . "/images/");

deleteCache();
?>
