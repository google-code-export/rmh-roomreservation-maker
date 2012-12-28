<?PHP
/*
 * Brian Harrison Charles Holenstein
 */
session_start();
session_cache_expire(30);
$title = 'Searching for Reservations';
include ('../header.php');
?>

<html>
    <div id="container">
        <div id="content">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Search Reservations Help</title>
        <br/><br/>
    </head>
    <body>
        <div align ="left"><h1><strong>Searching Reservations</h1><br/>
                <p>Select <i>"Search Reservations"</i> from the left panel.</p>
                <p>You will now see a form with <i>"Select Search Type"</i> followed by a drop down list with possible search types</p>
                <ol>
                <p><b>Step 1:</b> Select the drop down arrow in the <i>"Select Search Type" </i> box.<BR><BR>
                    
                <p><B>Step 2:</B> Select which criteria you will search.<BR><BR>
                    
                <p><B>Step 3:</B> In the box below, enter the last name of the <i>Social Worker, Staff Approver or Family </i> or <i> Status </i> you are searching for.<BR><BR>
                  
                <p><B>Step 4:</B> Next, hit the <i> "Search" </i> button. <BR><BR>
                    
                <p><B>Step 5:</B> If you have no errors, all entered information will be displayed for review.<BR><BR>
                    
                <p><B>Step 6:</B> When you have finished you can return to any other function by selecting it on the navigation bar on the left hand side of the page.<BR><BR>    
                </ol>    
    </body>
    <input type="submit" class="helpbutton" value="Back" align="bottom" onclick="location.href='../reservation/SearchReservations.php'" />
        </div>
        </div>
</html>
<?PHP include('../footer.php'); ?>
