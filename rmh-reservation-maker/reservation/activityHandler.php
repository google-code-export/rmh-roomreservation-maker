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
* Activity Handler script for RMH-RoomReservationMaker. 
* This file contains the activity handler script. All the modification performed in the activity.php file is passed to this handler, to make the actual changes.
* @author Prayas Bhattarai
* @version May 1, 2012
*/
//start the session and set cache expiry
session_start();
session_cache_expire(30);

include('../permission.php'); //including this will further include (globalFunctions.php and config.php)
include_once(ROOT_DIR.'/database/dbProfileActivity.php');
include_once(ROOT_DIR.'/database/dbReservation.php');
include_once(ROOT_DIR.'/database/dbFamilyProfile.php');
include_once(ROOT_DIR.'/database/dbUserProfile.php');

$errors = array();
$messages = array();

$statuses = array('approve'=>'Confirm', 'deny'=>'Deny'); //Status info that is stored in the database

    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        //the security validation was successful, perform required operation here below.
        $requestId = sanitize($_POST['requestID']); //The request id that was submitted
        $requestType = sanitize($_POST['activityType']); //the activity type, whether it was a profile change, or reservation
        
        $status = sanitize($_POST['status']); //whether the status was approved or denied

        //since the activity tables uses RMH Staff profile ID, the current RMH profile needs to be retrieved. Maybe this kind of information can be stored in the SESSION?
        $rmhProfile = retrieve_UserProfile_RMHApprover_OBJ(getUserProfileID());
        $rmhStaffProfileId = $rmhProfile->get_rmhStaffProfileId();
        
        if($requestType == 'profile')
        {
            //$profileActivity = retrieve_ProfileActivity_byFamilyProfileID($familyProfileID);
            $profileActivity = retrieve_ProfileActivity_byRequestId($requestId);
         
            $profileActivity->set_rmhStaffProfileId($rmhStaffProfileId);
            $profileActivity->set_rmhDateStatusSubm(date("Y-m-d H:i:s"));
            $profileActivity->set_profileActivityStatus($statuses[$status]);
            
            $updateProfileActivity = update_status_ProfileActivity($profileActivity);
            
            
            if($updateProfileActivity)
            {
                $messages['profile_activity_updated'] = 'Profile activity status set to '.$profileActivity->get_profileActivityStatus();
                
                //if it is approved, it needs to be copied over to the family profile table
                if(array_search($profileActivity->get_profileActivityStatus(), $statuses) == 'approve')
                {
                    $alterFamilyProfile = update_FamilyProfile_On_ProfileActivity($profileActivity);
                    
                    if($alterFamilyProfile)
                    {
                        $messages['profile_updated'] = "Family Profile has been updated with the approved changes";
                    }
                    else
                    {
                        $errors['failed_update'] = "Cannot update family profile";
                    }
                       
                }
                
                //if no errors were present, send the email:
                if(empty($errors))
                {
                    /*=============== email the users ===========*/
                }
                
            }
            else
            {
                $errors['update_profile_failed'] = 'Cannot update activity status';
            }
        }
        else if($requestType == 'reservation')
        {
            $resActivity = retrieve_RoomReservationActivity_byRequestId($requestId);
            
            $resActivity->set_rmhStaffProfileId($rmhStaffProfileId);
            $resActivity->set_rmhDateStatusSubmitted(date("Y-m-d H:i:s"));
            $resActivity->set_status($statuses[$status]);
            
            $updateReservation = update_status_RoomReservationActivity($resActivity);
            
            if($updateReservation)
            {
                //email can be sent here
                $messages['status_changed'] = "Reservation activity status changed successfuly";
            }
            else
            {
                $errors['update_res_failed'] = 'Cannot update reservation';
            }
            
        }
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        $errors['invalid_token'] = 'Security check failed';

    }
    else
    {
        //there was no POST DATA
        $errors['invalid_request'] = 'Invalid request type';
    }
    if(!empty($errors))
    {
       //if there were errors, set it as session message
       setSessionMessage($errors, true);
       header('Location: '.BASE_DIR.'/SearchReservations.php');
    }
    else
    {
        //if there werer no errors, set the success message as session message.
       setSessionMessage($messages);
       $requestId = sanitize($_POST['requestID']);
       $url = "/reservation/activity.php?type=reservation&request=".$requestId;
       header('Location: '.BASE_DIR.$url);
    }
?>