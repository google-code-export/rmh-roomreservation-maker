<?php

/**
 * @author Prayas Bhattarai
 * 
 * This file includes all the functions that are called in the admin interface 
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
    echo '<div style="color: #ff3300;">';
        echo implode('<br />', $errors);
    echo '</div>';
}
?>
