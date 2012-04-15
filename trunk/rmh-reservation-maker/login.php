<?php
/**
 * @author Prayas Bhattarai 
 */
session_start();
session_cache_expire(30);
$title = 'Login';
include('header.php');



$error = array(); //variable that sstores all the errors that occur in the login process
//if data is submitted then do the following:
//validate the token
//if token validates, check for user and add session variables
if(isset($_POST['form_token']) && validateTokenField($_POST))
{

    //sanitize all these data before they get to the database !! IMPORTANT

    $db_pass = getHashValue($_POST['password']);
    $db_id = sanitize($_POST['username']);
    
    include_once(ROOT_DIR.'/database/dbUserProfile.php');

    //Retrieve the user category using the username and password
    $userCategory = retrieve_UserByAuth($db_id, $db_pass);
    if($userCategory)
    {
        //if the usercategory is returned, log the user in and assign session variables
        $_SESSION['logged_in'] = true;
        $_SESSION['access_level'] = $accessLevel[$userCategory];
        $_SESSION['_id'] = $db_id;        
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

<div id="container">
    <div id="content">
        <?PHP
        if(!empty($error))
        {
            echo '<div style="color:#f00;">';
            echo implode('<br />', $error);
            echo '</div>';
        }
        ?>


        <div id="loginforms">
            <div>
                    <p>
                            Access to <i>Room reservation maker</i> requires a Username and a Password.
                    </p>
                    <ul class="hometext">
                            <li>You must be a Ronald McDonald House <i>staff member</i> or <i>social worker</i> to access this system.</li>
                            <li>If you do not remember your Password, <a href="reset.php">click here to reset it.</a></li>
                    </ul>
                    <div>
                            <form class="loginForm"method="post" action="login.php">
                                    <?php echo generateTokenField(); ?>
                                    <div>
                                            <label class="noShow not" for="username">Username</label><input class="formtop formt" type="text" name="username" id="username" onfocus="if(this.value == 'username') { this.value = ''; }" value="username"/>
                                    </div>
                                    <div>
                                            <label class="noShow not"for="password">Password</label><input class="formbottom formt" type="password" name="password" id="password" onfocus="if(this.value == 'password') { this.value = ''; }" value="password"/>
                                    </div>
                                    <div>
                                            <input class="formsubmit" type="submit" name="Login" value="Login"/>
                                    </div>
                            </form>
                    </div>
            </div>
	</div>
    </div>
    <?php include('footer.php'); ?>