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
* userEditor script for RMH-RoomReservationMaker. 
* This file contains all the functions and data manipulation script for the admin interface.
* As of May 1 version, this is limited to code to handle Edit User action only 
* @author Akhil Ayres
* @version December 12, 2012
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
            $u_Id = $profileObj->get_usernameId();
            $u_cat= $profileObj->get_userCategory();
            $staff_title= $profileObj->get_rmhStaffTitle();
            $staff_fname= $profileObj->get_rmhStaffFirstName();
            $staff_lname= $profileObj->get_rmhStaffLastName();
            $staff_phone= $profileObj->get_rmhStaffPhone();
            $u_email= $profileObj->get_userEmail();
            
           
                                
            echo'Username: '; ?><input type="text" name="Admin_Username" value="<?php echo $u_Id?>" size="5"/><?php echo '<br>';
            echo 'Category: '?><input type="text" name="Admin_Category" value="<?php echo $u_cat ?>" size="15"/><?php echo '<br>';
            echo 'Title: '?><input type="text" name="Admin_Title" value="<?php echo $staff_title ?>" size="2"/><?php
            echo '   First Name: '?><input type="text" name="Admin_FirstName" value="<?php echo $staff_fname ?>" size="7"/><?php
            echo '   Last Name: '?><input type="text" name="Admin_LastName" value="<?php echo $staff_lname ?>" size="7"/><?php echo '<br>';
            echo 'Phone: '?><input type="text" name="Admin_Phone" value="<?php echo $staff_phone ?>" size="10"/><?php echo '<br>';
            echo 'Email: '?><input type="text" name="Admin_Email" value="<?php echo $u_email ?>" size="25"/><?php
            
            ?>
<form method="post" action="<?php adminUpdate(); ?>"><input name="Update" type="submit" value="Update" /> </form>
            <?php
            
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
            $u_Id = $profileObj->get_usernameId();
            $u_cat= $profileObj->get_userCategory();
            $staff_title= $profileObj->get_rmhStaffTitle();
            $staff_fname= $profileObj->get_rmhStaffFirstName();
            $staff_lname= $profileObj->get_rmhStaffLastName();
            $staff_phone= $profileObj->get_rmhStaffPhone();
            $u_email= $profileObj->get_userEmail();
              
            echo'Username: '; ?><input type="text" name="App_Username" value="<?php echo $u_Id?>" size="5"/><?php echo '<br>';
            echo 'Category: '?><input type="text" name="App_Category" value="<?php echo $u_cat ?>" size="15"/><?php echo '<br>';
            echo 'Title: '?><input type="text" name="App_Title" value="<?php echo $staff_title ?>" size="2"/><?php
            echo '   First Name: '?><input type="text" name="App_FirstName" value="<?php echo $staff_fname ?>" size="7"/><?php
            echo '   Last Name: '?><input type="text" name="App_LastName" value="<?php echo $staff_lname ?>" size="7"/><?php echo '<br>';
            echo 'Phone: '?><input type="text" name="App_Phone" value="<?php echo $staff_phone ?>" size="10"/><?php echo '<br>';
            echo 'Email: '?><input type="text" name="App_Email" value="<?php echo $u_email ?>" size="25"/><?php
            
                        ?>
<form method="post" action="<?php RMHstaffApproverUpdate(); ?>"><input name="Update" type="submit" value="Update" /> </form>
            <?php

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
            $u_Id = $profileObj->get_usernameId();
            $u_cat= $profileObj->get_userCategory();
            $sw_title= $profileObj->get_swTitle();
            $sw_fname= $profileObj->get_swFirstName();
            $sw_lname= $profileObj->get_swLastName();
            $sw_phone= $profileObj->get_swphone();
            $u_email= $profileObj->get_userEmail();
                
            echo'Username: '; ?><input type="text" name="SW_Username" value="<?php echo $u_Id?>" size="5"/><?php echo '<br>';
            echo 'Category: '?><input type="text" name="SW_Category" value="<?php echo $u_cat ?>" size="15"/><?php echo '<br>';
            echo 'Title: '?><input type="text" name="SW_Title" value="<?php echo $sw_title ?>" size="2"/><?php
            echo '   First Name: '?><input type="text" name="SW_FirstName" value="<?php echo $sw_fname ?>" size="7"/><?php
            echo '   Last Name: '?><input type="text" name="SW_LastName" value="<?php echo $sw_lname ?>" size="7"/><?php echo '<br>';
            echo 'Phone: '?><input type="text" name="SW_Phone" value="<?php echo $sw_phone ?>" size="10"/><?php echo '<br>';
            echo 'Email: '?><input type="text" name="SW_Email" value="<?php echo $u_email ?>" size="25"/><?php
            
            ?>
<form method="post" action="<?php S_WorkerUpdate(); ?>"><input name="Update" type="submit" value="Update" /> </form>
            <?php
            
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
    /*foreach($profile as $title=>$value)
    {
        echo '<tr>
                <td style="text-align:right; padding-right: 10px;">
                    <strong>'.$title.'</strong>
                </td>

                <td>'
                    .$value.
                '</td>
                </tr>';
    }*/
    echo '</table>';
}
else
{
    echo "Error";
    echo '<div style="color: #ff3300;">';
        echo implode('<br />', $errors);
    echo '</div>';
}

function adminUpdate()
{
    $user_profile_id = sanitize($_GET['view']);
    if (isset($_POST['go']))
{
            $profileObjArray = retrieve_UserProfile_RMHAdmin($user_profile_id);
            $profileObj = is_array($profileObjArray) ? current($profileObjArray) : false;
            if($profileObj)
            {               
             $profileObj->set_usernameId($_POST["Admin_Username"]);
             $profileObj->set_userCategory($_POST["Admin_Category"]);
             $profileObj->set_userEmail($_POST["Admin_Email"]);
             
             $profileObjArray1 = update_UserProfile($user_profile_id);
             $profileObj1 = is_array($profileObjArray1) ? current($profileObjArray1) : false;
             if($profileObj1)
             {
             $profileObj->set_rmhStaffTitle($_POST["Admin_Title"]);
             $profileObj->set_rmhStaffFirstName($_POST["Admin_FirstName"]);
             $profileObj->set_rmhStaffLastName($_POST["Admin_LastName"]);
             $profileObj->set_rmhStaffPhone($_POST["Admin_Phone"]);
             
             $profileObjArray2 = update_RMHStaffProfile($user_profile_id);
             $profileObj2 = is_array($profileObjArray2) ? current($profileObjArray2) : false;
             if($profileObj2)
             {
                 header('Location: admin/listUsers.php');
             }
             else
             {
                 $errors['invalid_profile'] = "Could not complete request";
             }
             }
             
             else
             {
                 $errors['invalid_profile'] = "Could not update admin information";
             }
             
            }
            else
            {
                $errors['invalid_profile'] = "Could not update profile information";
            }
}
}

function RMHstaffApproverUpdate()
{
    $user_profile_id = sanitize($_GET['view']);
    
    if (isset($_POST['go']))
{
            $profileObjArray = retrieve_UserProfile_RMHAdmin($user_profile_id);
            $profileObj = is_array($profileObjArray) ? current($profileObjArray) : false;
            if($profileObj)
            {               
             $profileObj->set_usernameId($_POST["App_Username"]);
             $profileObj->set_userCategory($_POST["App_Category"]);
             $profileObj->set_userEmail($_POST["App_Email"]);
             
             $profileObjArray1 = update_UserProfile($user_profile_id);
             $profileObj1 = is_array($profileObjArray1) ? current($profileObjArray1) : false;
             if($profileObj1)
             {
             $profileObj->set_rmhStaffTitle($_POST["App_Title"]);
             $profileObj->set_rmhStaffFirstName($_POST["App_FirstName"]);
             $profileObj->set_rmhStaffLastName($_POST["App_LastName"]);
             $profileObj->set_rmhStaffPhone($_POST["App_Phone"]);
             
             $profileObjArray2 = update_RMHStaffProfile($user_profile_id);
             $profileObj2 = is_array($profileObjArray2) ? current($profileObjArray2) : false;
             if($profileObj2)
             {
                 header('Location: admin/listUsers.php');
             }
             else
             {
                 $errors['invalid_profile'] = "Could not complete request";
             }
             }
             
             else
             {
                 $errors['invalid_profile'] = "Could not update admin information";
             }
             
            }
            else
            {
                $errors['invalid_profile'] = "Could not update profile information";
            }
}
}

function S_WorkerUpdate()
{
    $user_profile_id = sanitize($_GET['view']);
    
    if (isset($_POST['go']))
{
            $profileObjArray = retrieve_UserProfile_RMHAdmin($user_profile_id);
            $profileObj = is_array($profileObjArray) ? current($profileObjArray) : false;
            if($profileObj)
            {               
             $profileObj->set_usernameId($_POST["SW_Username"]);
             $profileObj->set_userCategory($_POST["SW_Category"]);
             $profileObj->set_userEmail($_POST["SW_Email"]);
             
             $profileObjArray1 = update_UserProfile($user_profile_id);
             $profileObj1 = is_array($profileObjArray1) ? current($profileObjArray1) : false;
             if($profileObj1)
             {
             $profileObj->set_swTitle($_POST["SW_Title"]);
             $profileObj->set_swFirstName($_POST["SW_FirstName"]);
             $profileObj->set_swLastName($_POST["SW_LastName"]);
             $profileObj->set_swPhone($_POST["SW_Phone"]);
             
             $profileObjArray2 = update_SocialWorkerProfile($user_profile_id);
             $profileObj2 = is_array($profileObjArray2) ? current($profileObjArray2) : false;
             if($profileObj2)
             {
                 header('Location: admin/listUsers.php');
             }
             else
             {
                 $errors['invalid_profile'] = "Could not complete request";
             }
             }
             
             else
             {
                 $errors['invalid_profile'] = "Could not update admin information";
             }
             
            }
            else
            {
                $errors['invalid_profile'] = "Could not update profile information";
            }
}
}

?>
