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
* Login script for RMH-RoomReservationMaker. 
* All the login code goes here, including username password check, setting session variables and checking for default password
* @author Prayas Bhattarai
* @version May 1, 2012
*/
session_start();
session_cache_expire(30);
$title = 'Login';
include('header.php');

//Alter the content class based on user's login status ----> WHY IS THIS EVEN NECESSARY??!
if(isset($_SESSION['logged_in']))
    $classAdd = 'content' ; 
else $classAdd = 'contentLogin';

    //Access Level (Should match UserCategory in DB):
    $accessLevel = array(
                        'Family'=>0,
                        'Social Worker'=>1,
                        'RMH Staff Approver'=>2,
                        'RMH Administrator'=>3
                        );
    
$error = array(); //variable that stores all the errors that occur in the login process
//if data is submitted then do the following:
//validate the token
//if token validates, check for user and add session variables
if(isset($_POST['form_token']) && validateTokenField($_POST))
{

    //sanitize all these data before they get to the database !! IMPORTANT

    $db_pass = getHashValue($_POST['password']);
    $db_username = sanitize($_POST['username']);
    
    include_once(ROOT_DIR.'/database/dbUserProfile.php');

    //Retrieve the user category using the username and password
    $currentUser = retrieve_UserByAuth($db_username, $db_pass);
    
    if($currentUser)
    {
        //if the usercategory is returned, log the user in and assign session variables
        $_SESSION['logged_in'] = true;
        $_SESSION['access_level'] = $accessLevel[$currentUser['UserCategory']];
        $_SESSION['_username'] = $db_username;
        $_SESSION['_id'] = $currentUser['UserProfileID'];
        
        checkDefaultPassword(); //check if the user is still using the default password
        
        echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
        exit();
    }
    else
    {
        //if no user category was found, then the credentials were wrong
        $error['invalid_username'] = "The username or password provided does not match";
    }
}
else if(isset($_POST['form_token']) && !validateTokenField($_POST))
{
    //if data was posted but the token was invalid then add it to the error array
    $error['csrf'] = 'The request could not be completed: security check failed!';
}
?>
<?php 
/*How should errors be displayed:
 * if(!empty($error))
        {
            echo '<div style="color:#f00;">';
            echo implode('<br />', $error);
            echo '</div>';
        }
        ?>
 */
?>
<section>
	<div class="mainLogo"></div>
    <div class="boxHolder">
        <p class="notice" style="top:1em;">You must be a Ronald McDonald House staff member or social worker to access this system.</p>
        <div class="loginbox">        		
	    	<form class="loginForm" method="post" action="login.php">
	    	<?php echo generateTokenField(); ?>
	        	<label for="username">Username</label>
	        	<input type="text" name="username" id="username" />
	        	<label for="password">Password</label>
	        	<input type="password" name="password" id="password" />
	        	<input class="btn submitButton" type="submit" name="login" value="Login"/>
	        </form>
	        <div class="clearfix"></div>
		</div>
 	</div>
</section>        


<?php 
/* The following code needs to be incorporated:
 * 	- a link to help page
 *  - a link to forgot password/username page
 */
/* Current implementation:
  <input class="helpbutton" type="submit" value="Help" align="bottom" onclick="location.href='./help/LoginHelp.php'" />
                </br></br>
    </div>
    <?php include('footer.php');
    
    echo '<td>Lost your Password?  <a href="changeAccountSettings.php">Password Reset</a></td>';
 */
    
    
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

/**
 * checkDefaultPassword function that checks if the currently logged in user is using a default password. Sets a session message which is displayed when the user is redirected to the index page, which suggests the user to change their password.
 * @author Prayas Bhattarai
 * @return boolean 
 */
function checkDefaultPassword()
{
    $userProfile = retrieveCurrentUserProfile();
    $currentPass = $userProfile->get_password();
    
    if(getUserAccessLevel() == 1)
    {
        //use functions for social workers
        $fname = $userProfile->get_swFirstName();
        $phone = $userProfile->get_swphone();
        
    }
    else if(getUserAccessLevel() > 1)
    {
        //use functions for rmh staff
        $fname = $userProfile->get_rmhStaffFirstName();
        $phone = $userProfile->get_rmhStaffPhone();
    }
    else
    {
        return false;
    }
    
    $defaultPass = trim(strtolower($fname)).trim(substr($phone, -4));
    $defaultPass = getHashValue($defaultPass);
    
    if($defaultPass != $currentPass)
    {
        return true;
    }
    else
    {
        setSessionMessage(array('default_pass'=>'You are using the default password for your account. It is advised that you change your password immediately by clicking on the "Manage Account" section.'));
    }
    
}
    ?>