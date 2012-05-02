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
* Permission script for RMH-RoomReservationMaker. 
* This file contains all the permission list for different pages.
* If your page is accessible by the users, access levels needs to be checked here.
* @author Prayas Bhattarai
* @version May 1, 2012
*/

require_once('core/config.php');
require_once(ROOT_DIR.'/core/sessionManagement.php');
require_once(ROOT_DIR.'/core/globalFunctions.php');

checkSession(); //check session if it has timed out or not

 /* Set our permission array for families, social workers, room reservation managers, and 
                 * administrators. If a page is not specified in the permission array, anyone logged into 
                 * the system can view it. If someone logged into the system attempts to access a page above their
		 * permission level, they will be sent back to the home page.
		 */
  
                 //Everyone = -1
                 //Family member = 0
                 //Social Worker = 1
                 //Room Reservation Manager = 2
                 //Admin = 3
    
    $permission_array = array();
    
    /* ============ pages EVERYONE can view ===============*/
    $permission_array['login.php']=-1; //login page is viewable by everyone
    $permission_array['logout.php']=-1; //logout page
    $permission_array['reset.php']=-1; //password reset page (available to everyone)
    
    
    /* ============ pages users with access level of FAMILY and above can view ===============*/
    $permission_array['index.php']=0;


    /* ============ pages SOCIAL WORKERs and above can view ===============*/
    $permission_array['referralForm.php']=1;
    $permission_array['newProfile.php']=1;
    $permission_array['profileChange.php']=1;
    $permission_array['SearchReservations.php']=1;
    $permission_array['profileDetail.php']=1;
    $permission_array['report.php']=1; //reporting
    $permission_array['SearchReservations.php']=1;
    $permission_array['changeAccountSettings.php'] = 1; //password change page (could be enhanced to a user information change page

    
    /* ============ pages RMH STAFF APPROVER and above can view ===============*/
    $permission_array['activity.php'] = 2; //approval page
    $permission_array['activityHandler.php'] = 2; //approval page handler
    $permission_array['searchProfileActivity.php'] = 2; //profile activity search page

    
    /* ============ pages RMH ADMINISTRATOR can view ===============*/ 
    $permission_array['listUsers.php'] = 3;
    $permission_array['addUser.php'] = 3;
    $permission_array['userActionHandler.php'] = 3;

    $current_page = getCurrentPage(); //current page
    
    //Log-in security
    //If they aren't logged in, display our log-in form.
    if(!isset($_SESSION['logged_in']) && (isset($permission_array[$current_page]) && $permission_array[$current_page] != -1)){
        //Redirect to the login page only if the current page is NOT viewable by the world AND the logged in session variable is not set
        header('Location: '.BASE_DIR.DS.'login.php'); 
        exit();
    }
    else if(isset($_SESSION['logged_in']) && ($current_page == 'login.php' || $current_page == 'reset.php'))
    {
        //if the current page is login.php || reset.php && the user is logged in, then redirect to the index.php page
        header('Location: '.BASE_DIR.DS.'index.php');
        exit();
    }
    else if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
            //if user is logged in start the permission check
            if(!isset($permission_array[$current_page]) || $permission_array[$current_page]>$_SESSION['access_level']){
                    //in this case, the user doesn't have permission to view this page.
                    if(isAjax())
                    {
                        //if it is an ajax request, display an error
                        echo "Restricted access";
                        exit();
                    }
                    else
                    {
                        //we redirect them to the index page.
                        header('Location: '.BASE_DIR.DS.'index.php');
                        exit(); //just in case
                    }
            }
    }
?>