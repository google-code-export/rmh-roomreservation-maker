<?PHP
/*
* Brian Harrison Charles Holenstein 
*/
	session_start();
	session_cache_expire(30);
        $title = 'Login Help';
        include ('../header.php');
?>
<html>
    <div id="container">
        <div id="content">
	<head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <title>Login Help</title>
            <br/><br/>
	</head>
	<body>
            </br></br>
		<div align="left"><h1><strong> Signing in and out of the System</h1>
		<p>Access to <i>RMH Reservation Maker</i> requires a Username and a Password.</p>
		<p>Once you sign in you will be able to fill out and submit a <b>room request</b> form on-line.
			<p>If you are a <i>volunteer, social worker, or staff member</i>, your Username is your first name followed by your phone number with no spaces.
			<ul><li>For example, if your first name is John and your phone number is (207)-123-4567, your Username would be <strong>John2071234567</strong>.</ul>
				<p>Remember that your Username and Password are <em>case-sensitive</em>.</p>
				<p>If you mistype your Username or Password, the following error message will appear:
                                <ul><li class="error">The username or password provided does not match.</li></ul>
				<p> At this point, you can retry entering your Username and Password (if you think you may have mistyped them)</p>
				<p>If you need to reset your password just <a href="../reset.php">click here</a>.</p></a>
			
<p> Remember to <strong>logout</strong> when you are finished using RMH Reservation Maker.
	</body>
        </br></br>
           <input class="helpbutton" type="submit" value="Back" align="bottom" onclick="location.href='../login.php'" />
        </div>
        </div>    
    </div>
</html>
<?PHP include('../footer.php'); ?>


