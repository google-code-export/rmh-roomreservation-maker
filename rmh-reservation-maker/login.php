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
//check for user and add session variables
//This check should be replaced by the tokenValidator function
if(isset($_POST['form_token']) && validateTokenField($_POST))
{

    //sanitize all these data before they get to the database !! IMPORTANT

    $db_pass = getHashValue($_POST['password']); //md5($_POST['password']); //instead of mdf we will use another function that will do the hashing probably sha1 or sha256 using a salt
    $db_id = sanitize($_POST['username']);

    if($db_pass == getHashValue('test') && $db_id == 'test')
    {
        print_r($_POST);
        $_SESSION['logged_in'] = true;
        $_SESSION['access_level'] = 3; //0-3
        $_SESSION['id'] = $db_id;

        echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
        exit();
    }
    else
    {
        $error['invalid_username'] = "The username or password provided does not match";
    }

    /*
      $person = retrieve_dbPersons($db_id);

      //	echo $person->get_id() . " = retrieved person_id<br>";
      if($person)
      { //avoids null results
      if($person->get_password() == $db_pass)
      { //if the passwords match, login
      $_SESSION['logged_in'] = 1;
      if(in_array('volunteer', $person->get_type()))
      $_SESSION['access_level'] = 1;
      else if(in_array('socialworker', $person->get_type()))
      $_SESSION['access_level'] = 2;
      else if(in_array('manager', $person->get_type()))
      $_SESSION['access_level'] = 3;
      else
      $_SESSION['access_level'] = 0;
      $_SESSION['f_name'] = $person->get_first_name();
      $_SESSION['l_name'] = $person->get_last_name();
      $_SESSION['_id'] = $_POST['user'];
      echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
      }
      else
      {
      echo('<div align="left"><p class="error">Error: invalid username/password.');

      echo('<p>If you are a volunteer, social worker, or manager, your Username is your first name followed by your phone number with no spaces. ' .
      'For instance, if your first name were John and your phone number were (207)-123-4567, ' .
      'then your Username would be <strong>John2071234567</strong>.  ');
      echo('<br /><br />if you cannot remember your password, ask the <a href="mailto:housemngr@rmhportland.org">House Manager</a> to reset it for you.</p>');
      echo('<p><table><form method="post"><input type="hidden" name="_submit_check" value="true"><tr><td>Username:</td><td><input type="text" name="user" tabindex="1"></td></tr><tr><td>Password:</td><td><input type="password" name="pass" tabindex="2"></td></tr><tr><td colspan="2" align="center"><input type="submit" name="Login" value="Login"></td></tr></table>');
      }
      }
      else
      {
      //At this point, they failed to authenticate
      echo('<div align="left"><p class="error">Error: invalid username/password.');

      echo('<p>If you are a volunteer, social worker, or manager, your Username is your first name followed by your phone number with no spaces. ' .
      'For instance, if your first name were John and your phone number were (207)-123-4567, ' .
      'then your Username would be <strong>John2071234567</strong>.  ');
      echo('<br /><br />if you cannot remember your password, ask the <a href="mailto:housemngr@rmhportland.org">House Manager</a> to reset it for you.</p>');
      echo('<p><table><form method="post"><input type="hidden" name="_submit_check" value="true"><tr><td>Username:</td><td><input type="text" name="user" tabindex="1"></td></tr><tr><td>Password:</td><td><input type="password" name="pass" tabindex="2"></td></tr><tr><td colspan="2" align="center"><input type="submit" name="Login" value="Login"></td></tr></table>');
      }
     * */
}
else if(isset($_POST['form_token']) && !validateTokenField($_POST))
{
    //if data was posted but the token was invalid then add it to the error array
    $error['csrf'] = 'The request could not be completed: security check failed!';
}
else
{
    //if no data was submitted then display the login form:

    if(($_SERVER['PHP_SELF']) == "/logout.php")
    {
        //prevents infinite loop of logging in to the page which logs you out...
        echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
    }
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
                            Access to <i>Homeroom</i> requires a Username and a Password.
                    </p>
                    <ul class="hometext">
                            <li>You must be a Ronald McDonald House <i>staff member</i> or <i>social worker</i> to access this system.</li>
                            <li>If you do not remember your Password, [forgot password link should go here?]</li>
                    </ul>
                    <div>
                            <form method="post" action="login.php">
                                    <?php echo generateTokenField(); ?>
                                    <div>
                                            <label for="username">Username</label><input class="formtop formt" type="text" name="username" id="username" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?username:this.value;" value="username"/>
                                    </div>
                                    <div>
                                            <label for="password">Password</label><input class="formbottom formt" type="password" name="password" id="password"onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?password:this.value;" value="password"/>
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