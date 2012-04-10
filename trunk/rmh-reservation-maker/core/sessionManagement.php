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
 * getCurrentUser function returns the currently logged in user
 * 
 * @return string the unique username for the current logged in user 
 */
function getCurrentUser()
{
    return $_SESSION['_id'];
}

?>
