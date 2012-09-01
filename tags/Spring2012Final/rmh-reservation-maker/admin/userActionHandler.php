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
* userAction Handler script for RMH-RoomReservationMaker. 
* This file contains all the functions and data manipulation script for the admin interface.
* As of May 1 version, this is limited to code to handle View User action only 
* @author Prayas Bhattarai
* @version May 1, 2012
*/

//start the session and set cache expiry
session_start();
session_cache_expire(30);
include_once('../permission.php');
include_once(ROOT_DIR.'/database/dbUserProfile.php');

$errors = array();

if(isset($_POST['form_token']) && validateTokenField($_POST))
{
    //post data was valid perform the functions
}
else if(isset($_POST['form_token']) && !validateTokenField($_POST))
{
    //invalid token, display error
}
else if(isset($_GET['view']) && isset($_GET['group']) && isAjax())
{
    //if it is a GET ajax request then do the following
    $user_profile_id =  sanitize($_GET['view']);
    $user_category = sanitize($_GET['group']);
    switch($user_category)
    {
        case 'RMH Administrator':
            $profileObjArray = retrieve_UserProfile_RMHAdmin($user_profile_id);
            $profileObj = is_array($profileObjArray) ? current($profileObjArray) : false;
            if($profileObj)
            {
            $profile = array(
                                'Username' => $profileObj->get_usernameId(),
                                'Category' => $profileObj->get_userCategory(),
                                'Name' => $profileObj->get_rmhStaffTitle().' '.$profileObj->get_rmhStaffFirstName().' '.$profileObj->get_rmhStaffLastName(),
                                'Phone' => $profileObj->get_rmhStaffPhone(),
                                'Email' => $profileObj->get_userEmail()
                ); 
            }
            else
            {
                $errors['invalid_profile'] = "Could not retrieve profile information";
            }
            break;
        case 'RMH Staff Approver':
            $profileObj = retrieve_UserProfile_RMHApprover_OBJ($user_profile_id);
            if($profileObj)
            {
            $profile = array(
                                'Username' => $profileObj->get_usernameId(),
                                'Category' => $profileObj->get_userCategory(),
                                'Name' => $profileObj->get_rmhStaffTitle().' '.$profileObj->get_rmhStaffFirstName().' '.$profileObj->get_rmhStaffLastName(),
                                'Phone' => $profileObj->get_rmhStaffPhone(),
                                'Email' => $profileObj->get_userEmail()
                ); 
            }
            else
            {
                $errors['invalid_profile'] = "Could not retrieve profile information";
            }
            break;
        case 'Social Worker':
            $profileObj = retrieve_UserProfile_SW_OBJ($user_profile_id);
        
            if($profileObj)
            {
            $profile = array(
                                'Username' => $profileObj->get_usernameId(),
                                'Category' => $profileObj->get_userCategory(),
                                'Name' => $profileObj->get_swTitle().' '.$profileObj->get_swFirstName().' '.$profileObj->get_swLastName(),
                                'Hospital Affiliation' => $profileObj->get_hospitalAff(),
                                'Phone' => $profileObj->get_swphone(),
                                'Email' => $profileObj->get_userEmail()
                ); 
            }
            else
            {
                $errors['invalid_profile'] = "Could not retrieve profile information";
            }
            break;
        default:
            $errors['invalid_category'] = 'Invalid user category';
            break;
    }
}
else
{
    $errors['invalid_request'] = 'Unknown request';
}

if(empty($errors))
{
    echo "<h2>User Detail</h2>";
    echo '<table cellpadding="3">';
    foreach($profile as $title=>$value)
    {
        echo '<tr>
                <td style="text-align:right; padding-right: 10px;">
                    <strong>'.$title.'</strong>
                </td>

                <td>'
                    .$value.
                '</td>
                </tr>';
    }
    echo '</table>';
}
else
{
    echo "Error";
    echo '<div style="color: #ff3300;">';
        echo implode('<br />', $errors);
    echo '</div>';
}
?>