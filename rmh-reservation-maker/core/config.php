<?php
/*
* Copyright 2012 by Prayas Bhattarai and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
 
/**
* Configuration script for RMH-RoomReservationMaker. 
* This file contains all the global configuration that needs to be setup before the application starts.
* Since this file will be included by the header.php file, any thing that refers to header file will also
* get the constants defined on this page
* @author Prayas Bhattarai
* @version May 1, 2012
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

//define the document root, excluding the full path --> for client side inclusions
//$basePath = str_replace($_SERVER['DOCUMENT_ROOT'],'', ROOT_DIR);
$basePath = basename(dirname(dirname(__FILE__)));

if(strpos($basePath, '/') !== 0)
{
    //make sure the base path starts with / (For windows/*nix consistency)
    define('BASE_DIR', DS.$basePath);
}
else
{
   define('BASE_DIR', $basePath); 
}

//define the CSS path
define('CSS_DIR', BASE_DIR.'/css');

//define the JS folder
define('JS_DIR', BASE_DIR.'/js');
?>