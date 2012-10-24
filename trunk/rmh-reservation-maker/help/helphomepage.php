<?PHP
/*
 * Brian Harrison Charles Holenstein
*/
	session_start();
	session_cache_expire(30);
        $title = 'Help Homepage';
        include ('../header.php');
?>
<html>
	<head>
		<title>
			RMH Reservation Maker
		</title>
	</head>
	<body><br><br><br>
            <div align="center">
<ol>
		<li>	<a href="Loginhelp.php">Signing into the System</a></li><br>
			<!--<ul><li><a href="?helpPage=index.php">About your Personal Home Page</a></li></ul><br> -->
		<li>	<strong>Working with People in the Database</strong> (Managers Only)</li><br>
			 <ul><li><a href="Addingpeople.php">Adding People to the Database</a></li>
			    <li><a href="approveroomrequest.php">Approving a room request</a></li>
			    <li><a href="PatientReport.php">Patient Report </a></li>
			</ul><br>
		<li>	<a href="?helpPage=roomLog.php">Working with Room Logs</a> (Volunteers and Managers)</li><br>
				<br>
		 <li>   <a href="?helpPage=viewBookings.php">Working with Bookings and Referral Forms</a> (Social Workers and Managers)</li> -->
</ol>
		<p>If these help pages don't answer your questions, please contact the <a href="mailto:housemngr@rmhportland.org">House Manager</a>.</p>
	</body>
</html>
<?PHP include('../footer.php'); ?>


