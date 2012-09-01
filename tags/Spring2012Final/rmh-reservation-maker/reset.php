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
* Password Reset Page for RMH-RoomReservationMaker. 
* This page deals with resetting password for a user. A randomly generated activation code will be
* sent to the user's email address. After they click the link that has the activation code, they 
* will be presented with the ability to change their password.
*
* Work in progress because of Activation functions in the db level is not available.
*
* @author Prayas Bhattarai
* @version May 1, 2012
*/

//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Reset Password"; //This should be the title for the page, included in the <title></title>

include('header.php'); //including this will further include (globalFunctions.php and config.php)
include(ROOT_DIR.'/database/dbUserProfile.php');

$error = array(); //an array that holds the 

$testData = array('test0'=>'', 'test1'=>'activation');

    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        //the security validation was successful, perform required operation here below.
        //*** NOTE *** The validateTokenField DOES NOT filter/sanitize/clean the data fields.
        //A separate function sanitize() should be called to clean the data so that it is html/db safe
        
        //handle POST data for reset password (the default form)
        if(isset($_POST['resetPassword'])):
            
            $username = isset($_POST['username']) ? sanitize($_POST['username']) : '';

            $userRetrieved = retrieve_UserByAuth($username);
            
            //check the database, if the username exists or not
            if($userRetrieved)
            {
                //the user exists, create a random string as an activation code and send an email
                //store the activation code in the DB
                
                //check the activation table for the user's info and expiry, 
                //if it is already there notify the user to check their email again
                if(!empty($testData[$username]) && true)
                {
                    //maybe let them resend the email again?
                    $message = 'A password reset information has already been sent to your email. Please check your email for more information.';
                }
                else
                {
                    //if the user has never requested a password reset before, go ahead and proceed with creating the activation key
                    $activation_code = generateRandomString();
                    $_SESSION['_activation'] = array($username => $activation_code); //stored in the session for test purpose -- to check the post data
                    //store this code in the database
                    //======> database store function goes here

                    //send an email
                    //=======> send email function goes here

                    //if everything was successful, notify the user
                    $message = 'A password reset information has been sent to your email. Please check your email for more information.';

                    $message .= ' TEST: click the link to reset your password <a href="'.'reset.php?activation='.$activation_code.'&user='.$username.'">RESET</a>';
                }
            }
            else
            {
                $error['invalid_user'] = 'Please enter a valid username registered with the system';
            }
           //handle POST data for change password form, the form that gets displayed after the activation code is verified
          elseif(isset($_POST['changePassword'])):
              
              if(isset($_POST['newpass']) && isset($_POST['verifypass']))
              {
                  $data_newPassword = sanitize($_POST['newpass']);
                  $data_verifyPassword = sanitize($_POST['verifypass']);
                  $data_user = sanitize($_POST['username']);
                  $data_activation = sanitize($_POST['activation']);
                  
                  if($data_newPassword != '' && $data_newPassword == $data_verifyPassword)
                  {
                      //new password is not empty and matches the verify password field
                      
                      //re-validate the user and activation combo with the database (maybe this can be changed to a function as it is being called multiple times?)
                      if(isset($_SESSION['_activation'][$data_user]) && $_SESSION['_activation'][$data_user] == $data_activation)
                      {
                          //database lookup for activation-username combo + expiry date is valid, so proceed:
                          
                          //Do a database call to change the password
                          $message = 'Your password has been changed successfully. Please return to the login page to login with your new password';
                         
                          //remove the activation information from the database
                          unset($_SESSION['_activation']);
                      }
                      else
                      {
                          $error['invalid_token'] = 'An invalid password reset token was supplied. The token might have expired or you are trying to reuse the activation token. Please restart the reset process by returning to the login page.';
                      }
                      
                  }
                  else
                  {
                      $error['invalid_password'] = 'Invalid Password supplied';
                  }
              }
              else
              {
                  $error['invalid_fields'] = 'Invalid data fields';
              }
              $newPassForm = generateChangePassForm($data_activation, $data_user);
              
          endif;
        
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        //'The request could not be completed: security check failed!'
        $error['csrf'] = 'The request could not be completed: security check failed!';
    }
    else if(isset($_GET['activation']) && isset($_GET['user']))
    {
        //activation code was set in the get parameter
        $activation = sanitize($_GET['activation']);
        $user = sanitize($_GET['user']);
        
        //check if the username & activation code combination is available in the database and has not expired
        if(isset($_SESSION['_activation']) && $_SESSION['_activation'][$user] == $activation)
        {
            //activation code and user matches and has not expired. Display the form that shows new password fields
            
            $newPassForm = generateChangePassForm($activation, $user);
        }
        else
        {
            $error['invalid_activation'] = 'Error: Invalid activation token supplied.';
        }
    }

/**
 * generateChangePassForm function generates the change password form.
 * 
 * @param string $activation the activation code
 * @param string $user the username
 * 
 * @return string that has all the form elements 
 */
 function generateChangePassForm($activation, $user)
 {
    $newPassForm = '<form method="post" action="reset.php">';
    $newPassForm .= generateTokenField();

    //store activation key to verify the POST data
    $newPassForm .= '<input type="hidden" id="activation" name="activation" value="'.$activation.'" />';

    //store username to verify the POST data
    $newPassForm .= '<input type="hidden" id="username" name="username" value="'.$user.'" />';

    $newPassForm .= '<label for="newpass">New Password</label>
                    <input type="text" name="newpass" id="newpass"/>
                        <label for="verifypass">Verify Password</label>
                        <input type="text" name="verifypass" id "verifypass" />
                        <input type="submit" name="changePassword" id="changePassword" value="Change Password"/>
                        </form>';
    return $newPassForm;
 }

?>

<div id="container">
    <div id="pad"></div>
    <div id="content">
        <?php
        if(!empty($error))
        {
            echo '<div style="color:#f00;">';
            echo implode('<br />', $error);
            echo '</div>';
        }
        
        if(isset($message))
        {
            echo '<div style="color:#458B00;">';
            echo $message; //notify user about the password reset
            echo '</div>';
        }
        
        else if(isset($newPassForm))
        {
            echo $newPassForm;
        }
        else
        {
            //default reset form
        ?>
                <p>Please enter your username below to reset the password.</p>
                <p>Password reset information will be sent to the email that was used to register your account.</p>
                <p>Please check your email and follow the instructions to complete the password reset process.</p>
            <form method="post" action="reset.php">
                    <?php echo generateTokenField(); ?>

                    <label class="not noShow" for="username">Username</label>
                    <input class="formt formSingle" type="text" name="username" id="username"/>

                    <input type="submit" name="resetPassword" id="resetPassword" value="Reset"/>
            </form>
        <?php
        }
        ?>
                <div id="back"><a href="login.php">Back</a></div>
    </div>
</div>
<?php 
include ('footer.php'); //include the footer file, this contains the proper </body> and </html> ending tag.
?>

