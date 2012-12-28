<?PHP
/*
 * Brian Harrison Charles Holenstein Andrew Lucas
 */
session_start();
session_cache_expire(30);
$title = 'Managing your Account';
include ('../header.php');
?>

<html>
    <div id="container">
        <div id="content">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Managing your Account</title>
        <br/><br/>
    </head>
    <body>
        <div align ="left"><h1><strong>Managing your Account</h1><br/>
                <p>Select <i>"Manage Account"</i> from the left panel.</p>
                <p>You will now see a form with <i>Old Password, New Password and Verify Password</i>.</p>
                <ol>
                <p><b>Step 1:</b> Enter in the required information for each field in the form then select <i> "Submit"</i><BR><BR>
                    
                <p><B>Step 3:</B> If an error occurs you will be directed to go back and make the necessary corrections.<BR><BR>
                    
                <p><B>Step 4:</B> If you have no errors then your password has successfully been changed!<BR><BR>
                    
                <p><B>Step 5:</B> When you have finished you can return to any other function by selecting it on the navigation bar on the left hand side of the page.<BR><BR>    
                </ol>
    </body>
    <input type="submit" class="helpbutton" value="Back" align="bottom" onclick="location.href='../changeAccountSettings.php'" />
        </div>
        </div>
</html>
<?PHP include('../footer.php'); ?>
