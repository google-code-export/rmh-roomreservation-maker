<?php

/*
 * This file contains all the functions that are required to access the session variables.
 * Instead of directly allowing the other pages to access the session variables,
 * these functions provide an interface to access those variables. One of the reasons for this is,
 * in the future, we could manipulate the data that is returned by the functions in someway - if ever required.
 * The other advantage could be, if ever we needed to change the current session variable names, we could do so without
 * changing the code which uses that session variable elsewhere in the app.
 */

/**
 * checkSession function checks if the session has timed out or not due to inactivity. and logs out the user based on the condition
 *  
 */
function checkSession()
{
    $timeOut = 30; //session times out after this minute. this should be within the limit set by php.ini (session.gc_maxlifetime)
    if (!isset($_SESSION['_created_time'])) {
        $_SESSION['_created_time'] = time();
    }
    if(isset($_SESSION['_last_activity']) && (time() - $_SESSION['_last_activity'] > ($timeOut*60)))
    {
        session_destroy();
        session_unset();
        header('Location: '.BASE_DIR.DS.'login.php');
        exit();
    }
    if(isset($_SESSION['_created_time']) && time() - $_SESSION['_created_time'] > (($timeOut/2)*60))
    {
        session_regenerate_id(true);
        $_SESSION['_created_time'] = time();
    }
    $_SESSION['_last_activity'] = time();
}

/**
 * getCurrentUser function returns the currently logged in user
 * 
 * @return string the unique username for the current logged in user 
 */
function getCurrentUser()
{
    return isset($_SESSION['_username']) ? ($_SESSION['_username']) : false;
}

function getUserProfileID()
{
    return isset($_SESSION['_id']) ? ($_SESSION['_id']) : false;
}

function getUserAccessLevel()
{
    return isset($_SESSION['access_level']) ? ($_SESSION['access_level']) : false;;
}

?>
