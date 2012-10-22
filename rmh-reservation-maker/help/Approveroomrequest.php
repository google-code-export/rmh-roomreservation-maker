<?PHP
/*
 * Brian Harrison Charles Holenstein
*/
	session_start();
	session_cache_expire(30);
        $title = 'Approving Reservation Requests';
        include ('../header.php');
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Approving Reservation Requests</title>
    </head>
    <body>
        <div align="left"><p><strong>Approving Reservation Requests</strong>
          
                <p><B>Step 1:</B>Select <i>"Search Reservation"</i> from the left panel.<BR><BR>
                    
                <p><B>Step 2:</B>Select request ID and enter request ID into text box. Then click search.<BR><BR>
                    
                <p><B>Step 3:</B>One request will be displayed to select.<BR><BR>
                    
                <p><B>Step 4:</B>The displayed request will have an approve or deny button.<BR><BR>
                    
                <p><B>Step 5:</B>After you make a selection you will be redirected to the home page.<BR><BR>    
                    
    </body>
</html>
<?PHP include('../footer.php'); ?>

