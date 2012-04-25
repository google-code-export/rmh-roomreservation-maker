<?php
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
?>
