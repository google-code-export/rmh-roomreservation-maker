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
* Account Management script for RMH-RoomReservationMaker. 
* This page includes account settings. For now it is limited to password change, as the default password should be changed for all the users.
* @author Prayas Bhattarai
* @version May 1, 2012
*/

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Account Management"; //This should be the title for the page, included in the <title></title>

include('header.php'); //including this will further include (globalFunctions.php and config.php)
include(ROOT_DIR.'/database/dbUserProfile.php');

$errors = array();
$messages = array();

    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        //the security validation was successful, perform required operation here below.
        
        //validate data
        if(isset($_POST['edit_new_pass']) && !empty($_POST['edit_new_pass']) && strlen(trim($_POST['edit_new_pass'])) > 7)
        {
           $newPass = getHashValue($_POST['edit_new_pass']);
            
           if(isset($_POST['edit_verify_pass']) && !empty($_POST['edit_verify_pass']))
            {
               $verifyPass = getHashValue($_POST['edit_verify_pass']);
               
               //verify if the new password and verify password match
               if($newPass === $verifyPass)
               {
                   //continue with validation, check if the old password was correct
                   if(isset($_POST['edit_old_pass']) && !empty($_POST['edit_old_pass']))
                    {
                        $oldPass = getHashValue($_POST['edit_old_pass']);
                        $username = getCurrentUser();

                        if(retrieve_UserByAuth($username, $oldPass))
                        {
                            //old password is valid, continue with password change
                            //retrieve the userprofile
                            $userProfile = retrieveCurrentUserProfile();
                            
                            if($userProfile)
                            {
                                //make changes in the user profile regarding password, then update the database. This assumes that only the UserProfile table is being modified, not the corresponding detailed profile table
                                $userProfile->set_password($newPass);
                                
                                //update the user profile table
                                if(update_UserProfile($userProfile))
                                {
                                    $messages['change_successful'] = 'Your password has been successfully changed. For security reasons, it is recommended that you <a href="'.BASE_DIR.'/logout.php">logout</a> and login with the new password';
                                }
                                else
                                {
                                    $errors['change_failed'] = "The password could not be changed";
                                }
                                
                            }
                            else
                            {
                                $errors['retrieve_failed'] = 'Cannot retrieve current user information';
                            }
                        }
                        else
                        {
                            //invalid password
                            $errors['invalid_password'] = 'Invalid old password';
                        }

                    }
                    else
                    {
                        $errors['old_pass_empty'] = 'Please enter a valid password';
                    }
               }
               else
               {
                   $errors['password_mismatch'] = 'New password and verify password do not match';
               }
            }
            else
            {
                $errors['verify_pass_empty'] = 'Please enter a valid password.';
            }
        }
        else
        {
            $errors['new_pass_empty'] = "Please enter a valid password. Your new password should be a minimum of 8 characters long";
        }
        
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        $errors['security_check_failed'] = 'The request could not be completed: security check failed!';

    }
?>

<div id="container">
    <div id="content">
        <h2><?php echo getCurrentUser();?></h2>
        <?php
            if(!empty($errors))
            {
                echo '<div style="color:#FF3300;">';
                echo implode('<br />', $errors);
                echo '</div>';
            }
            if(!empty($messages))
            {
                echo '<div style="color:#00BB00;">';
                echo implode('<br />', $messages);
                echo '</div>';
            }
            else
            {
        ?>
        
        <p>Please use this page to change your default password, if you haven't already done so.</p>
       <form method="post" action="<?php echo BASE_DIR; ?>/changeAccountSettings.php">
            <table width="400" cellpadding="2">
                    <td>
                        <label for="edit_old_pass">Old Password<label>
                    </td>
                    <td>
                        <input id="edit_old_pass" type="password" name="edit_old_pass" />
                        <?php echo generateTokenField();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="edit_new_pass">New Password<label>
                    </td>
                    <td>
                        <input id="edit_new_pass" type="password" name="edit_new_pass" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="edit_verify_pass">Verify Password<label>
                    </td>
                    <td>
                        <input id="edit_verify_pass" type="password" name="edit_verify_pass" />
                    </td>
                </tr>
                
</table>
                <p><input type="submit" name="Submit" value="Submit" /></p>
</form>
        <?php 
            }
            ?>
    </div>
</div>
<?php 
include (ROOT_DIR.'/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.

function retrieveCurrentUserProfile()
{
    //since access level is stored in the session, use that to find the user category
    //1 is for social worker
    //2 is for staff approver
    //3 is for admin
    //if there is a db function available for this, this function is not needed
    $accessLevel = getUserAccessLevel();
    $userProfileId = getUserProfileID();
    
    switch($accessLevel)
    {
        case 1:
           return retrieve_UserProfile_SW_OBJ($userProfileId);
           break;
        case 2:
            return retrieve_UserProfile_RMHApprover_OBJ($userProfileId);
            break;
        case 3:
            $userProfile = retrieve_UserProfile_RMHAdmin($userProfileId);
            return is_array($userProfile) ? current($userProfile) : false;
            break;
        default:
            return false;
            break;
    }
}
?>

