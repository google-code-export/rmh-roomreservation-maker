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
* Add new user script for RMH-RoomReservationMaker. 
* This page includes code that is used for adding a new user. 
* The input fields are updated based on the user group that is selected by the user. This is done using javascript.
* @author Prayas Bhattarai
* @version May 1, 2012
*/

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Add New User"; //This should be the title for the page, included in the <title></title>

include('../header.php'); //including this will further include (globalFunctions.php and config.php)
include_once(ROOT_DIR.'/domain/UserProfile.php');
include_once(ROOT_DIR.'/database/dbUserProfile.php');
$errors = array();
$messages = array();

$userCategories = array('admin' => 'RMH Administrator',
    'rmhstaff' => 'RMH Staff Approver',
    'socialworker' => 'Social Worker');

if(isset($_POST['form_token']) && validateTokenField($_POST))
{
    //the security validation was successful, perform required operation here below.

    //validate the data
    if(isset($_POST['userGroup']))
    {
        $userType = sanitize($_POST['userGroup']);
    }
    else
    {
        $errors['invalid_usergroup'] = "Invalid user group";
    }
    if(isset($_POST['add_title']) && !empty($_POST['add_title']))
    {
        $add_title = sanitize($_POST['add_title']);
    }
    else
    {
        $errors['empty_title'] = "Title cannot be left empty";
    }
    if(isset($_POST['add_username']) && !empty($_POST['add_username']))
    {
        $add_username = sanitize($_POST['add_username']);
        if(retrieve_UserByAuth($add_username))
        {
           $errors['duplicate_user'] = "Username already exists"; 
        }
    }
    else
    {
        $errors['empty_username'] = "Username cannot be left empty";
    }
    if(isset($_POST['add_fname']) && !empty($_POST['add_fname']))
    {
        $add_fname = sanitize($_POST['add_fname']);
    }
    else
    {
        $errors['empty_fname']= "First name cannot be left empty";
    }
    if(isset($_POST['add_lname']) && !empty($_POST['add_lname']))
    {
        $add_lname = sanitize($_POST['add_lname']);
    }
    else
    {
        $errors['empty_lname'] = "Last name cannot be left empty";
    }
    if(isset($_POST['add_phone']) && !empty($_POST['add_phone']))
    {
        $add_phone = sanitize($_POST['add_phone']);
    }
    else
    {
        $errors['empty_phone'] = "Phone cannot be left empty";
    }
    if(isset($_POST['add_email']) && !empty($_POST['add_email']))
    {
        $add_email = sanitize($_POST['add_email']);
    }
    else
    {
        $errors['empty_email'] = "Email cannot be left empty";
    }
    
    //validate data for social worker, extra info that rmh staff don't have
    if(isset($userType) && $userType == 'socialworker')
    {
        if(isset($_POST['add_hospital']) && !empty($_POST['add_hospital']))
        {
            $add_hospital = sanitize($_POST['add_hospital']);
        }
        else
        {
            $errors['empty_hospital'] = "Hospital affiliation cannot be left empty";
        }
        if(isset($_POST['add_notify']) && !empty($_POST['add_notify']))
        {
            $add_notify = sanitize($_POST['add_notify']);
        }
        else
        {
            $errors['empty_notify'] = "Invalid notification settings";
        } 
    }
    else
    {
        //set empty value for non-social worker user -- used in creation of user profile object
        $add_notify = '';
        $add_hospital = '';
    }
    //proceed with creating and storing the new user
    if(empty($errors))
    {
        //create a default password based on: User's firstname and last 4 digits of their phone number
        $add_password = trim(strtolower($add_fname)).trim(substr($add_phone, -4));
        $add_password = getHashValue($add_password);
        
        $newUserProfile = new UserProfile($userCategories[$userType], 0, $add_username, $add_email, $add_password, 0, $add_title, $add_fname, $add_lname, $add_phone, 0, $add_title, $add_fname, $add_lname, $add_hospital, $add_phone, $add_notify);
        
        //insert user profile
        $insertProfile = insert_UserProfile($newUserProfile);
        
        //if user profile insertion is successful, then the corresponding user profile tables need to be updated as well
        if($insertProfile)
        {
            //get the userprofile id for the newly inserted user
            //can this be done more efficiently, instead of retrieving all the info? using last_insert_id maybe?
            $retrievedUser = retrieve_UserByAuth($add_username);
            if($retrievedUser)
            {
                //if a user is retrieved, store the detailed information in the corresponding profile table             
                $newUserProfile->set_userProfileId($retrievedUser['UserProfileID']);

                if($retrievedUser['UserCategory'] == $userCategories['socialworker'])
                {
                    //if the user is a social worker, insert the detail info in the social worker table
                    $insertDetailProfile = insert_SocialWorkerProfile($newUserProfile);
                }
                else
                {
                    //else the user is an rmh staff, so insert detailed profile in the rmhstaff table
                    $insertDetailProfile = insert_RmhStaffProfile($newUserProfile);
                }
                
                //check for errors
                if($insertDetailProfile)
                {
                    $messages['user_creation_successful'] = "The user ".$add_username. " was successfully created.";
                }
                else
                {
                    $errors['insert_profile_detail_failure'] = "Profile detail could not be added";
                }
                
            }
            else
            {
                $errors['invalid_username'] = "Could not retrieve the new user";
            }
        }
        else
        {
            $errors['insert_failed'] = "Could not add the new user";
        }
        
        
    }
    
    
}
else if(isset($_POST['form_token']) && !validateTokenField($_POST))
{
    //if the security validation failed. display/store the error:
    //'The request could not be completed: security check failed!'
    $errors['security_check_failed'] = 'Security check failed';
    $userType = 'socialworker';
}
else if(isset($_GET['type']))
{
    //get requests need to be validated too. Work on validating these kinds of requests.

    $userType = sanitize($_GET['type']);
    if(!in_array($userType, array_keys($userCategories)))
    {
        $errors['invalid_parameter'] = 'Invalid User Category';
        $userType = 'socialworker';
    }
}
else
{
    //there was no POST DATA
    $userType = 'socialworker';
}
?>

<div id="container">
    <div id="content"> 
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
        <form method="post" action="<?php echo BASE_DIR; ?>/admin/addUser.php">
            <table width="400" cellpadding="2">
                <tr>
                    <td>
                        <label for="userGroup">User Category</label>
                    </td>
                    <td>
                        <select id="userGroup" name="userGroup">
                            <option value="admin" <?php echo($userType == 'admin' ? ' selected="selected"' : null) ?>>RMH Administrator</option>
                            <option value="rmhstaff" <?php echo($userType == 'rmhstaff' ? ' selected="selected"' : null) ?>>RMH Staff Approver</option>
                            <option value="socialworker" <?php echo($userType == 'socialworker' ? ' selected="selected"' : null) ?>>Social Worker</option>
                        </select>
                        <?php echo generateTokenField();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        Note: Password is automatically set as the combination of user's first name and last four digits of their phone number, all lowercase.
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="add_title">Title<label>
                    </td>
                    <td>
                        <input id="add_title" type="text" name="add_title" value="<?php echo isset($add_title)? $add_title : '';?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="add_fname">First name<label>
                    </td>
                    <td>
                        <input id="add_fname" type="text" name="add_fname" value="<?php echo isset($add_fname)? $add_fname : '';?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="add_lname">Last name<label>
                    </td>
                    <td>
                        <input id="add_lname" type="text" name="add_lname" value="<?php echo isset($add_lname)? $add_lname : '';?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="add_phone">Phone<label>
                    </td>
                    <td>
                        <input id="add_phone" type="text" name="add_phone" value="<?php echo isset($add_phone)? $add_phone : '';?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="add_username">Username<label>
                    </td>
                    <td>
                        <input id="add_username" type="text" name="add_username" value="<?php echo isset($add_username)? $add_username : '';?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="add_email">Email<label>
                    </td>
                    <td>
                        <input id="add_email" type="text" name="add_email" value="<?php echo isset($add_email)? $add_email : '';?>" />
                    </td>
                </tr>
                <?php
                if(isset($userType) && $userType == 'socialworker')
                {
                ?>
                <tr>
                    <td>
                        <label for="add_hospital">Hospital Affiliation<label>
                    </td>
                    <td>
                        <input id="add_hospital" type="text" name="add_hospital" value="<?php echo isset($add_hospital)? $add_hospital : '';?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="add_notify">Email Notification<label>
                    </td>
                    <td>
                        <input type="radio" id="add_yes" name="add_notify" checked="true" value="Yes" />
                        <label for="add_yes">Yes</label>
                        <input type="radio" id="add_no" name="add_notify" value="No" />
                        <label for="add_no">No</label>
                    </td>
                </tr>    
                <?php
                }
                ?>
                
</table>
                <p><input type="submit" name="Submit" value="Submit" /></p>
</form>
        <?php } //end else if for messages
        ?>
</div>
</div>
<script>
$(function(){
    $('#userGroup').change(function(){
            var userType = $(this).children('option:selected').val();
            window.location = '<?php echo BASE_DIR; ?>/admin/addUser.php?type='+userType;
              });
    
    $('#add_phone, #add_fname, #add_lname').focusout(function(){
        var fname = $.trim($('#add_fname').val());
        var lname = $.trim($('#add_lname').val());
        var phone = $.trim($('#add_phone').val());
        if(fname != '' && lname != '' && phone)
        {
            var username = fname.slice(0,1) + lname.slice(0,4) + phone.slice(-4);
           $('#add_username').val(username.toLowerCase());
        }
    });
                                                                                                         });
                                                                                                         
                                                                                       
                                                                                                                    </script>
                                                                                                                    <?php
                                                                                                                    include (ROOT_DIR . '/footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
                                                                                                                    ?>

