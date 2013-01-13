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
* Global functions for RMH-RoomReservationMaker. 
* 
* This file will include global functions that might be helpful for other pages.
* If you think a function that has to be used in your code could be re-used by others,
* please include it here. This file will be included in the header.php so, any other pages
* that use header.php file will automatically have these functions available.
* 
* Also, feel free to modify any of the existing functions if you think you could make it more efficient

* @author Prayas Bhattarai
* @version May 1, 2012
*/

include_once('config.php');
require_once('class/ErrorHandler.php');
require_once('class/CoreExceptions.php');

/**
 * sanitize function that filters out harmful characters from being processed. This function should be worked on.
 * 
 * @param string $data the field that needs to be sanitized
 * @param boolean $mysql (optional) set to true if the function is being used to sanitize at DB level. An active DB connection is required for this to work.
 * @return string sanitized data
 */
function sanitize($data, $mysql=false)
{
    if($mysql)
    {
        $sanitized = mysql_real_escape_string($data); //in order to use mysql_real_escap_string a db connection is required
    }
    else
    {
        $sanitized = htmlspecialchars(trim($data),ENT_QUOTES);
    }

    return $sanitized;
}

/**
 * getCurrentPage function that returns the name of the current page excluding the path
 * 
 * @return string name of the current page, including the php extension ex: globalFunctions.php
 */
function getCurrentPage()
{
    return basename($_SERVER['PHP_SELF']);
}

/**
 * generateRandomString function that generates a random string. This might be useful for creating unique links and tokens
 * 
 * @param string $extra (optional) value that can be passed to create additional variety to the randomness
 * @return string randomly generated string 
 */
function generateRandomString($extra='')
{
    return sha1(mt_rand(10000, 99999) . time() . $extra);
}

/**
 * getHashValue function hashes the string that is supplied. Can be used to hash passwords, compare to a hashed password.
 * 
 * @param string $value the string that needs to be hashed
 * @param boolean $salt (optional) if salt should be used to calculate the hash (default: true)
 * @return string the hashed value 
 */
function getHashValue($value, $salt=true)
{
    //if a SECURITY_SALT is defined then use it to hash the password
    if($salt && defined('SECURITY_SALT'))
    {
        $value = SECURITY_SALT.$value;
    }

    return sha1($value);
}

/**
 * isAjax function that checks if the request is an AJAX request
 * 
 * @return boolean value based on the check 
 */
function isAjax()
{
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}

/**
  * generateTokenField function that generates a token field for the form and stores it in the session for validating it later
  * 
  * @return string a unique token that can be used in the form
  * @author Prayas Bhattarai
  */  
  function generateTokenField()
  {
      $token = generateRandomString();
      $_SESSION['_token'] = $token;
      return '<input type="hidden" id="form_token" name="form_token" value="'.$token.'" />';
  }
  
  /**
   * validateTokenField function that will check the validity of the form data that was submitted depending on the form token
   * 
   * @return boolean true if validates, false if it does not. 
   */
  function validateTokenField($postData)
  {
      if(array_key_exists('form_token', $postData))
      {
          if(isset($_SESSION['_token']) && ($_SESSION['_token'] == $postData['form_token']))
          {
              unset($_SESSION['_token']); //remove the token once it's been used, making it invalid for reuse
              return true;
          }
          else
          {
          		throw new SecurityException("Invalid token");
          }
      }
      else
      {
      		throw new SecurityException("Token not set");
      }
  }
  
  /**
   * cst function allows us to use constants within the heredoc notation
   * 
   * from php.net comment #100449 on define
   */
  $cst = 'cst';
  function cst($constant){
  	return $constant;
  }
?>
