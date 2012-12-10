<?PHP
/*
 * Brian Harrison Charles Holenstein Andrew Lucas
 */
session_start();
session_cache_expire(30);
$title = 'Adding a User';
include ('../header.php');
?>

<html>
    <div id="container">
        <div id="content">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Adding a User to the Database</title>
        <br/><br/>
    </head>
    <body>
        <div align ="left"><h1><strong>Adding a User to the Database</h1><br/>
                <p>Select <i>"Add New User"</i> from the left panel.</p>
                <p>You will now see a form with:</p>
                <ol>
                    <p><i>Member Type</i><br>
                    <p><i>Title</i><br>
                    <p><i>First Name</i><br>
                    <p><i>Last Name</i><br>
                    <p><i>Phone #</i><br>
                    <p><i>username</i><br>
                    <p><i>E-mail Address</i><br>
                    <p><i>Hospital Affiliation</i><br>
                </ol><BR>
                <p>Follow these steps to Add a New User to the Database</p><br><br>
                <ol>
                <p><b>Step 1:</b> Select which type of user you will add (<i>Social Worker, RMH Admin, RMH Staff Approver</i>) by selecting the correct data from the drop down menu.<BR><BR>
                    
                <p><B>Step 2:</B> Fill in the remaining information.<BR><BR>
                    
                <p><B>Step 3:</B> When you are finished entering in the criteria select the <i>"Submit"</i> button from the bottom.<BR><BR>
                    
                <p><B>Step 4:</B> If an error occurs you will be directed to go back and make the necessary corrections.<BR><BR>
                    
                <p><B>Step 5:</B> If you have no errors, all entered information will be displayed for review.<BR><BR>
                    
                <p><B>Step 6:</B> When you have finished you can return to any other function by selecting it on the navigation bar on the left hand side of the page.<BR><BR>    
                </ol>
        </body>
    <input type="submit" class="helpbutton" value="Back" align="bottom" onclick="location.href='../admin/addUser.php'" />
        </div>
        </div>
</html>
<?PHP include('../footer.php'); ?>
