<?PHP
/*
 * Brian Harrison Charles Holenstein Andrew Lucas
 */
session_start();
session_cache_expire(30);
$title = 'Viewing Users';
include ('../header.php');
?>

<html>
    <div id="container">
        <div id="content">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Viewing a Users Information</title>
        <br/><br/>
    </head>
    <body>
        <div align="left"><p><strong>Viewing User Information</strong>
          <p>Select <i>"View Users"</i> from the left panel.</p><BR><BR>
                <p>You will now see a form with a drop down list labeled <i>"Show users: "</i>.</p><BR><BR>
                
                <p>You can select to view <i>All users, RHM Administrators, RMH Staff Approvers or Social Workers</i>.</p><BR><BR>
                
                <p>Once your criteria is selected, all of the data will be displayed on the page.</p><BR><BR>
                
                <p>You will be able to <i>view the users information, edit the information or delete a profile</i>.</p><BR><BR>
                
                <p>When you have finished you can return to any other function by selecting it on the navigation bar on the left hand side of the page.</p><BR><BR>    
       
    </body>
    <input type="submit" class="helpbutton" value="Back" align="bottom" onclick="location.href='../admin/listUsers.php'" />
        </div>
        </div>
</html>
<?PHP include('../footer.php'); ?>
