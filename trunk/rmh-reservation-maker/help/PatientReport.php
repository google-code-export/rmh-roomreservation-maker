<?PHP
/*
 * Brian Harrison Charles Holenstein
*/
	session_start();
	session_cache_expire(30);
        $title = 'Patient Reports';
        include ('../header.php');
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Patient Reports</title>
    </head>
    <body>
        <div align="left"><p><strong>Patient Reports</strong>
          
                <p><B>Step 1:</B>Select <i>"Report"</i> from the left panel.<BR><BR>
                    
                <p><B>Step 2:</B>Select start and end date of stay. Then enter Hospital name to search.<BR><BR>
                    
                <p><B>Step 3:</B>If any information is left blank you will not be able to proceed until the errors are corrected.
                    If the Hospital name is left blank it will automatically search all hospitals.<BR><BR>
                    
                <p><B>Step 4:</B>A generated report will be displayed.<BR><BR>
                    
                <p><B>Step 5:</B>When you finish you can return to any function by selecting it on the navigation bar.<BR><BR>    
                    
    </body>
</html>
<?PHP include('../footer.php'); ?>

