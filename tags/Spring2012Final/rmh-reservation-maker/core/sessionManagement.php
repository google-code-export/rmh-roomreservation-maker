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
* Session Management functions for RMH-RoomReservationMaker. 
* This file contains all the functions that are required to access the session variables.
* Instead of directly allowing the other pages to access the session variables,
* these functions provide an interface to access those variables. One of the reasons for this is,
* in the future, we could manipulate the data that is returned by the functions in someway - if ever required.
* The other advantage could be, if ever we needed to change the current session variable names, we could do so without changing the code which uses that session variable elsewhere in the app.
* This module also includes function to check if the session has timed out or not, setting and displaying session messages
*
* @author Prayas Bhattarai
* @version May 1, 2012
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

/**
 * setSessionMessage function that sets errors or success message, so that it can be displayed even after the redirection
 * @param array $message An array of messages that need to be displayed
 * @param boolean $error If the message is an error message or not. By default, it is a normal message
 */
function setSessionMessage($message, $error=false)
{
    if($error)
    {
        $_SESSION['message_error'] = $message;
    }
    else
    {
        $_SESSION['message_normal'] = $message;

    }
}

function showSessionMessage()
{
    if(isset($_SESSION['message_error']))
    {
        echo '<div class="session_message" style="color:#FF3300;">';
        echo implode('<br />',$_SESSION['message_error']);
        echo '</div>';
        unset($_SESSION['message_error']);
    }
    else if(isset($_SESSION['message_normal']))
    {
        echo '<div class="session_message" style="color:#00BB00;">';
        echo implode('<br />', $_SESSION['message_normal']);
        echo '</div>';
        unset($_SESSION['message_normal']);
    }
}

?>
