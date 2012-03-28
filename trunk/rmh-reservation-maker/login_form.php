<?php
/**
 * sanitize function
 * @param string the field that needs to be sanitized
 * @return string sanitized data 
 */
function sanitize($data)
{
    //this function should sanitize the data. This should probably included in some global function file so that everybody will be able to use it.

    return $data;
}

//content for the login form. This needs to be displayed even in case of error.
            $loginContent = '<div align="left"><p>Access to <i>Homeroom</i> requires a Username and a Password. ';


            $loginContent .= '<ul>';
            $loginContent .= '<li>You must be a Ronald McDonald House <i>staff member or social worker</i> to access this system.</li>';
            $loginContent .= '<li>If you do not remember your Password, [forgot password link should go here?]</li>';
            $loginContent .= '</ul>';

            //The actual login form:
            $loginContent .= '<div>';//login form box
                $loginContent .= '<form method="post">';
                $loginContent .= '<input type="hidden" name="form_token" value="true">';//this should be replaced with the CSRF check function

                //row div:
                $loginContent .= '<div>';//will have "row" class once the stylesheet has been added
                    $loginContent .= '<label for="username">Username</label>';
                    $loginContent .= '<input type="text" name="username" id="username">';
                $loginContent .= '</div>';

                //row div:
                $loginContent .= '<div>';
                    $loginContent .= '<label for="password">Password</label>';
                    $loginContent .= '<input type="password" name="password" id="password">';
                $loginContent .= '</div>';

                //row div:
                $loginContent .= '<div>';
                    $loginContent .= '<input type="submit" name="Login" value="Login">';
                $loginContent .= '</div>';

            $loginContent .= '</div>';//end of login form box

    $error = array(); //variable that stores all the errors that occur in the login process
    //if data is submitted then do the following:
    
    //check for user and add session variables
    
    //This check should be replaced by the tokenValidator function
    if(array_key_exists('form_token', $_POST))
    {
        //sanitize all these data before they get to the database !! IMPORTANT
        
        $db_pass = $_POST['password'];//md5($_POST['password']); //instead of mdf we will use another function that will do the hashing probably sha1 or sha256 using a salt
        $db_id = sanitize($_POST['username']);
        
        if($db_pass=='test' && $db_id=='test')
        {
            $_SESSION['logged_in'] = true;
            $_SESSION['access_level'] = 3; //0-3
            $_SESSION['id'] = $db_id;
            
           echo '<div style="color: green;">login successful</div>';
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
<div id="content">
    <?PHP
           
    if(!empty($error))
    {
           echo '<div style="color:#f00;">';
         echo implode('<br />',$error);
          echo '</div>';
     }
           echo $loginContent; 
    ?>
<?PHP //include('footer.inc'); ?>
</div>
</body>
</html>
