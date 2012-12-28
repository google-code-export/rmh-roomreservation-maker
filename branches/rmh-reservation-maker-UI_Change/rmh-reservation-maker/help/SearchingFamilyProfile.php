<?PHP
/*
 * Brian Harrison Charles Holenstein
 */
session_start();
session_cache_expire(30);
$title = 'Searching for a Family Profile';
include ('../header.php');
?>

<html>
    <div id="container">
        <div id="content">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Searching for a Family Profile</title>
        <br/><br/>
    </head>
    <body>
            <div align ="left"><h1><strong>Searching for a Family Profile</h1><br/>
                <p>Select <i>"Family Profile"</i> from the left panel.</p>
                <p>Now Select <i>"Search for Families"</i></p>
                <p>You will now see a form with <i>"First Name"</i> and <i> "Last Name" </i></p>
                <ol>
                <p><b>Step 1:</b> Enter in the required information for each field in the form then select <i> "Search"</i><BR><BR>
                    
                <p><B>Step 2:</B> When you are finished, select the <b>Submit</b> button at the bottom of the page. <BR><BR>
                    
                <p><B>Step 3:</B> If an error occurs you will be directed to go back and make the necessary corrections.<BR><BR>
                    
                <p><B>Step 4:</B> If you have no errors, all entered information will be displayed for review.<BR><BR>
                    
                <p><B>Step 5:</B> When you have finished you can return to any other function by selecting it on the navigation bar on the left hand side of the page.<BR><BR>    
                </ol>
    </body>
    <!-- <input type="button" value="Back" align="center" onclick="location.href='../family/SearchFamily.php'" /> -->
    <input class="helpbutton" type="submit" value="Back" align="bottom" onclick="location.href='../family/SearchFamily.php'" />
        </div>
        </div>
    </div>
</html>
<?PHP include('../footer.php'); ?>
