<?php
/*
Brian Harrison Charles Holenstein
 */
session_start();
session_cache_expire(30);
$title = 'Reservation Search Help';
include ('../header.php');

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>How to edit a Persons Information in the Database</title>
    </head>
    <body>
        <div align ="Left"><p><strong>How to edit a Persons Information in the Database</strong><BR>
                
                <p><B>Step 1:</B> Select <i>"New Referral"</i> from the left panel.<BR><BR>
                    
                <p><B>Step 2:</B>You will now be able to search for a person by first and last name.<BR><BR>
                    
                <p><B>Step 3:</B>You will now see a page with all requested persons information.<BR><BR>
                    
                <p><B>Step 4:</B>To change any of the information re-type or select it.<BR><BR> 
                    
                <p><B>Step 5:</B>If any errors were made a warning will inform you of what needs to be corrected.<BR><BR>
                    
                <p><B>Step 6:</B>If you have no errors a message will tell you that the edit was successful.<BR><BR>
                    
                <p><B>Step 7:</B>When you finish you can return to any other function by selecting it on the navigation bar.<BR>    
                
        
    </body>
</html>
<?PHP include('../footer.php'); ?>


