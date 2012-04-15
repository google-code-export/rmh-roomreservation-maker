<?php

/**
 * This file contains all the global configuration that needs to be setup before the application starts.
 * Since this file will be included by the header.php file, any thing that refers to header file will also
 * get the codes defined on this page
 * 
 */

//As an attempt to start, the following code sets the default timezone that is used by the date/time function throughout
date_default_timezone_set('America/New_York');


/**
 * Salt value that can be used to hash strings
 * This value should be changed before deployment.
 * If passwords are using the getHashValue() function,
 * then once this value is changed, we might need to
 * reset the passwords
 */
define('SECURITY_SALT', '991050965e004b58104e933c70ab86babd47d34b');

//directory separator
define('DS', '/');

//define the root directory of our application
define('ROOT_DIR', str_replace('\\','/',dirname(dirname(__FILE__))));

//define the document root, excluding the full path
define('BASE_DIR', str_replace($_SERVER['DOCUMENT_ROOT'],'', ROOT_DIR));

//define the CSS path
define('CSS_DIR', DS.BASE_DIR.'/css');

//define the JS folder
define('JS_DIR', DS.BASE_DIR.'/js');
?>
