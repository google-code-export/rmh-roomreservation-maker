<?PHP
/*
 * Brian Harrison Charles Holenstein Andrew Lucas
*/
	session_start();
	session_cache_expire(30);
        $title = 'Patient Reports';
        include ('../header.php');
?>
<html>
   <div id="container">
        <div id="content">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Generating Reports</title>
        <br/><br/>
    </head>
    <body>
            <div align ="left"><h1><strong>Generating a Patient Report</h1><br/>
                <p>Select <i>"Report"</i> from the left panel.</p>
                <p>You will now see a form with <i>"Start Date"</i> and <i> "End Date" </i></p>
                <ol>
                <p><b>Step 1:</b> Select the correct <i>"Start Date"</i> by selecting the correct data from each drop down menu.<BR><BR>
                    
                <p><B>Step 2:</B> Select the correct <i>"End Date"</i> by selecting the correct data from each drop down menu.<BR><BR>
                    
                <p><B>Step 3:</B> When you are finished entering in the criteria select the <i>"Submit"</i> button from the bottom.<BR><BR>
                    
                <p><B>Step 4:</B> If an error occurs you will be directed to go back and make the necessary corrections.<BR><BR>
                    
                <p><B>Step 5:</B> If you have no errors, all entered information will be displayed for review.<BR><BR>
                    
                <p><B>Step 6:</B> When you have finished you can return to any other function by selecting it on the navigation bar on the left hand side of the page.<BR><BR>    
                </ol>
    </body>
    <input class="helpbutton" type="submit" value="Back" align="bottom" onclick="location.href='../report.php'" />
        </div>
        </div>
    </div>
</html>
<?PHP include('../footer.php'); ?>

