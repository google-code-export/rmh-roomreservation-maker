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
        <title>Search Profile Activity</title>
        <br/><br/>
    </head>
    <body>
        <div align ="left"><h1><strong>Search Profile Activity</h1><br/>
                <p>Select <i>"Approve Family Profile Changes"</i> from the left panel.</p>
                <p>You will now see a form with requesting you to <i>"Enter request ID:"</i>.</p>
                <ol>
                <p><b>Step 1:</b> Enter in the desired <i> "ID"</i> number.<BR><BR>
                    
                <p><B>Step 2:</B> Hit the submit button.<BR><BR>
                    
                <p><B>Step 3:</B> If an error occurs you will be directed to go back and make the necessary corrections.<BR><BR>
                    
                <p><B>Step 4:</B> If you have no errors then your requested information will be displayed.<BR><BR>
                    
                <p><B>Step 5:</B> When you have finished you can return to any other function by selecting it on the navigation bar on the left hand side of the page.<BR><BR>    
                </ol>
    </body>
    <input type="submit" class="helpbutton" value="Back" align="bottom" onclick="location.href='../searchProfileActivity.php'" />
        </div>
        </div>
</html>
<?PHP include('../footer.php'); ?>
