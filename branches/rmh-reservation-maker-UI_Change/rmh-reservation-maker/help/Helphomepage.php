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
	<body>
		<p><strong>RMH Reservation Maker Help Pages</strong></p>
<ol>
		<li>	<a href="loginhelp.php">Signing into the System</a></li><br>
			<ul><li><a href="?helpPage=index.php">About your Personal Home Page</a></li></ul><br>
		<li>	<strong>Working with People in the Database</strong> (Managers Only)</li><br>
			<ul><li><a href="searchhelp.php">Searching for People</a></li>
			    <li><a href="editingpeoplehelp.php">Editing People</a></li>
			    <li><a href="addingpeoplehelp.php">Adding People </a></li>
			</ul><br>
		<li>	<a href="?helpPage=roomLog.php">Working with Room Logs</a> (Volunteers and Managers)</li><br>
				<br>
		 <li>   <a href="?helpPage=viewBookings.php">Working with Bookings and Referral Forms</a> (Social Workers and Managers)</li>
</ol>
		<p>If these help pages don't answer your questions, please contact the <a href="mailto:housemngr@rmhportland.org">House Manager</a>.</p>
	</body>
</html>
<?PHP include('../footer.php'); ?>

