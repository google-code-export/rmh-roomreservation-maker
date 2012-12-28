<?php

include('../core/config.php');
include_once(ROOT_DIR.'/database/dbUserProfile.php');


echo "testing retrieve_UserProfile_RMHStaffApprover by profile id";
test_retrieve_UserProfile_RMHStaffApprover('3');



function test_retrieve_UserProfile_RMHStaffApprover($userProfileId)
{
    $users =retrieve_UserProfile_RMHStaffApprover($userProfileId);

if ($users == false)
    echo "</br>". "No user were  found";
else
{
    echo  "</br>". "found  user".  "</br>";
    foreach ($users as $user)
    {
         display_user($user);
    }
}
}

function display_user($user)
{
    echo "id is " . $user->get_userProfileId() .  "</br>";
    echo "user category is " . $user->get_userCategory () .  "</br>";
    echo "User name is " . $user->get_usernameId() .  "</br>";
    echo "Email is " . $user->get_userEmail() .  "</br>";
    echo "Password is " . $user->get_password() .  "</br>";
    echo "RMH staff id is " . $user->get_rmhStaffProfileId() .  "</br>";
    echo "Title is " . $user->get_rmhStaffTitle() .  "</br>";
    echo "First name is " . $user->get_rmhStaffFirstName() .  "</br>";
    echo "Last name  is " . $user->get_rmhStaffLastName() .  "</br>";
    echo "Phone is " . $user->get_rmhStaffPhone() .  "</br>";
    
}



echo"</br>";
echo "<b>Testing retrieve all user probile by by role or user category.  Will return all information for all users pertaining to that role</b>";
test_retrieve_all_UserProfile_byRole('Social Worker');

function test_retrieve_all_UserProfile_byRole($userCategory)
{
    $users =retrieve_all_UserProfile_byRole($userCategory);

if ($users == false)
    echo "</br>". "No user were  found";
else
{
    echo  "</br>". "found  records".  "</br>";
    foreach ($users as $user)
    {
         display_all_user($user);
    }
}
}

function display_all_user($user)
{
    echo"</br>";
    echo " " . $user->get_swTitle() .  "";
    echo" ". $user->get_swFirstName() .  "";
    echo" ". $user->get_swLastName() .  "</br>";
    echo " ID is " . $user->get_userProfileId() .  " ,";
    echo "User Category is " . $user->get_userCategory () .  " ,";
    echo "User name is " . $user->get_usernameId() .  " ,";
    echo "Email is " . $user->get_userEmail() .  " ,";
    echo "Password is " . $user->get_password() .  " ,";
    echo "SW id is " . $user->get_swProfileId() .  " ,";
    echo "Phone is " . $user->get_swphone() .  "  ,";
    echo "Hospital Affiliation is " . $user->get_hospitalAff() .  " ,";
    echo "Email Notification is " . $user->get_email_notification() .  "</br>";
 }
?>
